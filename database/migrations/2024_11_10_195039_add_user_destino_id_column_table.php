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
        Schema::table('comunicados', function (Blueprint $table) {
            $table->unsignedBigInteger('user_destino_id')->nullable()->after('user_envio_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comunicados', function (Blueprint $table) {
            $table->dropColumn('user_destino_id');
        });
    }
};
