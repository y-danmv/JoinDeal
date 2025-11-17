<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'titulo', 'descricao', 'valor', 'categoria', 'usuario_id', 
    ];

    // Relacionamento: Um Serviço pertence a um Prestador (User)
    public function prestador() {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relacionamento: Um Serviço pode ter muitas Contratações (Orders)
    public function orders() {
        return $this->hasMany(Order::class, 'servico_id');
    }
}