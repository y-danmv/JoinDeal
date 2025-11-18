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
        Schema::table('orders', function (Blueprint $table) {

            $table->datetime('data_agendamento')->nullable()->after('servico_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Lógica para remover a coluna caso você reverta a migration
            $table->dropColumn('data_agendamento');
            // FIM DA ALTERAÇÃO
        });
    }
};