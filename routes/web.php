<?php

use App\Http\Controllers\AddressBookController;
use App\Http\Controllers\AddressBookShareController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'check'])->name('check');

Route::middleware('auth')->group(function () {
    Route::resource('/address_books', AddressBookController::class);
    Route::get('/shares', [AddressBookShareController::class, 'index'])->name('address_book_shares.index');
    Route::get('/shares/{address_book}/to', [AddressBookShareController::class, 'show_users'])->name('address_book_shares.show_users');
    Route::post('/shares/{address_book}/to/{user}', [AddressBookShareController::class, 'store'])->name('address_book_shares.store');
    Route::delete('/shares/cancel/{address_book_share}', [AddressBookShareController::class, 'destroy'])->name('address_book_shares.delete');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('/', function () {
    return view('welcome');
});
