<?php

use App\Http\Controllers\Admin\AdminControler;
use App\Http\Controllers\Admin\Auth\LoginControler;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\LoyalityControler;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\RoomControler;
use Illuminate\Support\Facades\Route;

  Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [LoginControler::class, 'create'])->name('admin.login');

    Route::post('/login', [LoginControler::class, 'store'])->name('admin.store');
    
    Route::post('logout', [LoginControler::class, 'destroy'])->name('admin.logout');

});


Route::middleware('auth:admin')->prefix('admin')->group(function () {

    Route::get('/index', [AdminControler::class, 'index'])->name('admin.index');

    Route::group(['prefix' => 'rooms'], function () {

        Route::get('/view', [RoomControler::class, 'index'])->name('admin.rooms.view');

        Route::get('/create', [RoomControler::class, 'create'])->name('admin.rooms.create');

        Route::post('/store', [RoomControler::class, 'store'])->name('admin.rooms.store');

        Route::get('/edit/{id}', [RoomControler::class, 'edit'])->name('admin.rooms.edit');

        Route::put('/update/{id}', [RoomControler::class, 'update'])->name('admin.rooms.update');

    });
    Route::group(['prefix' => 'offers'], function () {

        Route::get('/index', [OfferController::class, 'index'])->name('admin.offers.index');

        Route::get('/create', [OfferController::class, 'create'])->name('admin.offers.create');

        Route::post('/store', [OfferController::class, 'store'])->name('admin.offers.store');

        Route::get('/edit/{id}', [OfferController::class, 'edit'])->name('admin.offers.edit');

        Route::put('/offers/update/{id}', [OfferController::class, 'update'])->name('admin.offers.update');
        
        Route::put('/offers/update/status/{id}', [OfferController::class, 'updateOfferStatus'])->name('admin.offers.update.status');
        
        
        Route::delete('/{id}', [OfferController::class, 'destroy'])->name('admin.offers.delete');

    });

    Route::group(['prefix' => 'loyality'], function () {

        Route::get('/index', [LoyalityControler::class, 'index'])->name('admin.loyality.index');


        Route::post('/store', [LoyalityControler::class, 'store'])->name('admin.loyality.store');

        Route::get('/edit/{id}', [LoyalityControler::class, 'edit'])->name('admin.loyality.edit');

        Route::put('/update/{id}', [LoyalityControler::class, 'update'])->name('admin.loyality.update');
                
        Route::delete('/{id}', [LoyalityControler::class, 'destroy'])->name('admin.loyality.delete');

    });
    Route::group(['prefix' => 'booking'], function () {

        Route::get('/index', [BookingController::class, 'index'])->name('admin.bookings.index');

        Route::get('/cancel/{id}', [BookingController::class, 'edit'])->name('cancel.booking');

        Route::get('/checkin/{id}', [BookingController::class, 'checkIn'])->name('checkin');

        Route::get('/checkout/{id}', [BookingController::class, 'checkOut'])->name('checkout');

        Route::get('/edit/{id}', [NotificationController::class, 'edit'])->name('admin.notification.edit');


    });

    // Route::get('/profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');

    // Route::patch('/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');

    // Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('admin.password.confirm');

    // Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Route::put('/password', [PasswordController::class, 'update'])->name('admin.password.update');

    // Route::post('logout', [Login::class, 'destroy'])
    // ->name('logout');


});

?>