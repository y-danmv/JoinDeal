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
        $table->string('name', 100); // nome do usuário
        $table->string('email', 100)->unique(); // email único
        $table->string('password', 200); // senha
        $table->dateTime('last_login')->nullable(); // última vez que logou
        $table->timestamps(); // created_at e updated_at
        $table->softDeletes(); // deleted_at
    });
}
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
