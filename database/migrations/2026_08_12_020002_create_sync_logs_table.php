<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sync_logs', function (Blueprint $table) {
            $table->id();
            $table->datetime('synced_at');
            $table->integer('families_inserted')->default(0);
            $table->integer('families_updated')->default(0);
            $table->integer('members_inserted')->default(0);
            $table->integer('members_updated')->default(0);
            $table->integer('rows_skipped')->default(0);
            $table->integer('error_count')->default(0);
            $table->json('error_details')->nullable();
            $table->string('status', 20)->default('success')->comment('success | partial | failed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sync_logs');
    }
};
