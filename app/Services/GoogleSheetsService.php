<?php

namespace App\Services;

use Exception;
use Google\Client;
use Google\Service\Sheets;
use Illuminate\Support\Facades\Log;

class GoogleSheetsService
{
    /**
     * Header kolom yang DIHARAPKAN dari Google Sheets.
     * Urutan harus tepat sesuai struktur form.
     * Ini adalah "kontrak" antara Google Form dan sistem.
     */
    public const EXPECTED_HEADERS = [
        // A-J: Data Kepala Keluarga
        'Timestamp',
        'Dusun',
        'RW',
        'RT',
        'Nama Kepala Keluarga',
        'Jenis Kelamin',
        'Tanggal Lahir',
        'Agama',
        'Pendidikan Terakhir',
        'Jenis Pekerjaan',

        // Anggota 1 (K-R)
        'Tambah Anggota Keluarga 1?',
        'Status Hubungan Anggota 1',
        'Nama Anggota 1',
        'Jenis Kelamin Anggota 1',
        'Tanggal Lahir Anggota 1',
        'Agama Anggota 1',
        'Pendidikan Terakhir Anggota 1',
        'Jenis Pekerjaan Anggota 1',

        // Anggota 2
        'Tambah Anggota Keluarga 2?',
        'Status Hubungan Anggota 2',
        'Nama Anggota 2',
        'Jenis Kelamin Anggota 2',
        'Tanggal Lahir Anggota 2',
        'Agama Anggota 2',
        'Pendidikan Terakhir Anggota 2',
        'Jenis Pekerjaan Anggota 2',

        // Anggota 3
        'Tambah Anggota Keluarga 3?',
        'Status Hubungan Anggota 3',
        'Nama Anggota 3',
        'Jenis Kelamin Anggota 3',
        'Tanggal Lahir Anggota 3',
        'Agama Anggota 3',
        'Pendidikan Terakhir Anggota 3',
        'Jenis Pekerjaan Anggota 3',

        // Anggota 4
        'Tambah Anggota Keluarga 4?',
        'Status Hubungan Anggota 4',
        'Nama Anggota 4',
        'Jenis Kelamin Anggota 4',
        'Tanggal Lahir Anggota 4',
        'Agama Anggota 4',
        'Pendidikan Terakhir Anggota 4',
        'Jenis Pekerjaan Anggota 4',

        // Anggota 5
        'Tambah Anggota Keluarga 5?',
        'Status Hubungan Anggota 5',
        'Nama Anggota 5',
        'Jenis Kelamin Anggota 5',
        'Tanggal Lahir Anggota 5',
        'Agama Anggota 5',
        'Pendidikan Terakhir Anggota 5',
        'Jenis Pekerjaan Anggota 5',

        // Anggota 6
        'Tambah Anggota Keluarga 6?',
        'Status Hubungan Anggota 6',
        'Nama Anggota 6',
        'Jenis Kelamin Anggota 6',
        'Tanggal Lahir Anggota 6',
        'Agama Anggota 6',
        'Pendidikan Terakhir Anggota 6',
        'Jenis Pekerjaan Anggota 6',

        // Anggota 7
        'Tambah Anggota Keluarga 7?',
        'Status Hubungan Anggota 7',
        'Nama Anggota 7',
        'Jenis Kelamin Anggota 7',
        'Tanggal Lahir Anggota 7',
        'Agama Anggota 7',
        'Pendidikan Terakhir Anggota 7',
        'Jenis Pekerjaan Anggota 7',

        // Anggota 8
        'Tambah Anggota Keluarga 8?',
        'Status Hubungan Anggota 8',
        'Nama Anggota 8',
        'Jenis Kelamin Anggota 8',
        'Tanggal Lahir Anggota 8',
        'Agama Anggota 8',
        'Pendidikan Terakhir Anggota 8',
        'Jenis Pekerjaan Anggota 8',

        // Anggota 9
        'Tambah Anggota Keluarga 9?',
        'Status Hubungan Anggota 9',
        'Nama Anggota 9',
        'Jenis Kelamin Anggota 9',
        'Tanggal Lahir Anggota 9',
        'Agama Anggota 9',
        'Pendidikan Terakhir Anggota 9',
        'Jenis Pekerjaan Anggota 9',

        // Anggota 10
        'Tambah Anggota Keluarga 10?',
        'Status Hubungan Anggota 10',
        'Nama Anggota 10',
        'Jenis Kelamin Anggota 10',
        'Tanggal Lahir Anggota 10',
        'Agama Anggota 10',
        'Pendidikan Terakhir Anggota 10',
        'Jenis Pekerjaan Anggota 10',

        // Anggota 11
        'Tambah Anggota Keluarga 11?',
        'Status Hubungan Anggota 11',
        'Nama Anggota 11',
        'Jenis Kelamin Anggota 11',
        'Tanggal Lahir Anggota 11',
        'Agama Anggota 11',
        'Pendidikan Terakhir Anggota 11',
        'Jenis Pekerjaan Anggota 11',

        // Anggota 12
        'Tambah Anggota Keluarga 12?',
        'Status Hubungan Anggota 12',
        'Nama Anggota 12',
        'Jenis Kelamin Anggota 12',
        'Tanggal Lahir Anggota 12',
        'Agama Anggota 12',
        'Pendidikan Terakhir Anggota 12',
        'Jenis Pekerjaan Anggota 12',

        // Anggota 13
        'Tambah Anggota Keluarga 13?',
        'Status Hubungan Anggota 13',
        'Nama Anggota 13',
        'Jenis Kelamin Anggota 13',
        'Tanggal Lahir Anggota 13',
        'Agama Anggota 13',
        'Pendidikan Terakhir Anggota 13',
        'Jenis Pekerjaan Anggota 13',

        // Anggota 14
        'Tambah Anggota Keluarga 14?',
        'Status Hubungan Anggota 14',
        'Nama Anggota 14',
        'Jenis Kelamin Anggota 14',
        'Tanggal Lahir Anggota 14',
        'Agama Anggota 14',
        'Pendidikan Terakhir Anggota 14',
        'Jenis Pekerjaan Anggota 14',

        // Anggota 15
        'Tambah Anggota Keluarga 15?',
        'Status Hubungan Anggota 15',
        'Nama Anggota 15',
        'Jenis Kelamin Anggota 15',
        'Tanggal Lahir Anggota 15',
        'Agama Anggota 15',
        'Pendidikan Terakhir Anggota 15',
        'Jenis Pekerjaan Anggota 15',

        // Penutup
        'Sudah selesai mengisi data?',
    ];

