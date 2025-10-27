<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UmkmProfile;

class UmkmController extends Controller
{
    public function pending()
    {
        return view('umkm.pending');
    }

    public function dashboard(UmkmProfile $umkm)
    {
        // For now, pass basic data. Detailed metrics will use SurveyCalculationService later.
        return view('umkm.dashboard', ['umkm' => $umkm]);
    }
}
