<?php

use App\Http\Controllers\API\AddressbookController;
use App\Http\Controllers\API\AddressBookShareController;
use App\Http\Controllers\API\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [LoginController::class, 'check']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/address_books', AddressBookController::class);

    Route::get('/shares', [AddressBookShareController::class, 'index']);
    Route::get('/shares/{address_book}/to', [AddressBookShareController::class, 'show_users']);
    Route::post('/shares/{address_book}/to/{user}', [AddressBookShareController::class, 'store']);
    Route::delete('/shares/cancel/{address_book_share}', [AddressBookShareController::class, 'destroy']);

    Route::post('/logout', [LoginController::class, 'logout']);
});
