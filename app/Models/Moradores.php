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
        'user_id'
    ];

    public function imoveis()
    {
        return $this->belongsTo(Imoveis::class, 'imovel_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
