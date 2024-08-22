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
        Schema::create('condominio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_nossos_clientes')->references('id')->on('nossos_clientes');
            $table->string('nome_sindico', 50);
            $table->string('cpf_sindico', 20);
            $table->string('logradouro', 80);
            $table->string('nro', 10);
            $table->string('bairro', 40);
            $table->string('cep', 9);
            $table->string('cidade', 50);
            $table->string('uf', 2)->default('SP');
            $table->boolean('ativo')->default(true);
            $table->string('cnpj', 18)->unique();
            $table->string('nome_fantasia', 50);
            $table->string('razao_social', 50);
            $table->string('fone', 20);
            $table->string('email', 40);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('condominio');
    }
};

