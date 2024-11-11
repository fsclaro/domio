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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('cpf_administrador', 14);
            $table->string('fone_administrador', 20);
            $table->string('razao_social', 50)->unique();
            $table->string('nome_fantasia', 50)->unique();
            $table->string('cnpj', 18)->unique();
            $table->string('inscricao_estadual', 15)->unique();
            $table->string('fone', 20);
            $table->string('email', 40);
            $table->string('logradouro', 80);
            $table->string('nro', 10);
            $table->string('complemento', 50);
            $table->string('bairro', 40);
            $table->string('cep', 9);
            $table->string('cidade', 50);
            $table->string('uf', 2);
            $table->boolean('ativo')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
