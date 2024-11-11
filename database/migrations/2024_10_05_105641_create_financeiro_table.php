<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('financeiro', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('imovel_id');
            $table->date('data_vencimento');
            $table->decimal('valor', 10, 2);
            $table->date('data_pagamento');
            $table->decimal('valor_pago', 10, 2);
            $table->timestamps();

            $table->foreign('imovel_id')->references('id')->on('imoveis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financeiro');
    }
};
