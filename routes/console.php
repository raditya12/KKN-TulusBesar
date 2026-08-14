<?php

use App\Console\Commands\CleanTempSuratFiles;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Bersihkan file temp surat yang lebih dari 2 jam setiap jam sekali
Schedule::command(CleanTempSuratFiles::class)->hourly();
