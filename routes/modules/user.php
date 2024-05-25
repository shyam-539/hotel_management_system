<?php

use App\Http\Controllers\User\Auth\ConfirmablePasswordController;
use App\Http\Controllers\User\Auth\LoginControler;
use App\Http\Controllers\User\Auth\PasswordController;
use App\Http\Controllers\User\Auth\RegisteredUserController;
use App\Http\Controllers\User\BookingControler;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\ProfileControler;
use App\Http\Controllers\User\RatingController;
use App\Http\Controllers\User\RoomControler;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

   Route::group(['prefix' => 'user'], function () {

        Route::get('register', [RegisteredUserController::class, 'create'])->name('user.register');

        Route::post('register', [RegisteredUserController::class, 'store'])->name('user.register.store');

        Route::get('/login', [LoginControler::class, 'create'])->name('user.login');

        Route::post('/login', [LoginControler::class, 'store'])->name('user.store');

        Route::post('logout', [LoginControler::class, 'destroy']) ->name('user.logout');
    });


    Route::middleware('auth:web')->prefix('user')->group(function () {

        Route::get('/index', [UserController::class, 'index'])->name('user.index');

        Route::get('/profile/edit', [ProfileControler::class, 'edit'])->name('user.profile.edit');

        Route::patch('/profile', [ProfileControler::class, 'update'])->name('user.profile.update');

        Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('user.password.confirm');

        Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);

        Route::put('/password', [PasswordController::class, 'update'])->name('user.password.update');

        Route::group(['prefix' => 'rooms'], function () {

        Route::get('/view', [RoomControler::class, 'index'])->name('user.rooms.index');

        Route::get('/booking/{id}', [BookingControler::class, 'Booking'])->name('user.room.booking');

        Route::post('/confirm-booking/{id}', [BookingControler::class, 'store'])->name('user.room.confirm.booking');

        });

        Route::group(['prefix' => 'booking'], function () {

            Route::get('/show', [BookingControler::class, 'show'])->name('user.booking.show');

            Route::get('/cancel/{id}', [BookingControler::class, 'edit'])->name('user.cancel.booking');
        });
        
        Route::group(['prefix' => 'rating'], function () {

            Route::get('/create/{id}', [RatingController::class, 'create'])->name('user.rating.create');

            Route::post('/store', [RatingController::class, 'store'])->name('user.rating.store');

            Route::get('/edit/{id}', [RatingController::class, 'edit'])->name('user.rating.edit');

            Route::put('/update/{id}', [RatingController::class, 'update'])->name('user.rating.update');

        });

        Route::group(['prefix' => 'notification'], function () {

            Route::get('/edit/{id}', [NotificationController::class, 'edit'])->name('user.notification.edit');

        });


    });

?>