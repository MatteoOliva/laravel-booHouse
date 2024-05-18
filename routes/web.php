<?php

use App\Http\Controllers\Auth\ApartmentController;
use App\Http\Controllers\Auth\MessageController;
use App\Http\Controllers\Auth\SponsorshipController;
// use App\Http\Controllers\Auth\BraintreeController;
use App\Http\Controllers\Auth\StatisticController;
use App\Models\Apartment;
use App\Http\Controllers\Guest\DashboardController as GuestDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
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
    Route::get('messages/{apartment}', [MessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}/show', [MessageController::class, 'show'])->name('messages.show');
    Route::get('sponsorships/{slug}', [SponsorshipController::class, 'index'])->name('sponsorships.index');
    Route::get('sponsorship/select/{apartment_slug}/{sponsorship_id}', 'App\Http\Controllers\Auth\SponsorshipController@select')->name('sponsorship.select');

    // rotta statistiche
    Route::get('statistic/{apartment_slug}', [StatisticController::class, 'show'])->name('statistic.show');
  });

Route::post('sponsorships/checkout', [SponsorshipController::class, 'checkout'])->middleware('auth')->name('user.sponsorship.checkout');
Route::get('sponsorships/{apartment_slug}/pay', [SponsorshipController::class, 'goToPayment'])->middleware('auth')->name('user.sponsorship.payment');

Route::delete('apartments/{apartment}/destroy_image', [ApartmentController::class, 'destroy_image'])->middleware('auth')->name('user.apartments.destroy_image');

// Braintree
// Route::any('/payment', [BraintreeController::class, 'token'])->name('token')->middleware('auth');



// rotta softDeletes
Route::get('/softDelete', function () {
  $apartment = Apartment::findorfail(1);
  $apartment->delete();
});




require __DIR__ . '/auth.php';
