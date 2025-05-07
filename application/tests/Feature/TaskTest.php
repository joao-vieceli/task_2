<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Tarefa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function loginTest()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        return $user;
    }

    /** Esse teste faz o login de teste e tenta criar uma tarefa genérica para testar se essa
     * funcionalidade está funcionando. O teste verifica se a tarefa foi criada com sucesso
     * e se os dados estão corretos no banco de dados.
     * @test
    */
    public function criar_tarefa_teste()
    {

        $user = $this->loginTest();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->post(route('tasks.store'), [
            'descricao' => 'Teste de Tarefa',
            'situacao' => 'Pendente',
            'data_prevista' => now()->addDays(1),
            'data_encerramento' => now()->addDays(2),
        ]);
    
        $response->assertRedirect();
    
        $this->assertDatabaseHas('tarefas', [
            'descricao' => 'Teste de Tarefa',
            'situacao' => 'Pendente',
        ]);
    }

    /**
     *
     * A função `carregar_lista_de_tarefas_teste` verifica se a lista de tarefas
     * é carregada corretamente. O teste faz o login do usuário, cria 3 tarefas
     * e faz uma requisição GET para a rota '/tasks'. Em seguida, verifica se
     * a resposta tem o status 200 e se o texto 'Tarefa' aparece na view.
     *
     * @arquivo /home/joao/projetos/task_2/application/tests/Feature/TaskTest.php
     *
     * @test */
    public function carregar_lista_de_tarefas_teste()
    {
        $this->loginTest();

        Tarefa::factory()->count(3)->create();

        $response = $this->get('/tasks');

        $response->assertStatus(200);
        $response->assertSeeText('Tarefa'); // Verifica se o texto aparece na view
    }

    /** 
     * Essa função 'altera_tarefa' verifica se a tarefa é alterada corretamente.
     * 
     * @test */
    public function altera_tarefa_teste()
    {
        $this->loginTest();

        $Tarefa = Tarefa::factory()->create();

        $response = $this->put("/tasks/{$Tarefa->id}", [
            'descricao' => 'Atualizada',
            'data_prevista' => now(),
            'data_encerramento' => now(),
            'situacao' => 'Em Andamento',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('tarefas', ['id' => $Tarefa->id, 'descricao' => 'Atualizada']);
    }

    /** 
     * 
     * Essa função 'excluir_tarefa' verifica se a tarefa é excluída corretamente.
     * 
     * @test */
    public function excluir_tarefa_teste()
    {

        $this->loginTest();

        $Tarefa = Tarefa::factory()->create();

        $response = $this->delete("/tasks/{$Tarefa->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('tarefas', ['id' => $Tarefa->id]);
    }

    /** @test */
    public function gerar_pdf_tarefas_teste()
    {
        $this->loginTest();

        Tarefa::factory()->count(3)->create();

        $response = $this->get(route('tasks.exportPdf'));

        $response->assertStatus(200);

        $response->assertHeader('Content-Type', 'application/pdf');

        $this->assertStringStartsWith('%PDF', $response->getContent());
    }

    /** @test */
    public function filtra_tarefas_por_descricao()
    {
        $this->loginTest();

        Tarefa::factory()->create(['descricao' => 'Relatório Final']);
        Tarefa::factory()->create(['descricao' => 'Reunião com cliente']);
        Tarefa::factory()->create(['descricao' => 'Apresentação']);

        $response = $this->get('/tasks?descricao=Relatório');

        $response->assertStatus(200);

        $response->assertSeeText('Relatório Final');

        $response->assertDontSeeText('Reunião com cliente');
        $response->assertDontSeeText('Apresentação');
    }
}
