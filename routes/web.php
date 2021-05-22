<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FacilityRoomController;
use App\Http\Controllers\Admin\InstructionController;
use App\Http\Controllers\Admin\PackageControllers;
use App\Http\Controllers\Admin\QuickBookingController;
use App\Http\Controllers\Admin\SeasonController;
use App\Http\Controllers\Admin\ResortController;
use App\Http\Controllers\Admin\ResortFacilityController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\SettingsHolidayController;
use App\Http\Controllers\Admin\SettingsBookingController;
use App\Http\Controllers\Admin\SettingsWeekendController;
use App\Http\Controllers\Admin\SlidersController;
use App\Http\Controllers\Admin\TouristSpotArticlesController;
use App\Http\Controllers\Admin\TouristSpotController;
use App\Http\Controllers\AjaxLoadController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Auth::routes();

Route::get('admin/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('admin/login', [LoginController::class, 'login'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');


Route::group([
    'middleware' => 'auth'
], function ($router) {
    $router->get('/home', [HomeController::class, 'index'])->name('home');
    $router->get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');

    $router->group(['prefix' => 'tourist/spot'], function($router) {
        $router->get('/', [TouristSpotController::class, 'index'])->name('tourist.spot.list');
        $router->get('/{id}/show', [TouristSpotController::class, 'show'])->name('tourist.spot.show');
        $router->get('/create', [TouristSpotController::class, 'create'])->name('tourist.spot.create');
        $router->post('/create', [TouristSpotController::class, 'store'])->name('tourist.spot.store');
        $router->get('/{id}/edit', [TouristSpotController::class, 'edit'])->name('tourist.spot.edit');
        $router->put('/{id}/update', [TouristSpotController::class, 'update'])->name('tourist.spot.update');
        $router->delete('/{id}/delete', [TouristSpotController::class, 'destroy'])->name('tourist.spot.delete');

        //Instrucrtion router about tourist spot
        $router->prefix('{tourist_spot_id}/instruction')->group(function ($router) {
            $router->get('/list', [InstructionController::class, 'index'])->name('instruction.list');
            $router->get('/{id}/show', [InstructionController::class, 'show'])->name('instruction.show');
            $router->get('/create', [InstructionController::class, 'create'])->name('instruction.create');
            $router->post('/create', [InstructionController::class, 'store'])->name('instruction.store');
            $router->get('/{id}/edit', [InstructionController::class, 'edit'])->name('instruction.edit');
            $router->put('/{id}/update', [InstructionController::class, 'update'])->name('instruction.update');
            $router->delete('/{id}/delete', [InstructionController::class, 'destroy'])->name('instruction.delete');
        });

        //article router about tourist spot
        $router->prefix('{tourist_spot_id}/article')->group(function ($router) {
            $router->get('/list', [TouristSpotArticlesController::class, 'index'])->name('tourist.spot.article.list');
            $router->get('/{id}/show', [TouristSpotArticlesController::class, 'show'])->name('tourist.spot.article.show');
            $router->get('/create', [TouristSpotArticlesController::class, 'create'])->name('tourist.spot.article.create');
            $router->post('/create', [TouristSpotArticlesController::class, 'store'])->name('tourist.spot.article.store');
            $router->get('/{id}/edit', [TouristSpotArticlesController::class, 'edit'])->name('tourist.spot.article.edit');
            $router->put('/{id}/update', [TouristSpotArticlesController::class, 'update'])->name('tourist.spot.article.update');
            $router->delete('/{id}/delete', [TouristSpotArticlesController::class, 'destroy'])->name('tourist.spot.article.delete');
        });

        //galleries route about tourist spot
        $router->prefix('gallery')->group(function ($router) {
            $router->get('/{tourist_spot_id}/list', [TouristSpotController::class, 'gallery'])->name('tourist.spot.gallery');
            $router->post('/{tourist_spot_id}/create', [TouristSpotController::class, 'storeGallery'])->name('tourist.spot.store.gallery');
            $router->delete('/{tourist_spot_id}/{gallery_id}/delete', [TouristSpotController::class, 'deleteGallery'])->name('tourist.spot.delete.gallery');
        });
    });

    $router->group(['prefix' => 'season'], function ($router) {
        $router->get('/list', [SeasonController::class, 'index'])->name('season.list');
        $router->get('/{id}/show', [SeasonController::class, 'show'])->name('season.show');
        $router->get('/create', [SeasonController::class, 'create'])->name('season.create');
        $router->post('/create', [SeasonController::class, 'store'])->name('season.store');
        $router->get('/{id}/edit', [SeasonController::class, 'edit'])->name('season.edit');
        $router->put('/{id}/update', [SeasonController::class, 'update'])->name('season.update');
        $router->delete('/{id}/delete', [SeasonController::class, 'destroy'])->name('season.delete');
    });

    $router->group(['prefix' => 'resort'], function($router) {
        $router->get('/list', [ResortController::class, 'index'])->name('resort.list');
        $router->get('/{id}/show', [ResortController::class, 'show'])->name('resort.show');
        $router->get('/create', [ResortController::class, 'create'])->name('resort.create');
        $router->post('/create', [ResortController::class, 'store'])->name('resort.store');
        $router->get('/{id}/edit', [ResortController::class, 'edit'])->name('resort.edit');
        $router->put('/{id}/update', [ResortController::class, 'update'])->name('resort.update');
        $router->delete('/{id}/delete', [ResortController::class, 'destroy'])->name('resort.delete');
        //photo gallery routes
        $router->get('/photo/{id}/galleries', [ResortController::class, 'gallery'])->name('resort.photo.gallery');
        $router->post('/photo/{id}/add', [ResortController::class, 'storePhoto'])->name('resort.photo.store');
        $router->delete('/photo/{id}/{photo_id}/delete', [ResortController::class, 'deletePhoto'])->name('resort.photo.delete');

        /*Resort Family Route*/
        $router->group(['prefix' => '{resort_id}/user'], function($router) {
            $router->get('/create', [ResortController::class, 'createResortUser'])->name('resort.user.create');
            $router->post('/create', [ResortController::class, 'storeResortUser'])->name('resort.user.store');
            $router->get('/{id}/edit', [ResortController::class, 'editResortUser'])->name('resort.user.edit');
            $router->put('/{id}/update', [ResortController::class, 'updateResortUser'])->name('resort.user.update');
            $router->delete('/{id}/delete', [ResortController::class, 'destroyResortUser'])->name('resort.user.delete');
        });
    });

    $router->group(['prefix' => 'resort/facility'], function($router) {
        $router->get('/', [ResortFacilityController::class, 'index'])->name('resort.facilities');
        $router->get('/create', [ResortFacilityController::class, 'create'])->name('resort.facility.create');
        $router->post('/create', [ResortFacilityController::class, 'store'])->name('resort.facility.store');
        $router->get('/{id}/edit', [ResortFacilityController::class, 'edit'])->name('resort.facility.edit');
        $router->put('/{id}/update', [ResortFacilityController::class, 'update'])->name('resort.facility.update');
        $router->delete('/{id}/delete', [ResortFacilityController::class, 'destroy'])->name('resort.facility.delete');
    });

    // room manage
    $router->group(['prefix' => 'room'], function($router) {
        $router->get('/', [RoomController::class, 'index'])->name('room.list');
        $router->get('/{id}/show', [RoomController::class, 'show'])->name('room.show');
        $router->get('/create', [RoomController::class, 'create'])->name('room.create');
        $router->post('/create', [RoomController::class, 'store'])->name('room.store');
        $router->get('/{id}/edit', [RoomController::class, 'edit'])->name('room.edit');
        $router->put('/{id}/update', [RoomController::class, 'update'])->name('room.update');
        $router->delete('/{id}/delete', [RoomController::class, 'destroy'])->name('room.delete');

        //photo gallery routes
        $router->get('/photo/{id}/galleries', [RoomController::class, 'gallery'])->name('room.photo.gallery');
        $router->post('/photo/{id}/add', [RoomController::class, 'storePhoto'])->name('room.photo.store');
        $router->delete('/photo/{id}/{photo_id}/delete', [RoomController::class, 'deletePhoto'])->name('room.photo.delete');
    });

    // room categories manage
    $router->group(['prefix' => 'room/category'], function($router) {
        $router->get('/', [CategoryController::class, 'index'])->name('room.categories');
        $router->get('/create', [CategoryController::class, 'create'])->name('room.category.create');
        $router->post('/create', [CategoryController::class, 'store'])->name('room.category.store');
        $router->get('/{id}/edit', [CategoryController::class, 'edit'])->name('room.category.edit');
        $router->put('/{id}/update', [CategoryController::class, 'update'])->name('room.category.update');
        $router->delete('/{id}/delete', [CategoryController::class, 'destroy'])->name('room.category.delete');
    });

    $router->group(['prefix' => 'room/facility'], function($router) {
        $router->get('/', [FacilityRoomController::class, 'index'])->name('room.facilities');
        $router->get('/create', [FacilityRoomController::class, 'create'])->name('room.facility.create');
        $router->post('/create', [FacilityRoomController::class, 'store'])->name('room.facility.store');
        $router->get('/{id}/edit', [FacilityRoomController::class, 'edit'])->name('room.facility.edit');
        $router->put('/{id}/update', [FacilityRoomController::class, 'update'])->name('room.facility.update');
        $router->delete('/{id}/delete', [FacilityRoomController::class, 'destroy'])->name('room.facility.delete');
    });

    $router->group(['prefix' => 'booking'], function($router) {
        $router->get('/', [BookingController::class, 'index'])->name('booking.list');
        $router->get('/admin-booking', [BookingController::class, 'adminBooking'])->name('booking.admin.list');
        $router->get('/resort-booking', [BookingController::class, 'resortBooking'])->name('booking.resort.list');
        $router->get('/guest-booking', [BookingController::class, 'guestBooking'])->name('booking.guest.list');
        $router->get('/customer-booking', [BookingController::class, 'customerBooking'])->name('booking.customer.list');

        $router->get('/{id}/show', [BookingController::class, 'show'])->name('booking.show');
        $router->get('/{id}/invoice', [BookingController::class, 'invoice'])->name('booking.invoice');

        $router->get('/create', [BookingController::class, 'create'])->name('booking.create');
        $router->post('/create', [BookingController::class, 'store'])->name('booking.store');

        //action for a booking
        $router->post('{id}/approved', [BookingController::class, 'approveBooking'])->name('booking.approved');
        $router->post('{id}/cancelled', [BookingController::class, 'cancelBooking'])->name('booking.cancel');

        $router->delete('/{id}/delete', [BookingController::class, 'destroy'])->name('booking.delete');

        //booking calendar
        $router->get('/resort/calendar', [BookingController::class, 'bookingCalendarResort'])->name('booking.calendar.resort');
        $router->post('/resort/calendar', [BookingController::class, 'bookingCalendarRoom'])->name('booking.calendar.room');
        $router->get('/calendar', [BookingController::class, 'bookingCalendar'])->name('booking.calendar');

        $router->group(['prefix' => 'quick-booking'], function($router) {
            $router->get('/', [QuickBookingController::class, 'index'])->name('quick.booking.list');
            $router->get('/{id}/show', [QuickBookingController::class, 'show'])->name('quick.booking.show');
            $router->get('/{id}/invoice', [QuickBookingController::class, 'invoice'])->name('quick.booking.invoice');
            $router->get('/create', [QuickBookingController::class, 'create'])->name('quick.booking.create');
            $router->post('/create', [QuickBookingController::class, 'store'])->name('quick.booking.store');
            $router->delete('/{id}/delete', [QuickBookingController::class, 'destroy'])->name('quick.booking.delete');
        });
    });

    $router->group(['prefix' => 'booking'], function($router) {
        $router->get('/', [BookingController::class, 'index'])->name('booking.list');
        $router->get('/{id}/show', [BookingController::class, 'show'])->name('booking.show');
        $router->get('/{id}/invoice', [BookingController::class, 'invoice'])->name('booking.invoice');
        $router->get('/create', [BookingController::class, 'create'])->name('booking.create');
        $router->post('/create', [BookingController::class, 'store'])->name('booking.store');
        $router->delete('/{id}/delete', [BookingController::class, 'destroy'])->name('booking.delete');
        //booking calendar
        $router->get('/calendar', [BookingController::class, 'bookingCalendar'])->name('booking.calendar');
    });

    /*settings*/
    $router->group(['prefix' => 'settings'], function($router) {

        $router->group(['prefix' => 'weekend'], function($router) {
            $router->get('/', [SettingsWeekendController::class, 'index'])->name('weekend.list');
            $router->get('/create', [SettingsWeekendController::class, 'create'])->name('weekend.create');
            $router->post('/create', [SettingsWeekendController::class, 'store'])->name('weekend.store');
            $router->get('/{id}/edit', [SettingsWeekendController::class, 'edit'])->name('weekend.edit');
            $router->put('/{id}/update', [SettingsWeekendController::class, 'update'])->name('weekend.update');
            $router->delete('/{id}/delete', [SettingsWeekendController::class, 'destroy'])->name('weekend.delete');
        });

        $router->group(['prefix' => 'holiday'], function($router) {
            $router->get('/', [SettingsHolidayController::class, 'index'])->name('holiday.list');
            $router->get('/create', [SettingsHolidayController::class, 'create'])->name('holiday.create');
            $router->post('/create', [SettingsHolidayController::class, 'store'])->name('holiday.store');
            $router->get('/{id}/edit', [SettingsHolidayController::class, 'edit'])->name('holiday.edit');
            $router->put('/{id}/update', [SettingsHolidayController::class, 'update'])->name('holiday.update');
            $router->delete('/{id}/delete', [SettingsHolidayController::class, 'destroy'])->name('holiday.delete');
        });

        $router->group(['prefix' => 'booking'], function($router) {
            $router->get('/', [SettingsBookingController::class, 'index'])->name('setting.booking.list');
            $router->post('/create', [SettingsBookingController::class, 'bookingSettings'])->name('setting.booking.store');
            $router->put('/update', [SettingsBookingController::class, 'bookingSettings'])->name('setting.booking.update');
            $router->delete('/{id}/delete', [SettingsBookingController::class, 'destroy'])->name('setting.booking.delete');
        });
    });

    //package routes
    $router->group(['prefix' => 'package'], function($router) {
        $router->get('/', [PackageControllers::class, 'index'])->name('package.list');
        $router->get('/{id}/show', [PackageControllers::class, 'show'])->name('package.show');
        $router->get('/create', [PackageControllers::class, 'create'])->name('package.create');
        $router->post('/create', [PackageControllers::class, 'store'])->name('package.store');
        $router->get('/{id}/edit', [PackageControllers::class, 'edit'])->name('package.edit');
        $router->put('/{id}/update', [PackageControllers::class, 'update'])->name('package.update');
        $router->delete('/{id}/delete', [PackageControllers::class, 'destroy'])->name('package.delete');
        $router->post('/assign', [PackageControllers::class, 'assignPackageStore'])->name('package.assign.store');
        $router->delete('/assign/{assign_id}', [PackageControllers::class, 'assignPackageDelete'])->name('assign.package.delete');
        $router->get('/booking/list', [PackageControllers::class, 'bookingList'])->name('package.booking.list');
        $router->get('/booking/{booking_id}/show', [PackageControllers::class, 'bookingShow'])->name('package.booking.show');
        $router->post('/booking/{booking_id}/approved', [PackageControllers::class, 'approvedPackageBooking'])->name('package.booking.approved');
        $router->post('/booking/{booking_id}/cancelled', [PackageControllers::class, 'cancelledPackageBooking'])->name('package.booking.cancelled');
    });

    $router->group(['prefix' => 'slider'], function ($router) {
        $router->get('/list', [SlidersController::class, 'index'])->name('slider.list');
        $router->get('/{id}/show', [SlidersController::class, 'show'])->name('slider.show');
        $router->get('/create', [SlidersController::class, 'create'])->name('slider.create');
        $router->post('/create', [SlidersController::class, 'store'])->name('slider.store');
        $router->get('/{id}/edit', [SlidersController::class, 'edit'])->name('slider.edit');
        $router->put('/{id}/update', [SlidersController::class, 'update'])->name('slider.update');
        $router->delete('/{id}/delete', [SlidersController::class, 'destroy'])->name('slider.delete');
    });

    /*ajax loading*/
    Route::group(['prefix' => 'load'], function($router) {
        $router->post('/district', [AjaxLoadController::class, 'getDistrict'])->name('get.district');
        $router->post('/upazila', [AjaxLoadController::class, 'getUpazila'])->name('get.upazila');
        $router->post('/occasion', [AjaxLoadController::class, 'getSeason'])->name('get.season.pricing');
        $router->post('/season-price-room', [AjaxLoadController::class, 'getSeasonWithRoom'])->name('get.season.pricing.room');
        $router->post('/rooms', [AjaxLoadController::class, 'getRooms'])->name('get.rooms');
        $router->post('/guest/list', [AjaxLoadController::class, 'getGuestList'])->name('get.guest.list');
        $router->post('/single/guest', [AjaxLoadController::class, 'getSingleGuest'])->name('get.guest.data');
        $router->post('/quick-booking-room', [AjaxLoadController::class, 'getQuickBookingRooms'])->name('get.quick.booking.rooms');
        $router->post('/guests', [AjaxLoadController::class, 'getGuest'])->name('get.guests');
        $router->post('/room-booking-calendar', [AjaxLoadController::class, 'getRoomBookingCalendar'])->name('get.room.booking.calendar');
        $router->get('/package', [AjaxLoadController::class, 'getPackage'])->name('get.package');
    });


});


