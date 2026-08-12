<?php

namespace App\Services;

use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\SyncLog;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PendudukSyncService
{
    /**
     * Prefix kolom anggota keluarga di Google Sheets
     */
    private const MEMBER_FIELDS = [
        'tambah' => 'Tambah Anggota Keluarga %d?',
        'hubungan' => 'Status Hubungan Anggota %d',
        'nama' => 'Nama Anggota %d',
        'jenis_kelamin' => 'Jenis Kelamin Anggota %d',
        'tanggal_lahir' => 'Tanggal Lahir Anggota %d',
        'agama' => 'Agama Anggota %d',
        'pendidikan' => 'Pendidikan Terakhir Anggota %d',
        'pekerjaan' => 'Jenis Pekerjaan Anggota %d',
    ];

    private array $summary = [
        'families_inserted' => 0,
        'families_updated' => 0,
        'members_inserted' => 0,
        'members_updated' => 0,
        'rows_skipped' => 0,
        'error_count' => 0,
        'error_details' => [],
    ];

    /**
     * Jalankan sinkronisasi data dari Google Sheets ke database.
     *
     * @param  array  $structuredData  Output dari GoogleSheetsService::fetchStructuredData()
     * @return array Summary hasil sinkronisasi
     */
    public function sync(array $structuredData): array
    {
        $this->summary = [
            'families_inserted' => 0,
            'families_updated' => 0,
            'members_inserted' => 0,
            'members_updated' => 0,
            'rows_skipped' => 0,
            'error_count' => 0,
            'error_details' => [],
        ];

        $rows = $structuredData['rows'] ?? [];

        foreach ($rows as $rowIndex => $row) {
            try {
                $this->processRow($row, $rowIndex + 2); // +2: row 1 = header, row 2+ = data
            } catch (Exception $e) {
                $this->summary['error_count']++;
                $this->summary['error_details'][] = [
                    'row' => $rowIndex + 2,
                    'nama' => $row['Nama Kepala Keluarga'] ?? '(tidak diketahui)',
                    'error' => $e->getMessage(),
                ];
                Log::warning('PendudukSyncService: error pada baris '.($rowIndex + 2), [
                    'row' => $row,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Simpan ke log sinkronisasi
        $this->saveLog();

        return $this->summary;
    }

    /**
     * Proses satu baris data Google Sheets.
     */
    private function processRow(array $row, int $rowNum): void
    {
        $namaKK = trim($row['Nama Kepala Keluarga'] ?? '');

        if (empty($namaKK)) {
            $this->summary['rows_skipped']++;

            return;
        }

        $timestamp = trim($row['Timestamp'] ?? '');
        $dusun = trim($row['Dusun'] ?? '');
        $rw = trim($row['RW'] ?? '');
        $rt = trim($row['RT'] ?? '');

        // Generate source_id untuk anti-duplikasi
        $sourceId = Family::generateSourceId($timestamp, $namaKK, $dusun, $rw, $rt);

        DB::transaction(function () use ($row, $sourceId, $namaKK, $timestamp, $dusun, $rw, $rt) {
            // ── UPSERT FAMILY ─────────────────────────────────
            $familyData = [
                'timestamp' => $this->parseDateTime($timestamp),
                'dusun' => $dusun,
                'rw' => $rw,
                'rt' => $rt,
                'nama_kepala_keluarga' => $namaKK,
                'jenis_kelamin' => trim($row['Jenis Kelamin'] ?? ''),
                'tanggal_lahir' => $this->parseDate($row['Tanggal Lahir'] ?? ''),
                'agama' => trim($row['Agama'] ?? ''),
                'pendidikan_terakhir' => trim($row['Pendidikan Terakhir'] ?? ''),
                'jenis_pekerjaan' => trim($row['Jenis Pekerjaan'] ?? ''),
                'sudah_selesai' => $this->parseBool($row['Sudah selesai mengisi data?'] ?? ''),
                'synced_at' => now(),
            ];

            $existing = Family::where('source_id', $sourceId)->first();

            if ($existing) {
                $existing->update($familyData);
                $family = $existing;
                $this->summary['families_updated']++;
            } else {
                $family = Family::create(array_merge(['source_id' => $sourceId], $familyData));
                $this->summary['families_inserted']++;
            }

            // ── SYNC MEMBERS ─────────────────────────────────
            // Hapus anggota lama lalu insert ulang (karena tidak ada stable ID per anggota)
            $oldMemberCount = $family->members()->count();
            $family->members()->delete();

            $newMemberCount = 0;

            // Anggota 0 = Kepala Keluarga itu sendiri
            FamilyMember::create([
                'family_id' => $family->id,
                'nomor_anggota' => 0,
                'status_hubungan' => 'Kepala Keluarga',
                'nama' => $namaKK,
                'jenis_kelamin' => trim($row['Jenis Kelamin'] ?? ''),
                'tanggal_lahir' => $this->parseDate($row['Tanggal Lahir'] ?? ''),
                'agama' => trim($row['Agama'] ?? ''),
                'pendidikan_terakhir' => trim($row['Pendidikan Terakhir'] ?? ''),
                'jenis_pekerjaan' => trim($row['Jenis Pekerjaan'] ?? ''),
            ]);
            $newMemberCount++;

            // Anggota 1–15
            for ($i = 1; $i <= 15; $i++) {
                $tambahKey = sprintf(self::MEMBER_FIELDS['tambah'], $i);
                $namaKey = sprintf(self::MEMBER_FIELDS['nama'], $i);

                $tambah = strtolower(trim($row[$tambahKey] ?? ''));
                $nama = trim($row[$namaKey] ?? '');

                // Skip jika tidak ada anggota atau jawaban "Tidak"
                if ($tambah === 'tidak' || $tambah === 'no' || empty($nama)) {
                    continue;
                }

                FamilyMember::create([
                    'family_id' => $family->id,
                    'nomor_anggota' => $i,
                    'status_hubungan' => trim($row[sprintf(self::MEMBER_FIELDS['hubungan'], $i)] ?? ''),
                    'nama' => $nama,
                    'jenis_kelamin' => trim($row[sprintf(self::MEMBER_FIELDS['jenis_kelamin'], $i)] ?? ''),
                    'tanggal_lahir' => $this->parseDate($row[sprintf(self::MEMBER_FIELDS['tanggal_lahir'], $i)] ?? ''),
                    'agama' => trim($row[sprintf(self::MEMBER_FIELDS['agama'], $i)] ?? ''),
                    'pendidikan_terakhir' => trim($row[sprintf(self::MEMBER_FIELDS['pendidikan'], $i)] ?? ''),
                    'jenis_pekerjaan' => trim($row[sprintf(self::MEMBER_FIELDS['pekerjaan'], $i)] ?? ''),
                ]);
                $newMemberCount++;
            }

            // Hitung apakah insert atau update untuk members
            if ($oldMemberCount === 0) {
                $this->summary['members_inserted'] += $newMemberCount;
            } else {
                $this->summary['members_updated'] += $newMemberCount;
            }
        });
    }

    /**
     * Parse tanggal dari format Google Sheets (bisa berbagai format).
     */
    private function parseDate(string $dateStr): ?string
    {
        if (empty(trim($dateStr))) {
            return null;
        }

        try {
            return Carbon::parse($dateStr)->format('Y-m-d');
        } catch (Exception) {
            return null;
        }
    }

    /**
     * Parse datetime dari Google Sheets timestamp.
     */
    private function parseDateTime(string $dtStr): ?string
    {
        if (empty(trim($dtStr))) {
            return null;
        }

        try {
            return Carbon::parse($dtStr)->format('Y-m-d H:i:s');
        } catch (Exception) {
            return null;
        }
    }

    /**
     * Parse boolean dari string Google Sheets.
     */
    private function parseBool(string $val): bool
    {
        return in_array(strtolower(trim($val)), ['ya', 'yes', 'iya', 'true', '1'], true);
    }

    /**
     * Simpan hasil sinkronisasi ke tabel sync_logs.
     */
    private function saveLog(): void
    {
        SyncLog::create([
            'synced_at' => now(),
            'families_inserted' => $this->summary['families_inserted'],
            'families_updated' => $this->summary['families_updated'],
            'members_inserted' => $this->summary['members_inserted'],
            'members_updated' => $this->summary['members_updated'],
            'rows_skipped' => $this->summary['rows_skipped'],
            'error_count' => $this->summary['error_count'],
            'error_details' => $this->summary['error_details'],
            'status' => $this->summary['error_count'] > 0 ? 'partial' : 'success',
        ]);
    }
}
