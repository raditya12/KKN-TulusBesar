<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Family extends Model
{
    protected $table = 'families';

    protected $fillable = [
        'source_id',
        'timestamp',
        'dusun',
        'rw',
        'rt',
        'nama_kepala_keluarga',
        'jenis_kelamin',
        'tanggal_lahir',
        'agama',
        'pendidikan_terakhir',
        'jenis_pekerjaan',
        'sudah_selesai',
        'synced_at',
    ];

    protected function casts(): array
    {
        return [
            'timestamp' => 'datetime',
            'tanggal_lahir' => 'date',
            'sudah_selesai' => 'boolean',
            'synced_at' => 'datetime',
        ];
    }

    // ── Relations ──────────────────────────────────────────

    public function members(): HasMany
    {
        return $this->hasMany(FamilyMember::class, 'family_id')->orderBy('nomor_anggota');
    }

    /**
     * Semua anggota keluarga KECUALI KK (nomor_anggota > 0)
     */
    public function anggota(): HasMany
    {
        return $this->hasMany(FamilyMember::class, 'family_id')
            ->where('nomor_anggota', '>', 0)
            ->orderBy('nomor_anggota');
    }

    // ── Accessors ──────────────────────────────────────────

    public function getUmurAttribute(): ?int
    {
        if (! $this->tanggal_lahir) {
            return null;
        }

        return Carbon::parse($this->tanggal_lahir)->age;
    }

    public function getJumlahAnggotaAttribute(): int
    {
        return $this->members()->count();
    }

    // ── Scopes ─────────────────────────────────────────────

    public function scopeByDusun($query, string $dusun)
    {
        return $query->where('dusun', $dusun);
    }

    // ── Static Helpers ─────────────────────────────────────

    /**
     * Generate stable source_id dari data kepala keluarga.
     * Identifier tidak boleh berubah antar sync.
     */
    public static function generateSourceId(
        string $timestamp,
        string $namaKK,
        string $dusun,
        string $rw,
        string $rt
    ): string {
        return hash('sha256', implode('|', [
            trim($timestamp),
            trim(strtolower($namaKK)),
            trim(strtolower($dusun)),
            trim($rw),
            trim($rt),
        ]));
    }
}
