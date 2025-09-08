<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::GET('/login', [AuthController::class, 'login'])->name('login');

Route::POST('/loginSubmit', [AuthController::class, 'loginSubmit'])->name('login.submit');

Route::GET('/logout', [AuthController::class, 'logout'])->name('logout');
