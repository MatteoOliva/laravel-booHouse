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
Route::get('apartments/{slug}', [ApiController::class, 'show'])->name('api.apartments.show');
Route::get('apartments/search/{search_param}', [ApiController::class, 'search'])->name('api.apartments.search');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