    /**
     * Header yang WAJIB ada — jika tidak ada, import ditolak.
     */
    public const CRITICAL_HEADERS = [
        'Timestamp',
        'Dusun',
        'RW',
        'RT',
        'Nama Kepala Keluarga',
        'Jenis Kelamin',
        'Tanggal Lahir',
        'Agama',
        'Pendidikan Terakhir',
        'Jenis Pekerjaan',
    ];

    private ?Sheets $sheetsService = null;

    /**
     * Bangun Google Sheets client dari Service Account.
     *
     * @throws Exception jika credential belum dikonfigurasi atau tidak valid
     */
    private function getClient(): Sheets
    {
        if ($this->sheetsService) {
            return $this->sheetsService;
        }

        $credentialPath = config('services.google_sheets.service_account_json');

        if (empty($credentialPath)) {
            throw new Exception(
                'Integrasi Google Sheets belum dikonfigurasi dengan benar. '.
                'Pastikan GOOGLE_SERVICE_ACCOUNT_JSON telah diisi di file .env.'
            );
        }

        if (! file_exists($credentialPath)) {
            throw new Exception(
                "File Service Account tidak ditemukan: {$credentialPath}. ".
                'Pastikan path di GOOGLE_SERVICE_ACCOUNT_JSON benar.'
            );
        }

        $client = new Client;
        $client->setApplicationName('KKN Tulusbesar Admin');
        $client->setScopes([Sheets::SPREADSHEETS_READONLY]);
        $client->setAuthConfig($credentialPath);

        $this->sheetsService = new Sheets($client);

        return $this->sheetsService;
    }

