<?php

namespace App\Http\Controllers;

use App\Models\RfmCustomer;
use App\Models\RfmTransaction;
use App\Services\RfmService;
use Illuminate\Http\Request;

class RfmController extends Controller
{
    public function show(Request $request, $umkmId)
    {
        // Ambil threshold dari query param atau default
        $thresholds = [
            'recency' => $request->get('recency', 30),
            'frequency' => $request->get('frequency', 5),
            'monetary' => $request->get('monetary', 50000),
        ];

        $service = new RfmService($thresholds);
    $rfmResults = $service->calculateForUmkm($umkmId);
    $clusterStats = $service->getClusterStats($rfmResults);
    $overview = $service->buildOverview($rfmResults);

    return view('rfm.show', compact('rfmResults', 'clusterStats', 'overview', 'umkmId', 'thresholds'));
    }

    public function create($umkmId)
    {
        return view('rfm.create', compact('umkmId'));
    }

    public function store(Request $request, $umkmId)
    {
        $request->validate([
            'custom_id' => 'required|string|unique:rfm_customers,custom_id,NULL,id,umkm_id,' . $umkmId,
            'nama_lengkap' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'jenis_pelanggan' => 'required|in:student,regular',
            'tanggal_transaksi' => 'required|date',
            'nilai_transaksi' => 'required|numeric|min:0',
        ]);

        // Buat customer jika belum ada
        $customer = RfmCustomer::firstOrCreate([
            'umkm_id' => $umkmId,
            'custom_id' => $request->custom_id,
        ], [
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'jenis_pelanggan' => $request->jenis_pelanggan,
        ]);

        // Buat transaksi
        RfmTransaction::create([
            'customer_id' => $customer->id,
            'umkm_id' => $umkmId,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'nilai_transaksi' => $request->nilai_transaksi,
        ]);

        return redirect()->route('rfm.show', $umkmId)->with('success', 'Data berhasil ditambahkan');
    }
}
