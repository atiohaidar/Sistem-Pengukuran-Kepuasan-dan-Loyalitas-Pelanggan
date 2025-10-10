<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\GrafikService;
use Illuminate\Http\Request;

class GrafikNewController extends Controller
{
    protected $grafikService;

    public function __construct(GrafikService $grafikService)
    {
        $this->middleware('auth');
        $this->grafikService = $grafikService;
    }

    /**
     * Display grafik kepuasan (KP)
     */
    public function grafik1()
    {
        $data = $this->grafikService->getGrafikKepuasanData();

        return view('grafik.index1', $data);
    }

    /**
     * Display grafik realibility
     */
    public function grafik2()
    {
        $data = $this->grafikService->getGrafikRealibilityData();

        return view('grafik.index2', $data);
    }

    /**
     * Display grafik reliability vs tangible comparison
     */
    public function grafik3()
    {
        $data = $this->grafikService->getGrafikReliabilityTangibleData();

        return view('grafik.index3', $data);
    }

    /**
     * Display grafik tangible
     */
    public function grafik4()
    {
        $data = $this->grafikService->getGrafikTangibleData();

        return view('grafik.index4', $data);
    }

    /**
     * Display grafik empathy
     */
    public function grafik5()
    {
        $data = $this->grafikService->getGrafikEmpathyData();

        return view('grafik.index5', $data);
    }

    /**
     * Display grafik loyalty & parasuraman (LP)
     */
    public function grafik6()
    {
        $data = $this->grafikService->getGrafikLoyaltyData();

        return view('grafik.index6', $data);
    }

    /**
     * Generic method untuk semua grafik
     */
    public function show($type)
    {
        $data = $this->grafikService->getGrafikData($type);

        if (empty($data)) {
            abort(404, 'Grafik type not found');
        }

        return view('grafik.index' . $type, $data);
    }
}
