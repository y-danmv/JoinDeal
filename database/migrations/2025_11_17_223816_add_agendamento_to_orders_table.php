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
            // <-- ALTERAÇÃO AQUI
            // Adicionamos a coluna 'data_agendamento'
            // Ela pode ser nula inicialmente, se você já tiver dados,
            // mas para novas contratações, vamos torná-la obrigatória no controller.
            // Coloquei 'after' para organizar, mas é opcional.
            $table->datetime('data_agendamento')->nullable()->after('servico_id');
            // FIM DA ALTERAÇÃO
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // <-- ALTERAÇÃO AQUI
            // Lógica para remover a coluna caso você reverta a migration
            $table->dropColumn('data_agendamento');
            // FIM DA ALTERAÇÃO
        });
    }
};