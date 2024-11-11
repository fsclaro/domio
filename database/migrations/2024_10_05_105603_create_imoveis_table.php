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
            $table->unsignedBigInteger('condominio_id');
            $table->enum('tipo', [1,2]);
            $table->string('logradouro', 80);
            $table->string('nro', 10);
            $table->string('complemento', 50)->nullable();
            $table->string('bairro', 40);
            $table->string('cep', 9);
            $table->string('cidade', 50);
            $table->string('uf', 2);
            $table->boolean('ativo')->default(true);
            $table->string('nome_proprietario', 50);
            $table->string('cpf_proprietario', 14);
            $table->string('fone_proprietario', 20);
            $table->string('email_proprietario', 40);
            $table->timestamps();
            $table->foreign('condominio_id')->references('id')->on('condominios');
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
