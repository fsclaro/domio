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
        Schema::create('moradores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('imovel_id');
            $table->string('nome', 80);
            $table->date('data_nascimento');
            $table->string('cpf', 14)->unique();
            $table->string('sexo', 1);
            $table->string('fone', 20);
            $table->string('email', 40);
            $table->timestamps();

            $table->foreign('imovel_id')->references('id')->on('imoveis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moradores');
    }
};
