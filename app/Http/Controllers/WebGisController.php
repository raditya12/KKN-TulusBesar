<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Umkm;
use App\Models\CulturalSite;
use App\Models\GisFeature;

class WebGisController extends Controller
{
    public function index()
    {
        $umkms = Umkm::whereNotNull('latitude')->whereNotNull('longitude')->get();
        $culturalSites = CulturalSite::whereNotNull('latitude')->whereNotNull('longitude')->get();
        $gisFeatures = GisFeature::whereNotNull('latitude')->whereNotNull('longitude')->get();

        return view('pages.peta', compact('umkms', 'culturalSites', 'gisFeatures'));
    }
}
