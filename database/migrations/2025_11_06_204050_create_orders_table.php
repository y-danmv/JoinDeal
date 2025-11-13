<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('servico_id')->constrained('services')->onDelete('cascade');
            $table->string('status')->default('pendente');
            $table->datetime('data_contratacao');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('orders'); }
};