    /**
     * Ambil semua data dari Google Sheets.
     * Return array of arrays (termasuk header di index 0).
     *
     * @throws Exception
     */
    public function fetchRawData(): array
    {
        $sheets = $this->getClient();
        $spreadsheetId = config('services.google_sheets.spreadsheet_id');
        $sheetName = config('services.google_sheets.sheet_name', 'Form Responses 1');

        if (empty($spreadsheetId)) {
            throw new Exception(
                'GOOGLE_SHEETS_SPREADSHEET_ID belum dikonfigurasi di .env.'
            );
        }

        try {
            $response = $sheets->spreadsheets_values->get(
                $spreadsheetId,
                $sheetName
            );

            $rows = $response->getValues();

            if (empty($rows)) {
                return [];
            }

            return $rows;

        } catch (\Google\Service\Exception $e) {
            Log::error('Google Sheets API error', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);

            $errors = json_decode($e->getMessage(), true);
            $msg = $errors['error']['message'] ?? $e->getMessage();

            if ($e->getCode() === 403) {
                throw new Exception(
                    'Akses Google Sheets ditolak. Pastikan Service Account sudah diberi akses ke spreadsheet.'
                );
            }

            if ($e->getCode() === 404) {
                throw new Exception(
                    'Spreadsheet tidak ditemukan. Periksa GOOGLE_SHEETS_SPREADSHEET_ID di .env.'
                );
            }

            throw new Exception("Data gagal ditarik dari Google Sheets: {$msg}");
        }
    }

    /**
     * Validasi header Google Sheets terhadap EXPECTED_HEADERS.
     *
     * @param  array  $actualHeaders  Header baris pertama dari Sheets
     * @return array ['valid' => bool, 'missing' => [], 'extra' => []]
     */
    public function validateHeaders(array $actualHeaders): array
    {
        $missing = array_values(array_diff(self::EXPECTED_HEADERS, $actualHeaders));
        $extra = array_values(array_diff($actualHeaders, self::EXPECTED_HEADERS));

        // Cek kolom kritis
        $missingCritical = array_values(array_intersect($missing, self::CRITICAL_HEADERS));

        return [
            'valid' => empty($missingCritical),
            'missing' => $missing,
            'missing_critical' => $missingCritical,
            'extra' => $extra,
        ];
    }

    /**
     * Ambil data terstruktur (header sudah divalidasi, data sudah di-zip dengan header).
     * Mengembalikan array of associative arrays.
     *
     * @throws Exception
     */
    public function fetchStructuredData(): array
    {
        $raw = $this->fetchRawData();

        if (empty($raw)) {
            return ['headers' => [], 'rows' => []];
        }

        $headers = $raw[0];

        // Validasi header
        $validation = $this->validateHeaders($headers);

        if (! $validation['valid']) {
            $missingList = implode(', ', $validation['missing_critical']);
            throw new Exception(
                'Struktur data Google Sheets tidak sesuai dengan format yang digunakan sistem. '.
                "Kolom kritis yang hilang: {$missingList}"
            );
        }

        // Konversi rows menjadi associative arrays
        $dataRows = array_slice($raw, 1); // Skip header row
        $result = [];

        foreach ($dataRows as $row) {
            if (empty(array_filter($row))) {
                continue; // Skip baris kosong
            }

            // Pad row agar panjangnya sama dengan header
            $padded = array_pad($row, count($headers), '');
            $result[] = array_combine($headers, $padded);
        }

        return [
            'headers' => $headers,
            'rows' => $result,
            'validation' => $validation,
        ];
    }
}
