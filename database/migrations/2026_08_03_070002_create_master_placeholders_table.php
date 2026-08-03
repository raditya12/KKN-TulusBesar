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
        Schema::create('master_placeholders', function (Blueprint $table) {
            $table->id();
            $table->string('nama_field')->comment('Label user-friendly, misal: Nama Lengkap');
            $table->string('placeholder', 100)->unique()->comment('Format: {{key}}, misal: {{nama}}');
            $table->string('kategori', 100)->default('Umum')->comment('Kelompok placeholder, misal: Data Warga, Surat');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_placeholders');
    }
};
