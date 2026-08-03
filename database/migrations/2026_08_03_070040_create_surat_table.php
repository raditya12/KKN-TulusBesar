<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->comment('Nomor surat diisi manual oleh operator');
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat');
            $table->foreignId('template_surat_id')->nullable()->constrained('template_surat')->nullOnDelete();
            $table->string('nama_warga')->comment('Nama warga yang mengurus surat');
            $table->string('nik', 20)->nullable()->comment('NIK warga');
            $table->json('data_surat')->nullable()->comment('Semua nilai placeholder yang diisi operator');
            $table->longText('konten_snapshot')->nullable()->comment('HTML final surat setelah placeholder diganti — arsip permanen');
            $table->string('pdf_generated_path')->nullable()->comment('Path PDF hasil generate');
            $table->string('status', 50)->default('draft')->comment('draft | dicetak | scan_uploaded');
            $table->date('tanggal_surat')->comment('Tanggal yang tertera pada surat');
            $table->date('tanggal_terbit')->nullable()->comment('Tanggal surat resmi diterbitkan');
            $table->boolean('is_custom')->default(false)->comment('True = surat dibuat dengan editor custom, bukan dari template');
            $table->string('nama_surat_custom')->nullable()->comment('Nama/judul surat custom');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['jenis_surat_id', 'status']);
            $table->index(['tanggal_surat']);
            $table->index(['nik']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
