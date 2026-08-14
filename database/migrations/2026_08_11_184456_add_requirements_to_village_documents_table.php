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
        Schema::table('village_documents', function (Blueprint $table) {
            $table->string('requirement_image_path')->nullable()->after('file_path');
            $table->text('requirements_text')->nullable()->after('requirement_image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('village_documents', function (Blueprint $table) {
            $table->dropColumn(['requirement_image_path', 'requirements_text']);
        });
    }
};
