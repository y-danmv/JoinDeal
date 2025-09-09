<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // importante para login futuro
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Permitir preenchimento em massa para esses campos
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Se quiser esconder a senha em arrays/json
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
