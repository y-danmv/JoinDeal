<?php

namespace App\Models; // <-- Verifique se está EXATAMENTE assim

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// 'use' para os relacionamentos
use App\Models\User;
use App\Models\Order;

class Service extends Model // <-- Verifique se o nome da classe está EXATAMENTE assim
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descricao',
        'valor',
        'categoria',
        'usuario_id', 
    ];

    /**
     * Relacionamento: Um Serviço pertence a um Prestador (User).
     */
    public function prestador()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relacionamento: Um Serviço pode ter muitas Contratações (Orders).
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'servico_id');
    }
}