<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['middleware' => ['auth']], function () {

    // book
    Route::resource('books', BookController::class);
    Route::get('search', [BookController::class, 'search'])->name('books.search');

    // cart
    Route::get('bookCart', [BookController::class, 'bookCart'])->name('books.cart');
    Route::post('/cart/add', [BookController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/delete', [BookController::class, 'deleteItem'])->name('delete.cart.item');

    // profile
    Route::get('profile', [ProfileController::class, 'editProfile'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

    // checkout
    Route::get('getCheckoutForm', [BookController::class, 'getCheckoutForm'])->name('getCheckoutForm');
    Route::get('checkout', [BookController::class, 'checkout'])->name('cart.checkout');

});
