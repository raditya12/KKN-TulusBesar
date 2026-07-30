<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\InnovationTutorial;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class TutorialController extends Controller
{
    public function index()
    {
        $tutorials = InnovationTutorial::latest()->get();
        return view('tutorials.index', compact('tutorials'));
    }

    public function show($slug)
    {
        $tutorial = InnovationTutorial::where('slug', $slug)->firstOrFail();
        
        // Generate QR code for this specific tutorial URL
        $url = url('/tutorials/' . $tutorial->slug);
        $options = new QROptions([
            'version'    => 5,
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'eccLevel'   => QRCode::ECC_L,
        ]);
        
        $qrcode = (new QRCode($options))->render($url);

        return view('tutorials.show', compact('tutorial', 'qrcode'));
    }
}
