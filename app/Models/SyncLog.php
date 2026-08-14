<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyncLog extends Model
{
    protected $table = 'sync_logs';

    protected $fillable = [
        'synced_at',
        'families_inserted',
        'families_updated',
        'members_inserted',
        'members_updated',
        'rows_skipped',
        'error_count',
        'error_details',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'synced_at' => 'datetime',
            'error_details' => 'array',
        ];
    }

    public static function latest(): ?self
    {
        return static::orderByDesc('synced_at')->first();
    }
}
