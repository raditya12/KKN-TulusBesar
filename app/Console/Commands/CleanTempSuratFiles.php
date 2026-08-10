<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanTempSuratFiles extends Command
{
    protected $signature   = 'surat:clean-temp {--hours=2 : Hapus file temp yang lebih tua dari N jam}';
    protected $description = 'Hapus file DOCX/PDF temporary di folder temp-surat-preview yang sudah kadaluarsa';

    public function handle(): int
    {
        $maxAgeHours = (int) $this->option('hours');
        $maxAgeSeconds = $maxAgeHours * 3600;
        $cutoff = now()->subSeconds($maxAgeSeconds)->timestamp;

        $files = Storage::disk('public')->files('temp-surat-preview');

        if (empty($files)) {
            $this->info('Tidak ada file temp yang perlu dibersihkan.');
            return self::SUCCESS;
        }

        $deleted = 0;
        foreach ($files as $file) {
            $lastModified = Storage::disk('public')->lastModified($file);

            if ($lastModified < $cutoff) {
                Storage::disk('public')->delete($file);
                $this->line("  Dihapus: {$file}");
                $deleted++;
            }
        }

        $this->info("Selesai. {$deleted} dari " . count($files) . " file temp dihapus (lebih dari {$maxAgeHours} jam).");

        return self::SUCCESS;
    }
}
