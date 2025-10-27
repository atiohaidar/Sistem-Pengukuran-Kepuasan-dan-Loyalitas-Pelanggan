<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;

class PendingController extends Controller
{
    public function showPendingPage()
    {
        if (auth()->check() && auth()->user()->status === 'approved') {
            return redirect()->route('dashboard');
        }
        return view('auth.pending');
    }
}

?>