<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financeiro extends Model
{
    use HasFactory;

    protected $table = 'financeiro';

    protected $fillable = [
        'imovel_id',
        'data_vencimento',
        'valor',
        'data_pagamento',
        'valor_pago',
    ];
}
