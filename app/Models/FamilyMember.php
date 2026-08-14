<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyMember extends Model
{
    protected $table = 'family_members';

    protected $fillable = [
        'family_id',
        'nomor_anggota',
        'status_hubungan',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'agama',
        'pendidikan_terakhir',
        'jenis_pekerjaan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'nomor_anggota' => 'integer',
        ];
    }

    // ── Relations ──────────────────────────────────────────

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class, 'family_id');
    }

    // ── Accessors ──────────────────────────────────────────

    public function getUmurAttribute(): ?int
    {
        if (! $this->tanggal_lahir) {
            return null;
        }

        return Carbon::parse($this->tanggal_lahir)->age;
    }

    public function getKelompokUmurAttribute(): string
    {
        $umur = $this->umur;
        if ($umur === null) {
            return 'Tidak Diketahui';
        }

        return match (true) {
            $umur <= 5 => '0–5 tahun',
            $umur <= 12 => '6–12 tahun',
            $umur <= 17 => '13–17 tahun',
            $umur <= 25 => '18–25 tahun',
            $umur <= 40 => '26–40 tahun',
            $umur <= 60 => '41–60 tahun',
            default => '61+ tahun',
        };
    }

    public function getIsKepalKeluargaAttribute(): bool
    {
        return $this->nomor_anggota === 0;
    }

    // ── Scopes ─────────────────────────────────────────────

    public function scopeKetuaKeluarga(Builder $query): Builder
    {
        return $query->where('nomor_anggota', 0);
    }

    public function scopeAnggota(Builder $query): Builder
    {
        return $query->where('nomor_anggota', '>', 0);
    }

    public function scopeLakiLaki(Builder $query): Builder
    {
        return $query->where('jenis_kelamin', 'Laki-laki');
    }

    public function scopePerempuan(Builder $query): Builder
    {
        return $query->where('jenis_kelamin', 'Perempuan');
    }

    /**
     * Scope filter kelompok umur menggunakan TIMESTAMPDIFF agar dinamis
     */
    public function scopeKelompokUmur(Builder $query, string $kelompok): Builder
    {
        return match ($kelompok) {
            '0-5' => $query->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 0 AND 5'),
            '6-12' => $query->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 6 AND 12'),
            '13-17' => $query->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 13 AND 17'),
            '18-25' => $query->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 18 AND 25'),
            '26-40' => $query->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 26 AND 40'),
            '41-60' => $query->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 41 AND 60'),
            '61+' => $query->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 61'),
            default => $query,
        };
    }
}
