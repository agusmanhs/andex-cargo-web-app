<?php

use App\Http\Controllers\PublicPortalController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicPortalController::class, 'index'])->name('home');
Route::match(['get', 'post'], '/lacak-resi', [PublicPortalController::class, 'track'])->name('track');
Route::get('/api/search-cities', [PublicPortalController::class, 'searchCities'])->name('api.cities');
Route::post('/api/calculate-tariff', [PublicPortalController::class, 'calculateTariff'])->name('api.tariff');
Route::get('/cabang', [PublicPortalController::class, 'branches'])->name('branches');

// Dokumen Cetak Logistik (Resi Thermal, Nota, & Surat Jalan)
Route::get('/print/resi/{shipment}', [\App\Http\Controllers\PrintController::class, 'printThermalResi'])->name('print.resi');
Route::get('/print/nota/{shipment}', [\App\Http\Controllers\PrintController::class, 'printNota'])->name('print.nota');
Route::get('/print/manifest/{manifest}', [\App\Http\Controllers\PrintController::class, 'printManifest'])->name('print.manifest');
