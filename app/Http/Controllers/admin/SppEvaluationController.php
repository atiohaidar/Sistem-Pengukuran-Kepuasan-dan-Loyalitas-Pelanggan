<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\SppEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SppEvaluationController extends Controller
{
    /**
     * Display a listing of evaluations (Admin only).
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $evaluations = SppEvaluation::orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.spp.index', compact('evaluations'));
    }
    
    /**
     * Show the detail of a specific evaluation (Admin only).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $evaluation = SppEvaluation::findOrFail($id);
        
        return view('admin.spp.show', compact('evaluation'));
    }
    
    /**
     * Delete an evaluation (Admin only).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $evaluation = SppEvaluation::findOrFail($id);
        $evaluation->delete();
        
        return redirect()->route('admin.spp.index')
            ->with('success', 'Data evaluasi berhasil dihapus');
    }
    
    /**
     * Export evaluations to Excel (Admin only).
     *
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        $evaluations = SppEvaluation::orderBy('created_at', 'desc')->get();
        
        return view('admin.spp.export', compact('evaluations'));
    }
}
