<?php

namespace App\Http\Controllers;

use App\Models\LocationSite;

class LocationSiteController extends Controller
{
    public function qrRedirect($qr_code)
    {
        $site = LocationSite::where('qr_code', $qr_code)->firstOrFail();

        // Increment visits
        $site->increment('qr_visits');

        // Redirect to detail page
        return redirect()->route('wisata.show', $site->slug);
    }
}
