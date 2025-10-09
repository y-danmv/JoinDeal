<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; 

class User extends Authenticatable
{
    /**
     * Os atributos que são 'mass assignable', incluindo os novos campos.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cidade', // NOVO: Cidade do usuário
        'cpf',    // NOVO: CPF do usuário
        'tipo',   // NOVO: Tipo de usuário (Funcionário/Cliente)
    ];

    /**
     * Os atributos que devem ser escondidos para arrays.
     */
    protected $hidden = [
        'password',
    ];
}