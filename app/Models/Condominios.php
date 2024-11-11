<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condominios extends Model
{
    use HasFactory;

    protected $table = 'condominios';

    protected $fillable = [
        'clientes_id',
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'logradouro',
        'nro',
        'complemento',
        'bairro',
        'cep',
        'cidade',
        'uf',
        'ativo',
        'nome_sindico',
        'cpf_sindico',
        'fone_sindico',
        'email_sindico',
        'full_condominio',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    public function clientes()
    {
        return $this->belongsTo(Cliente::class, 'clientes_id');
    }

}
