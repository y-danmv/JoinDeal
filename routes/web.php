<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Rotas Públicas (Não exigem login)
|--------------------------------------------------------------------------
*/
Route::GET('/', [AuthController::class, 'home'])->name('home');

// Rotas de Serviços que TODOS podem ver (listagem e detalhes)
Route::resource('services', ServiceController::class)->only(['index', 'show']);


/*
|--------------------------------------------------------------------------
| Rotas de Visitantes (Apenas para quem NÃO está logado)
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
| Rotas Protegidas (Exigem Login - 'auth')
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    
    // Rota de Logout
    Route::GET('/logout', [AuthController::class, 'logout'])->name('logout');

    // Rotas de CRUD para Usuários (protegidas)
    Route::resource('users', UserController::class)->except(['create', 'store']); 

    // Rotas de Serviços (protegidas)
    // (A 'index' e 'show' já foram definidas fora do grupo)
    Route::resource('services', ServiceController::class)->except(['index', 'show']);

    // Rotas de Contratações (protegidas)
    Route::get('/contratacoes', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/servicos/{service}/contratar', [OrderController::class, 'store'])->name('orders.store');
    Route::patch('/contratacoes/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

});