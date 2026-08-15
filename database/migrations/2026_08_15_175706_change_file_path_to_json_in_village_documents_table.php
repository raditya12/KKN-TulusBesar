<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('village_documents', function (Blueprint $table) {
            $table->json('file_paths')->nullable()->after('file_path');
        });

        // Migrate existing data
        $documents = DB::table('village_documents')->whereNotNull('file_path')->get();
        foreach ($documents as $doc) {
            DB::table('village_documents')
                ->where('id', $doc->id)
                ->update(['file_paths' => json_encode([$doc->file_path])]);
        }

        Schema::table('village_documents', function (Blueprint $table) {
            $table->dropColumn('file_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('village_documents', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('file_paths');
        });

        // Migrate existing data back
        $documents = DB::table('village_documents')->whereNotNull('file_paths')->get();
        foreach ($documents as $doc) {
            $paths = json_decode($doc->file_paths, true);
            if (is_array($paths) && count($paths) > 0) {
                DB::table('village_documents')
                    ->where('id', $doc->id)
                    ->update(['file_path' => $paths[0]]);
            }
        }

        Schema::table('village_documents', function (Blueprint $table) {
            $table->dropColumn('file_paths');
        });
    }
};
