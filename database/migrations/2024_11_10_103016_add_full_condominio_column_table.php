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
        Schema::table('condominios', function (Blueprint $table) {
            $table->string('full_condominio')
                ->after('email_sindico')
                ->virtualAs('CONCAT(razao_social, " - ", logradouro, ", ", nro)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('condominios', function (Blueprint $table) {
            $table->dropColumn('full_condominio');
        });
    }
};
