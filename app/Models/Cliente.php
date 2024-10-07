<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        "users_id",
        "cnpj",
        "inscricao_estadual",
        "razao_social",
        "nome_fantasia",
        "fone",
        "email",
        "logradouro",
        "nro",
        "complemento",
        "bairro",
        "cep",
        "cidade",
        "uf",
        "ativo",
        "nome_administrador",
        "cpf_administrador",
        "fone_administrador",
        "email_administrador",
    ];

    protected $casts = [
        "ativo"=> "boolean",
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
