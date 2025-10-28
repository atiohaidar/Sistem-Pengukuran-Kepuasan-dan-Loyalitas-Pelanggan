<?php

use App\Http\Controllers\CustomerManagementEvaluationController;
use App\Http\Controllers\CustomerManagementEvaluationDashboardController;
use App\Http\Controllers\GrafikController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SurveyDashboardController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\SurveyCampaignController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Public Survey Routes (NO AUTH REQUIRED)
// Now using SurveyController for both campaign and legacy modes
Route::prefix('survey')->name('public-survey.')->group(function () {
    Route::get('/{slug}', [SurveyController::class, 'index'])->name('show');
    Route::post('/{slug}/start', [SurveyController::class, 'start'])->name('start');
    Route::post('/{slug}/submit', [SurveyController::class, 'submitStep'])->name('submit');
    Route::get('/{slug}/thank-you', [SurveyController::class, 'campaignThankYou'])->name('thank-you');
});


Route::middleware(['auth', 'umkm.owner'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // NEW: Campaign-Based Analytics Routes
    Route::prefix('analytics')->name('grafik.')->group(function () {
        Route::get('/', [GrafikController::class, 'selectCampaign'])->name('select-campaign');
        Route::get('/campaign/{campaign}', [GrafikController::class, 'dashboardCampaign'])->name('dashboard-campaign');
    });

    // Grafik Routes - Pelatihan (default - Legacy, kept for backward compatibility)
    Route::get('/grafik/mean-gap-per-dimensi', [GrafikController::class, 'mean_gap_per_dimensi'])->name('grafik.mean-gap-per-dimensi');
    Route::get('/grafik/mean-persepsi-harapan-gap-per-dimensi', [GrafikController::class, 'mean_persepsi_harapan_gap_per_dimensi'])->name('grafik.mean-persepsi-harapan-gap-per-dimensi');
    Route::get('/grafik/profil-responden', [GrafikController::class, 'profilResponden'])->name('grafik.profil-responden');
    Route::get('/grafik/rekomendasi', [GrafikController::class, 'rekomendasi'])->name('grafik.rekomendasi');
    Route::get('/grafik/kepuasan', [GrafikController::class, 'kepuasan'])->name('grafik.kepuasan');
    Route::get('/grafik/loyalitas', [GrafikController::class, 'loyalitas'])->name('grafik.loyalitas');

    // Grafik Routes - Produk
    Route::get('/grafik/produk/mean-gap-per-dimensi', function () {
        return app(GrafikController::class)->mean_gap_per_dimensi('produk');
    })->name('grafik.produk.mean-gap-per-dimensi');
    Route::get('/grafik/produk/mean-persepsi-harapan-gap-per-dimensi', function () {
        return app(GrafikController::class)->mean_persepsi_harapan_gap_per_dimensi('produk');
    })->name('grafik.produk.mean-persepsi-harapan-gap-per-dimensi');
    Route::get('/grafik/produk/profil-responden', function () {
        return app(GrafikController::class)->profilResponden('produk');
    })->name('grafik.produk.profil-responden');
    Route::get('/grafik/produk/rekomendasi', function () {
        return app(GrafikController::class)->rekomendasi('produk');
    })->name('grafik.produk.rekomendasi');
    Route::get('/grafik/produk/kepuasan', function () {
        return app(GrafikController::class)->kepuasan('produk');
    })->name('grafik.produk.kepuasan');
    Route::get('/grafik/produk/loyalitas', function () {
        return app(GrafikController::class)->loyalitas('produk');
    })->name('grafik.produk.loyalitas');

    // Dashboard Pelatihan Route
    Route::get('/dashboard/pelatihan', [GrafikController::class, 'dashboardPelatihan'])->name('dashboard.pelatihan');

    // Dashboard Produk Route
    Route::get('/dashboard/produk', [GrafikController::class, 'dashboardProduk'])->name('dashboard.produk');

    // UMKM pages

    // Survey Campaign Management Routes (NEW)
    Route::prefix('survey-campaigns')->name('survey-campaigns.')->group(function () {
        // List & CRUD
        Route::get('/', [SurveyCampaignController::class, 'index'])->name('index');
        Route::get('/create', [SurveyCampaignController::class, 'create'])->name('create');
        Route::post('/', [SurveyCampaignController::class, 'store'])->name('store');
        Route::get('/{campaign}/edit', [SurveyCampaignController::class, 'edit'])->name('edit');
        Route::put('/{campaign}', [SurveyCampaignController::class, 'update'])->name('update');
        Route::delete('/{campaign}', [SurveyCampaignController::class, 'destroy'])->name('destroy');
        
        // Dashboard & Analytics per Campaign
        Route::get('/{campaign}/dashboard', [SurveyCampaignController::class, 'dashboard'])->name('dashboard');
        
        // Responses Management
        Route::get('/{campaign}/responses', [SurveyCampaignController::class, 'responses'])->name('responses');
        Route::get('/{campaign}/responses/{response}', [SurveyCampaignController::class, 'responseDetail'])->name('response-detail');
        Route::get('/{campaign}/export', [SurveyCampaignController::class, 'export'])->name('export');
        
        // Status Management
        Route::post('/{campaign}/activate', [SurveyCampaignController::class, 'activate'])->name('activate');
        Route::post('/{campaign}/close', [SurveyCampaignController::class, 'close'])->name('close');
        Route::post('/{campaign}/archive', [SurveyCampaignController::class, 'archive'])->name('archive');
        
        // Duplicate Campaign
        Route::post('/{campaign}/duplicate', [SurveyCampaignController::class, 'duplicate'])->name('duplicate');
    });

    // UMKM pages (Legacy)

    // Survey Management Dashboard Routes
    Route::prefix('dashboard/survey-management/{type}')->name('dashboard.survey-management.')->group(function () {
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

// Survey Routes (Generic for pelatihan and produk)
Route::prefix('survey/{type}')->name('survey.')->group(function () {
    Route::get('/', [SurveyController::class, 'index'])->name('index');
    Route::post('/start', [SurveyController::class, 'start'])->name('start');
    Route::get('/step/{step}', [SurveyController::class, 'step'])->name('step');
    Route::post('/step/{step}', [SurveyController::class, 'store'])->name('store');
    Route::get('/complete', [SurveyController::class, 'complete'])->name('complete');
});

// Legacy routes for backward compatibility
Route::prefix('survey/produk')->name('survey.produk.')->controller(SurveyController::class)->group(function () {
    Route::get('/', 'index')->defaults('typeOrSlug', 'produk')->name('index');
    Route::post('/start', 'start')->defaults('typeOrSlug', 'produk')->name('start');
    Route::get('/step/{step}', 'step')->defaults('typeOrSlug', 'produk')->name('step');
    Route::post('/step/{step}', 'store')->defaults('typeOrSlug', 'produk')->name('store');
    Route::get('/complete', 'complete')->defaults('typeOrSlug', 'produk')->name('complete');
});

// Pelatihan Survey Routes (mirror Produk flow, namespaced)
use App\Http\Controllers\SurveyController as PelatihanSurveyController;

Route::prefix('survey/pelatihan')->name('survey.pelatihan.')->group(function () {
    Route::get('/', [PelatihanSurveyController::class, 'index'])->defaults('typeOrSlug', 'pelatihan')->name('index');
    Route::post('/start', [PelatihanSurveyController::class, 'start'])->defaults('typeOrSlug', 'pelatihan')->name('start');
    Route::get('/step/{step}', [PelatihanSurveyController::class, 'step'])->defaults('typeOrSlug', 'pelatihan')->name('step');
    Route::post('/step/{step}', [PelatihanSurveyController::class, 'store'])->defaults('typeOrSlug', 'pelatihan')->name('store');
    Route::get('/complete', [PelatihanSurveyController::class, 'complete'])->defaults('typeOrSlug', 'pelatihan')->name('complete');
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
// // ===== SuperAdmin Features =====
// Route::prefix('superadmin')->name('superadmin.')->group(function () {
//     Route::prefix('umkm')->name('umkm.')->group(function () {
//         Route::get('/', [UmkmController::class, 'index'])->name('index');
//         Route::post('/{umkm}/change-status', [UmkmController::class, 'umkmChangeStatus'])->name('change-status');
//     });
//     // Add superadmin specific routes here in the future
// })->middleware(['auth', 'superadmin']);

Route::get('/user-management', [UserManagementController::class, 'index'])->name('user-management.index');
Route::put('/user-management/{id}/change-status', [UserManagementController::class, 'changeStatus'])->name('user-management.change-status');
Route::get('/user-management/{user}', [UserManagementController::class, 'show'])->name('user-management.show');
Route::put('/user-management/{id}', [UserManagementController::class, 'update'])->name('user-management.update');
Route::put('/user-management/umkm/{id}', [UserManagementController::class, 'updateUmkm'])->name('user-management.update-umkm');


require __DIR__ . '/auth.php';
