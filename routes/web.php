<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::GET('/', [AuthController::class, 'home'])->name('home');

Route::GET('/login', [AuthController::class, 'login'])->name('login');
Route::POST('/loginSubmit', [AuthController::class, 'loginSubmit'])->name('login.submit');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerSubmit'])->name('register.submit');

Route::GET('/logout', [AuthController::class, 'logout'])->name('logout');

