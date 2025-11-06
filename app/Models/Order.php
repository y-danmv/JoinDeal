<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// LINHAS QUE PROVAVELMENTE FALTAVAM:
use App\Models\Service; // <--- ADICIONE ESTA LINHA
use App\Models\User;    // <--- ADICIONE ESTA LINHA

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'servico_id',
        'status',
        'data_contratacao',
    ];

    /**
     * Relacionamento: Uma Contratação pertence a um Cliente (User).
     */
    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    /**
     * Relacionamento: Uma Contratação pertence a um Serviço (Service).
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'servico_id');
    }
}