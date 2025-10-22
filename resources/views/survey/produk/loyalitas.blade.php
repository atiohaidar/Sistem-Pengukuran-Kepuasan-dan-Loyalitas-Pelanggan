@php
	// Pass route prefix and controller so the shared loyalitas partial posts to product routes
	$routePrefix = 'survey.produk.';
	$controllerClass = \App\Http\Controllers\ProdukSurveyController::class;
@endphp

@include('survey.loyalitas')
