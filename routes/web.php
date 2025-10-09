<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController; // Importado o novo controller

Route::GET('/', [AuthController::class, 'home'])->name('home');

Route::GET('/login', [AuthController::class, 'login'])->name('login');
Route::POST('/loginSubmit', [AuthController::class, 'loginSubmit'])->name('login.submit');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/registerSubmit', [AuthController::class, 'registerSubmit'])->name('register.submit');

Route::GET('/logout', [AuthController::class, 'logout'])->name('logout');

// ----------------------------------------------------------------------
// ROTAS DE CRUD PARA USUÁRIOS
// A rota 'resource' cria as seguintes URLs:
// GET /users           -> users.index  (Lista)
// GET /users/{user}    -> users.show   (Detalhe)
// GET /users/{user}/edit -> users.edit (Formulário de edição)
// PUT/PATCH /users/{user} -> users.update (Salva edição)
// DELETE /users/{user} -> users.destroy (Exclui)
// ----------------------------------------------------------------------
Route::resource('users', UserController::class)->except(['create', 'store']); 
// *O 'create' e 'store' (cadastro) já estão no AuthController (register/registerSubmit), então os excluimos daqui.