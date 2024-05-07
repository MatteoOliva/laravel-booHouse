<?php

use App\Http\Controllers\Auth\ApartmentController;
use App\Http\Controllers\Guest\DashboardController as GuestDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Models\Apartment;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// # Rotte pubbliche
Route::get('/', [GuestDashboardController::class, 'index'])
  ->name('home');
// # Rotta per lo slug nell'URL anziche ID
Route::get('/apartments/{apartment:slug}', function (Apartment $apartment) {
  return $apartment;
});

// # Rotte protette
Route::middleware('auth')
  ->prefix('/admin')
  ->name('admin.')
  ->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
      ->name('dashboard');
  });

// Route::redirect('/apartments/back_to_index', '/apartments')->name('user.apartments.back_to_index');
Route::get('apartments/back_to_index', [ApartmentController::class, 'back_to_index'])->middleware('auth')->name('user.apartments.back_to_index');

// rotta protetta apartment
Route::middleware('auth')
  ->name('user.')
  ->group(function () {

    Route::resource('apartments', ApartmentController::class);
    Route::patch('apartments/{apartment}/update_visible', [ApartmentController::class, 'update_visible'])->name('apartments.update_visible');
  });
Route::delete('apartments/{apartment}/destroy_image', [ApartmentController::class, 'destroy_image'])->middleware('auth')->name('user.apartments.destroy_image');

// rotta softDeletes
Route::get('/softDelete', function () {
  $apartment = Apartment::findorfail(1);
  $apartment->delete();
});


require __DIR__ . '/auth.php';
