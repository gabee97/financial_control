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
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Identificador único para a categoria
            $table->string('name'); // Nome da categoria
            $table->enum('type', ['fixed', 'variable']); // Tipo de despesa: fixa ou variável
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relacionamento com a tabela de usuários
            $table->timestamps(); // Campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
