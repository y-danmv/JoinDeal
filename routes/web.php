<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| 1. Rotas Públicas Específicas
|--------------------------------------------------------------------------
*/
Route::GET('/', [AuthController::class, 'home'])->name('home');

/*
|--------------------------------------------------------------------------
| 2. Rotas de Visitantes (Apenas quem NÃO está logado)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::GET('/login', [AuthController::class, 'login'])->name('login');
    Route::POST('/loginSubmit', [AuthController::class, 'loginSubmit'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/registerSubmit', [AuthController::class, 'registerSubmit'])->name('register.submit');
});

/*
|--------------------------------------------------------------------------
| 3. Rotas Protegidas (Exigem Login)
|--------------------------------------------------------------------------
| IMPORTANTE: Estas rotas vêm ANTES das rotas públicas de serviço para
| evitar conflito. O Laravel vai ler '/services/create' aqui primeiro.
*/
Route::middleware('auth')->group(function () {
    
    // Logout
    Route::GET('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- Rotas de Serviços (Apenas para criar/editar/deletar) ---
    // Definimos manualmente para garantir a ordem correta
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // --- Rotas de Usuários ---
    Route::resource('users', UserController::class)->except(['create', 'store']); 

    // --- Rotas de Contratações ---
    Route::get('/contratacoes', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/servicos/{service}/contratar', [OrderController::class, 'store'])->name('orders.store');
    Route::patch('/contratacoes/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

/*
|--------------------------------------------------------------------------
| 4. Rotas Públicas de Visualização (Ficam por último)
|--------------------------------------------------------------------------
| Deixamos estas por último porque '/services/{service}' captura qualquer
| coisa. Se estivesse no topo, capturaria o 'create' e daria erro.
*/
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');