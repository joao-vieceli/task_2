<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tarefa;

class TarefaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tarefa::create([
            'descricao' => 'Tarefa de Exemplo',
            'data_criacao' => now(),
            'data_prevista' => now()->addDays(10),
            'data_encerramento' => now()->addDays(15),
            'situacao' => 'pendente',
        ]);

        Tarefa::create([
            'descricao' => 'Tarefa de Exemplo',
            'data_criacao' => now(),
            'data_prevista' => now()->addDays(10),
            'data_encerramento' => now()->addDays(15),
            'situacao' => 'pendente',
        ]);

        Tarefa::create([
            'descricao' => 'Tarefa de Exemplo 2',
            'data_criacao' => now(),
            'data_prevista' => now()->addDays( 15),
            'data_encerramento' => now()->addDays(20),
            'situacao' => 'concluida',
        ]);

        Tarefa::create([
            'descricao' => 'Tarefa de Exemplo 3',
            'data_criacao' => now(),
            'data_prevista' => now()->addDays(5),
            'data_encerramento' => now()->addDays(35),
            'situacao' => 'pendente',
        ]);

        Tarefa::create([
            'descricao' => 'Tarefa de Exemplo 4',
            'data_criacao' => now(),
            'data_prevista' => now()->addDays(100),
            'data_encerramento' => now()->addDays(153),
            'situacao' => 'cancelada',
        ]);

        Tarefa::create([
            'descricao' => 'Tarefa de Exemplo 5',
            'data_criacao' => now(),
            'data_prevista' => now()->addDays(103),
            'data_encerramento' => now()->addDays(1521),
            'situacao' => 'concluida',
        ]);

        // Inserir múltiplas tarefas usando a factory
        //Tarefa::factory()->count(10)->create();
    }
}
