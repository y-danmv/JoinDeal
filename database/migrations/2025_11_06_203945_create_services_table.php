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
        // Tabela 'Serviços' (services)
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 100);
            $table->string('descricao', 255);
            $table->decimal('valor', 10, 2); // Decimal é melhor para moeda
            $table->string('categoria', 100);
            
            // Chave estrangeira para o prestador (usuário)
            $table->foreignId('usuario_id')
                  ->constrained('users') // Referencia 'id' em 'users'
                  ->onDelete('cascade'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};