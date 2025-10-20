<?php
use App\Http\Controllers\PelatihanSurveyController;
    use App\Http\Controllers\SurveyDashboardController;

use App\Http\Controllers\GrafikController;


use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerManagementEvaluationController;
use App\Http\Controllers\CustomerManagementEvaluationDashboardController;


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

    // Grafik Routes
    Route::get('/grafik/mean-gap-per-dimensi', [GrafikController::class, 'mean_gap_per_dimensi'])->name('grafik.mean-gap-per-dimensi');
    Route::get('/grafik/mean-persepsi-harapan-gap-per-dimensi', [GrafikController::class, 'mean_persepsi_harapan_gap_per_dimensi'])->name('grafik.mean-persepsi-harapan-gap-per-dimensi');
    Route::get('/grafik/profil-responden', [GrafikController::class, 'profilResponden'])->name('grafik.profil-responden');
    Route::get('/grafik/rekomendasi', [GrafikController::class, 'rekomendasi'])->name('grafik.rekomendasi');
    Route::get('/grafik/kepuasan', [GrafikController::class, 'kepuasan'])->name('grafik.kepuasan');
    Route::get('/grafik/loyalitas', [GrafikController::class, 'loyalitas'])->name('grafik.loyalitas');

    // Dashboard Pelatihan Route
    Route::get('/dashboard/pelatihan', [GrafikController::class, 'dashboardPelatihan'])->name('dashboard.pelatihan');

    // Survey Management Dashboard Routes
    Route::prefix('dashboard/survey-management')->name('dashboard.survey-management.')->group(function () {
        Route::get('/', [SurveyDashboardController::class, 'index'])->name('index');
        Route::get('/show/{id}', [SurveyDashboardController::class, 'show'])->name('show');
        Route::delete('/{id}', [SurveyDashboardController::class, 'destroy'])->name('destroy');
        Route::get('/export', [SurveyDashboardController::class, 'export'])->name('export');
    });
        Route::prefix('dashboard/customer-evaluation-management')->name('dashboard.customer-evaluation-management.')->group(function () {
        Route::get('/', [CustomerManagementEvaluationDashboardController::class, 'index'])->name('index');
        Route::get('/show/{id}', [CustomerManagementEvaluationDashboardController::class, 'show'])->name('show');
        Route::delete('/{id}', [CustomerManagementEvaluationDashboardController::class, 'destroy'])->name('destroy');
        Route::get('/export', [CustomerManagementEvaluationDashboardController::class, 'export'])->name('export');
    });
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

// Customer Management Evaluation Routes
Route::prefix('customer-management-evaluation')->name('customer-management-evaluation.')->group(function () {
    Route::get('/', [CustomerManagementEvaluationController::class, 'welcome'])->name('welcome');
    Route::match(['get', 'post'], '/maturity', [CustomerManagementEvaluationController::class, 'maturity'])->name('maturity');
    Route::post('/maturity/store', [CustomerManagementEvaluationController::class, 'storeMaturity'])->name('store-maturity');
    Route::get('/priority', [CustomerManagementEvaluationController::class, 'priority'])->name('priority');
    Route::post('/priority', [CustomerManagementEvaluationController::class, 'storePriority'])->name('store-priority');
    Route::get('/readiness', [CustomerManagementEvaluationController::class, 'readiness'])->name('readiness');
    Route::post('/readiness', [CustomerManagementEvaluationController::class, 'storeReadiness'])->name('store-readiness');
    Route::get('/dashboard/{token?}', [CustomerManagementEvaluationController::class, 'dashboard'])->name('dashboard');
});


require __DIR__.'/auth.php';
