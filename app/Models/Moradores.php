<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moradores extends Model
{
    use HasFactory;

    protected $table = 'moradores';

    protected $fillable = [
        'imovel_id',
        'nome',
        'data_nascimento',
        'cpf',
        'sexo',
        'fone',
        'email',
    ];
}
