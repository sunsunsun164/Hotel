<?php

use App\Http\Controllers\HotelController;

Route::prefix('hotels')->group(function(){
    Route::get('/', [HotelController::class ,"index"]);
    Route::get('{hotel}', [HotelController::class ,"get"]);
});
