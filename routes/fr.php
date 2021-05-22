<?php

use App\Http\Controllers\AjaxLoadController;
use App\Http\Controllers\Auth\GuestLoginController;
use App\Http\Controllers\Auth\GuestRegisterController;
use App\Http\Controllers\Web\FrBookingController;
use App\Http\Controllers\Web\FrTouristSpotController;
use App\Http\Controllers\Web\PackagesController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\CustomerBookingController;
use App\Http\Controllers\Web\FrontendAjaxLoadController;
use App\Http\Controllers\Web\FrontendController;
use App\Http\Controllers\Web\ResortsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', [FrontendController::class, 'index'])->name('fr.home');
Route::get('/under-construction', [FrontendController::class, 'underConstruction'])->name('fr.uc');

Route::group([
    'middleware' => 'customer'
], function () {
    Route::get('/login', [GuestLoginController::class, 'showLoginForm'])->name('fr.login');
    Route::post('/login', [GuestLoginController::class, 'login'])->name('fr.login.submit');
    Route::get('/create-account', [GuestRegisterController::class, 'createAccount'])->name('fr.register');
    Route::post('/create-account', [GuestRegisterController::class, 'store'])->name('fr.register.submit');
    Route::get('/otp/verify/{slug}', [GuestRegisterController::class, 'otpForm'])->name('fr.otp');
    Route::post('/otp/verify/{slug}', [GuestRegisterController::class, 'otpSubmit'])->name('fr.otp.submit');
    Route::get('/otp/resend/{slug}', [GuestRegisterController::class, 'otpResend'])->name('fr.otp.resend');
});

Route::group([
    'prefix' => 'guest',
    'middleware' => 'auth:customer'
], function ($router) {
    $router->get('/', [FrontendController::class, 'dashboard'])->name('fr.guest.dashboard');
    $router->get('/dashboard', [FrontendController::class, 'dashboard'])->name('fr.dashboard');
    $router->get('/update-profile', [ProfileController::class, 'editProfile'])->name('fr.update.profile');
    $router->put('/update-profile', [ProfileController::class, 'updateProfile'])->name('fr.update.profile.submit');
    $router->get('/change-password', [ProfileController::class, 'changePassword'])->name('fr.change.password');
    $router->put('/change-password', [ProfileController::class, 'updatePassword'])->name('fr.update.password');
    $router->get('/recent-booking-history', [FrBookingController::class, 'recentBookingHistory'])->name('fr.recent.booking.history');
    $router->get('/booking-history', [FrBookingController::class, 'bookingHistory'])->name('fr.booking.history');
    $router->get('/package-booking-history', [FrBookingController::class, 'packageBookingHistory'])->name('fr.package.booking.history');
    $router->get('/logout', [FrontendController::class, 'logout'])->name('fr.customer.logout');
});


//Booking For Resort
Route::post('/booking/{slug}', [CustomerBookingController::class, 'customerBooking'])->name('fr.booking.store');

// Tourist spot routes
Route::group([
    'prefix' => 'tourist-spots'
], function ($router) {
    $router->get('/', [FrTouristSpotController::class, 'index'])->name('fr.tourist.spots');
    $router->get('/{slug}/show', [FrTouristSpotController::class, 'show'])->name('fr.tourist.spot.show');
    $router->get('/article/{slug}', [FrTouristSpotController::class, 'articleShow'])->name('fr.tourist.spot.article.show');
});

//Resort routes
Route::group([
    'prefix' => 'resorts'
], function ($router) {
    $router->get('/', [ResortsController::class, 'index'])->name('fr.resorts');
    $router->get('/{slug}/show', [ResortsController::class, 'show'])->name('fr.resort.show');
});

Route::get('/search-result', [FrontendController::class, 'searchResult'])->name('resort.search');

//pacakge booking
Route::group([
    'prefix' => 'package'
], function ($router) {
    $router->get('/list', [PackagesController::class, 'index'])->name('fr.package.list');
    $router->get('/{slug}/{assign_id}/show', [PackagesController::class, 'packageDetails'])->name('fr.package.show');
    $router->post('/{assign_id}/booking', [PackagesController::class, 'packageBooking'])->name('fr.package.booking');
    $router->get('/booking/{booking_no}/peninvoice', [PackagesController::class, 'pendingInvoice'])->name('fr.package.booking.pending.invoice');
    $router->get('/booking/{booking_no}/ninvoice', [PackagesController::class, 'invoice'])->name('fr.package.booking.invoice');
});

/*ajax loading*/
Route::group(['prefix' => 'load'], function($router) {
    $router->post('/destination', [AjaxLoadController::class, 'getDestination'])->name('get.destination');
    $router->post('/resorts', [AjaxLoadController::class, 'getResorts'])->name('get.search.resort');
    $router->post('/guest/otp/generate', [FrontendAjaxLoadController::class, 'otpGenerate'])->name('otp.generate');
    $router->post('/guest/otp/verify', [FrontendAjaxLoadController::class, 'guestOtpVerify'])->name('guest.otp.verify');
    $router->post('/resort/available/rooms', [FrontendAjaxLoadController::class, 'getResortRoom'])->name('get.resort.room');
    $router->get('/package/route/boarding-point', [FrontendAjaxLoadController::class, 'getPackageBoardingPoint'])->name('get.package.route.boardingpoints');});

