<?php

use App\Http\Controllers\Api\ApiController;
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

// Route::apiResource('Apartments', ApiController::class)->only(['index', 'show']);
Route::get('apartments/{slug}', [ApiController::class, 'show'])->name('api.apartments.show'); // riceve slug e mostra appartamento
Route::get('apartments/search/{search_param}', [ApiController::class, 'search'])->name('api.apartments.search'); // riceve termine di ricerca e restituisce elenco di appartanmenti
Route::get('apartments/search/sponsored/{search_term}', [ApiController::class, 'sponsored_search'])->name(('api.apartments.search.sponsored')); // riceve termine di ricerca e restituisce elenco di appartamenti sponsorizzati
Route::get('apartments/sponsored/all', [ApiController::class, 'sponsored_all'])->name('api.apartments.sponsored.all'); // riceve niente e mostra tutti gli appartamenti sponsorizzati

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
