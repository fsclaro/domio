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
        Schema::create('condominios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clientes_id');
            $table->string('razao_social', 50)->unique();
            $table->string('nome_fantasia', 50)->unique();
            $table->string('cnpj', 18)->unique();
            $table->string('logradouro', 80);
            $table->string('nro', 10);
            $table->string('complemento', 50)->nullable();
            $table->string('bairro', 40);
            $table->string('cep', 9);
            $table->string('cidade', 50);
            $table->string('uf', 2);
            $table->boolean('ativo')->default(true);
            $table->string('nome_sindico', 50);
            $table->string('cpf_sindico', 14);
            $table->string('fone_sindico', 20);
            $table->string('email_sindico', 40);
            $table->timestamps();

            $table->foreign('clientes_id')->references('id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('condominios');
    }
};
