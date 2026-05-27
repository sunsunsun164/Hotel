<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HotelController::class, 'index'])->name('home');
Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotels/{id}', [HotelController::class, 'show'])->name('hotels.show');

Route::middleware('guest')->group(function () {
    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
});

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create/{roomId}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings/{roomId}', [BookingController::class, 'store'])->name('bookings.store');
    Route::delete('/bookings/{id}', [BookingController::class, 'cancel'])->name('bookings.cancel');
    
    Route::post('/reviews/{hotelId}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::prefix('staff')->group(function () {
        Route::get('/hotels', [\App\Http\Controllers\StaffHotelController::class, 'index'])->name('staff.hotels.index');
        Route::get('/hotels/{id}', [\App\Http\Controllers\StaffHotelController::class, 'show'])->name('staff.hotels.show');

        Route::get('/hotels/{id}/edit', [\App\Http\Controllers\StaffHotelManagementController::class, 'showEdit'])->name('staff.hotels.edit');
        Route::put('/hotels/{id}', [\App\Http\Controllers\StaffHotelManagementController::class, 'update'])->name('staff.hotels.update');
        Route::post('/hotels/{hotelId}/rooms', [\App\Http\Controllers\StaffHotelManagementController::class, 'storeRoom'])->name('staff.rooms.store');
    });
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/reviews', [App\Http\Controllers\ReviewController::class, 'adminIndex'])->name('admin.reviews.index');
    Route::put('/reviews/{id}/approve', [App\Http\Controllers\ReviewController::class, 'approve'])->name('admin.reviews.approve');
    Route::delete('/reviews/{id}/reject', [App\Http\Controllers\ReviewController::class, 'reject'])->name('admin.reviews.reject');

    Route::get('/hotels/create', [App\Http\Controllers\AdminHotelController::class, 'create'])->name('admin.hotels.create');
    Route::post('/hotels', [App\Http\Controllers\AdminHotelController::class, 'store'])->name('admin.hotels.store');

    Route::delete('/hotels/{hotel}', [App\Http\Controllers\AdminHotelsDeleteController::class, 'destroy'])->name('admin.hotels.destroy');
});
