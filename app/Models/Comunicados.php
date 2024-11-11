<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunicados extends Model
{
    use HasFactory;

    protected $table = 'comunicados';

    protected $fillable = [
        'tipo_origem',
        // 'tipo_comunicado',
        'condominio_id',
        'user_envio_id',
        'user_destino_id',
        'dt_comunicado',
        'mensagem',
        // 'acao',
        // 'dt_visualizacao',
        // 'user_visualizacao_id',
    ];

    public function user_envio()
    {
        return $this->belongsTo(User::class, 'user_envio_id');
    }

    public function user_destino()
    {
        return $this->belongsTo(User::class, 'user_destino_id');
    }

    public function condominios()
    {
        return $this->belongsTo(Condominios::class, 'condominio_id');
    }
}
