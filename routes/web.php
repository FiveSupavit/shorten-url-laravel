<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShortUrlController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/shorten', [ShortUrlController::class, 'index'])->name('shorten.index');
    Route::post('/shorten', [ShortUrlController::class, 'store'])->name('shorten.store');
    Route::put('/shorten/{id}', [ShortUrlController::class, 'update'])->name('shorten.update');
    Route::delete('/shorten/{id}', [ShortUrlController::class, 'destroy'])->name('shorten.destroy');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/{code}', [ShortUrlController::class, 'redirect'])->name('shorten.redirect');
