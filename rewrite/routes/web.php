<?php
use App\Http\Controllers\PelatihanSurveyController;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});





use App\Http\Controllers\SurveyController;

// Survey Routes
Route::prefix('survey')->name('survey.')->group(function () {
    Route::get('/', [SurveyController::class, 'index'])->name('index');
    Route::post('/start', [SurveyController::class, 'start'])->name('start');
    Route::get('/step/{step}', [SurveyController::class, 'step'])->name('step');
    Route::post('/step/{step}', [SurveyController::class, 'store'])->name('store');
    Route::get('/complete', [SurveyController::class, 'complete'])->name('complete');
});


require __DIR__.'/auth.php';
