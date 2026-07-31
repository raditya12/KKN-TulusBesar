<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Move data from umkms to location_sites
        if (Schema::hasTable('umkms')) {
            $umkms = DB::table('umkms')->get();
            foreach ($umkms as $umkm) {
                // If slug exists in location_sites, append random string
                $slug = $umkm->slug;
                if (DB::table('location_sites')->where('slug', $slug)->exists()) {
                    $slug = $slug . '-' . Str::random(4);
                }

                DB::table('location_sites')->insert([
                    'name' => $umkm->name,
                    'slug' => $slug,
                    'description' => $umkm->description . ($umkm->category ? '<br><br>Kategori UMKM: ' . $umkm->category : ''),
                    'category' => 'UMKM',
                    'image_path' => $umkm->image_path,
                    'status' => 'active',
                    'qr_code' => Str::random(6),
                    'created_at' => $umkm->created_at,
                    'updated_at' => $umkm->updated_at,
                ]);
            }
            // 2. Drop the umkms table
            Schema::dropIfExists('umkms');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 
    }
};
