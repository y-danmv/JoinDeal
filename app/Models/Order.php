<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // <-- ALTERAÇÃO AQUI: Adicionado 'data_agendamento'
    protected $fillable = [
        'cliente_id', 'servico_id', 'status', 'data_contratacao', 'data_agendamento',
    ];
    // FIM DA ALTERAÇÃO

    // <-- ALTERAÇÃO AQUI: Adicionado o cast para Carbon
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data_contratacao' => 'datetime',
        'data_agendamento' => 'datetime', // Garante que será sempre um objeto Carbon
    ];
    // FIM DA ALTERAÇÃO


    // Relacionamento: Uma Contratação pertence a um Cliente (User)
    public function cliente() {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    // Relacionamento: Uma Contratação pertence a um Serviço (Service)
    public function service() {
        return $this->belongsTo(Service::class, 'servico_id');
    }
}