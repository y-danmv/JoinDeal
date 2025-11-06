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
        // Tabela 'Contratações' (orders)
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            // Chave estrangeira para o cliente (usuário)
            $table->foreignId('cliente_id')
                  ->constrained('users') // Referencia 'id' em 'users'
                  ->onDelete('cascade'); 
            
            // Chave estrangeira para o serviço
            $table->foreignId('servico_id')
                  ->constrained('services') // Referencia 'id' em 'services'
                  ->onDelete('cascade');
            
            // Status (conforme PDF)
            $table->enum('status', ['pendente', 'em andamento', 'concluido'])
                  ->default('pendente');
            
            $table->date('data_contratacao');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};