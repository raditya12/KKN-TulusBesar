<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();

            $table->foreignId('family_id')
                ->constrained('families')
                ->onDelete('cascade');

            // 0 = kepala keluarga, 1-15 = anggota
            $table->tinyInteger('nomor_anggota')->default(0)->comment('0=KK, 1-15=anggota');

            $table->string('status_hubungan', 100)->nullable();
            $table->string('nama', 255);
            $table->string('jenis_kelamin', 20)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama', 50)->nullable();
            $table->string('pendidikan_terakhir', 100)->nullable();
            $table->string('jenis_pekerjaan', 100)->nullable();

            $table->timestamps();

            // Index untuk performa filter dan search
            $table->index('family_id');
            $table->index('jenis_kelamin');
            $table->index('agama');
            $table->index('pendidikan_terakhir');
            $table->index('jenis_pekerjaan');
            $table->index('tanggal_lahir');
            $table->index('status_hubungan');
            $table->index('nama');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
