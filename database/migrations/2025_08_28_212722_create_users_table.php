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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            
            // Alterado de 'name' para 'nome' para bater com o PDF
            $table->string('nome', 100); 
            
            $table->string('email', 100)->unique(); 
            
            // NOVOS ATRIBUTOS ADICIONADOS
            $table->string('cidade', 100)->nullable(); // Cidade do usuário
            $table->string('cpf', 14)->unique()->nullable(); // CPF (com 14 caracteres para a máscara)
            
            // MODIFICADO: 'Funcionario' alterado para 'Prestador'
            $table->enum('tipo', ['Cliente', 'Prestador'])->default('Cliente'); // Tipo de usuário
            
            $table->string('password', 200); 
            $table->dateTime('last_login')->nullable(); 
            $table->timestamps(); 
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};