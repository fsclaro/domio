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
        Schema::create('imoveis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_condomio')->references('id')->on('condominio');
            $table->integer('tipo');
            $table->string('logradouro', 80);
            $table->string('nro', 10);
            $table->string('bairro', 40);
            $table->string('cep', 9);
            $table->string('cidade', 50);
            $table->string('uf', 2)->default('SP');
            $table->boolean('ativo')->default(true);
            $table->string('fone_proprietario', 20);
            $table->string('email_proprietario', 40);
            $table->string('nome_proprietario', 80);
            $table->string('cpf_proprietario', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imoveis');
    }
};
