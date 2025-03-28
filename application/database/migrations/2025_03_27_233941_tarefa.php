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
<<<<<<< HEAD
        Schema::create('tarefas', function (Blueprint $table) {
=======
        Schema::create('tarefa', function (Blueprint $table) {
>>>>>>> 2de50fa57a62931cb280ac56bd6feb15929916a6
            $table->id()->primary();
            $table->string('descricao');
            $table->timestamp('data_criacao');
            $table->timestamp('data_prevista')->nullable();
            $table->timestamp('data_encerramento')->nullable();
            $table->string('situacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarefa');
    }
};
