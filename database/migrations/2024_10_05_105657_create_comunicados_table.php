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
        Schema::create('comunicados', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_origem', [1,2]);
            // $table->enum('tipo_comunicado', [0,1,2]);
            $table->unsignedBigInteger('condominio_id');
            $table->unsignedBigInteger('user_envio_id');
            $table->date('dt_comunicado');
            $table->text('mensagem');
            // $table->enum('acao', [1,2,3,4]);
            // $table->date('dt_visualizacao');
            // $table->unsignedBigInteger('user_visualizacao_id');
            $table->timestamps();

            $table->foreign('condominio_id')->references('id')->on('condominios');
            $table->foreign('user_envio_id')->references('id')->on('users');
            // $table->foreign('user_visualizacao_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comunicados');
    }
};
