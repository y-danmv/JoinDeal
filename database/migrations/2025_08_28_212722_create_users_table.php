<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); 
            $table->string('email', 100)->unique(); 
            
            // NOVOS ATRIBUTOS ADICIONADOS
            $table->string('cidade', 100)->nullable(); // Cidade do usuário
            $table->string('cpf', 14)->unique()->nullable(); // CPF (com 14 caracteres para a máscara), com índice único
            $table->enum('tipo', ['Cliente', 'Funcionario'])->default('Cliente'); // Tipo de usuário (Enum)
            
            $table->string('password', 200); 
            $table->dateTime('last_login')->nullable(); 
            $table->timestamps(); 
            $table->softDeletes(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};