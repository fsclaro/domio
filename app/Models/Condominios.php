<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condominios extends Model
{
    use HasFactory;

    protected $table = 'condominios';

    protected $fillable = [
        'tipo_origem',
        'tipo_comunicado',
        'imovel_id',
        'user_envio_id',
        'dt_comunicado',
        'mensagem',
        'acao',
        'dt_visualizacao',
        'user_visualizacao_id',
    ];
}
