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
        Schema::table('activity_photos', function (Blueprint $table) {
            if (!Schema::hasColumn('activity_photos', 'image_path')) {
                $table->string('image_path');
            }
            if (!Schema::hasColumn('activity_photos', 'description')) {
                $table->text('description')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity_photos', function (Blueprint $table) {
            $table->dropColumn(['image_path', 'description']);
        });
    }
};
