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
        Schema::table('location_sites', function (Blueprint $table) {
            $table->foreignId('location_category_id')->nullable()->constrained('location_categories')->nullOnDelete();
            $table->string('whatsapp_number')->nullable();
            $table->json('gallery')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('location_sites', function (Blueprint $table) {
            $table->dropForeign(['location_category_id']);
            $table->dropColumn(['location_category_id', 'whatsapp_number', 'gallery']);
        });
    }
};
