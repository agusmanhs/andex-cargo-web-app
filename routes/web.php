<?php

use App\Http\Controllers\PublicPortalController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicPortalController::class, 'index'])->name('home');
Route::match(['get', 'post'], '/lacak-resi', [PublicPortalController::class, 'track'])->name('track');
Route::get('/api/search-cities', [PublicPortalController::class, 'searchCities'])->name('api.cities');
Route::post('/api/calculate-tariff', [PublicPortalController::class, 'calculateTariff'])->name('api.tariff');
Route::get('/cabang', [PublicPortalController::class, 'branches'])->name('branches');
