<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes; 

    protected $fillable = [
        'nome', 'email', 'password', 'cidade', 'cpf', 'tipo', 'last_login',
    ];
    protected $hidden = ['password', 'remember_token'];
    protected function casts(): array {
        return [
            'password' => 'hashed',
            'last_login' => 'datetime', 
        ];
    }

    // Relacionamento: Um Prestador tem muitos Serviços
    public function services() {
        return $this->hasMany(Service::class, 'usuario_id');
    }

    // Relacionamento: Um Cliente tem muitas Contratações
    public function ordersAsClient() {
        return $this->hasMany(Order::class, 'cliente_id');
    }

    // Relacionamento: Um Prestador tem muitas Contratações (através dos seus serviços)
    public function ordersAsProvider() {
        return $this->hasManyThrough(
            Order::class,     // Tabela final que queremos acessar
            Service::class,   // Tabela intermediária
            'usuario_id', // Chave estrangeira na tabela Service (liga User com Service)
            'servico_id'  // Chave estrangeira na tabela Order (liga Service com Order)
        );
    }
}