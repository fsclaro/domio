<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imoveis extends Model
{
    use HasFactory;

    protected $table = 'imoveis';

    protected $fillable = [
        'condominio_id',
        'tipo',
        'logradouro',
        'nro',
        'complemento',
        'bairro',
        'cep',
        'cidade',
        'uf',
        'ativo',
        'nome_proprietario',
        'cpf_proprietario',
        'fone_proprietario',
        'email_proprietario',
        'full_imovel',
    ];

    public function condominios()
    {
        return $this->belongsTo(Condominios::class, 'condominio_id');
    }

    public function moradores()
    {
        return $this->hasMany(Moradores::class, 'imovel_id');
    }
}
