<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ApiMessageController;
use App\Http\Controllers\Api\ApiViewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::apiResource('Apartments', ApiController::class)->only(['index']);
// Route::get('apartments/search/{search_term}/{lat}/{lon}/{radius}', [ApiController::class, 'search'])->name('api.apartments.search'); // riceve termine di ricerca e restituisce elenco di appartanmenti
// Route::get('apartments/search/not_sponsored/{search_term}', [ApiController::class, 'not_sponsored_search'])->name('api.apartments.search.not_sponsored'); // riceve termine di ricerca e restituisce appartamenti non sponsorizzati
// Route::get('apartments/search/sponsored/{search_term}', [ApiController::class, 'sponsored_search'])->name(('api.apartments.search.sponsored')); // riceve termine di ricerca e restituisce elenco di appartamenti sponsorizzati
Route::get('apartments', [ApiController::class, 'index'])->name('api.apartments.index'); // restituisce sempre tutti gli appartamenti
Route::post('apartments/search/all', [ApiController::class, 'search'])->name('api.apartments.search'); // riceve un oggetto JSON in entrata e prende i dati per cercare gli appartamenti + vicini, o col nome più simile, con filtri avanzati
Route::get('apartments/{slug}', [ApiController::class, 'show'])->name('api.apartments.show'); // riceve slug e mostra appartamento
Route::get('apartments/sponsored/all', [ApiController::class, 'sponsored_all'])->name('api.apartments.sponsored.all'); // riceve niente e mostra tutti gli appartamenti sponsorizzati
Route::get('services', [ApiController::class, 'services_all'])->name('api.services.all'); //restituisce tutti i servizi
Route::get('view/{apartment_id}', [ApiViewController::class, 'store'])->name('api.views.store');

// rotta api per ricevere messaggi dal frontend 
Route::apiResource("/message", ApiMessageController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
