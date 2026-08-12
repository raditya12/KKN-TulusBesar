<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('families', function (Blueprint $table) {
            $table->id();

            // Source identifier — anti-duplikasi
            // SHA-256 dari: timestamp | nama_kepala_keluarga | dusun | rw | rt
            $table->string('source_id', 64)->unique()->comment('SHA-256 dari timestamp+nama_kk+dusun+rw+rt');

            // Data dari Google Sheets
            $table->datetime('timestamp')->nullable()->comment('Timestamp submission Google Form');
            $table->string('dusun', 100)->nullable();
            $table->string('rw', 10)->nullable();
            $table->string('rt', 10)->nullable();
            $table->string('nama_kepala_keluarga', 255);
            $table->string('jenis_kelamin', 20)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama', 50)->nullable();
            $table->string('pendidikan_terakhir', 100)->nullable();
            $table->string('jenis_pekerjaan', 100)->nullable();
            $table->boolean('sudah_selesai')->default(false)->comment('Kolom: Sudah selesai mengisi data?');

            // Metadata sync
            $table->datetime('synced_at')->nullable()->comment('Waktu terakhir row ini di-sync');

            $table->timestamps();

            // Index untuk performa query
            $table->index('dusun');
            $table->index('rw');
            $table->index('rt');
            $table->index(['dusun', 'rw', 'rt']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
