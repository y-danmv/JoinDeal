<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

// LINHAS QUE PROVAVELMENTE FALTAVAM:
use App\Models\Service; // <--- ADICIONE ESTA LINHA
use App\Models\Order;   // <--- ADICIONE ESTA LINHA

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes; 

    protected $fillable = [
        'nome', 
        'email',
        'password',
        'cidade',
        'cpf',
        'tipo',
        'last_login', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login' => 'datetime', 
        ];
    }

    // ----- RELACIONAMENTOS -----

    /**
     * Relacionamento: Um Prestador (User) tem muitos Serviços.
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'usuario_id');
    }

    /**
     * Relacionamento: Um Cliente (User) tem muitas Contratações (como cliente).
     */
    public function ordersAsClient()
    {
        return $this->hasMany(Order::class, 'cliente_id');
    }

    /**
     * Relacionamento: Um Prestador (User) tem muitas Contratações (como prestador).
     */
    public function ordersAsProvider()
    {
        return $this->hasManyThrough(
            Order::class,       
            Service::class,     
            'usuario_id', 
            'servico_id'  
        );
    }
}