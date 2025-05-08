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

    public function test_criar_tarefa()
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

    public function test_carregar_lista_de_tarefas()
    {
        $this->loginTest();

        Tarefa::factory()->count(3)->create();

        $response = $this->get('/tasks');

        $response->assertStatus(200);
        $response->assertSeeText('Tarefa');
    }

    public function test_altera_tarefa()
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

    public function test_excluir_tarefa()
    {

        $this->loginTest();

        $Tarefa = Tarefa::factory()->create();

        $response = $this->delete("/tasks/{$Tarefa->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('tarefas', ['id' => $Tarefa->id]);
    }


    public function test_gerar_pdf_tarefas()
    {
        $this->loginTest();

        Tarefa::factory()->count(3)->create();

        $response = $this->get(route('tasks.exportPdf'));

        $response->assertStatus(200);

        $response->assertHeader('Content-Type', 'application/pdf');

        $this->assertStringStartsWith('%PDF', $response->getContent());
    }


    public function test_filtra_tarefas_por_descricao()
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

    public function test_criar_tarefa_com_data_encerramento_antes_de_hoje()
    {
        $this->loginTest();

        $response = $this->post(route('tasks.store'), [
            'descricao' => 'Tarefa com datas inválidas',
            'situacao' => 'Pendente',
            'data_prevista' => now()->addDays(3),
            'data_encerramento' => now()->addDays(1),
        ]);

        $response->assertSessionHasErrors(['data_encerramento']);
    }
    
    public function test_criar_tarefa_sem_descricao()
    {
        $this->loginTest();

        $response = $this->post(route('tasks.store'), [
            'situacao' => 'Pendente',
            'data_prevista' => now()->addDays(1),
            'data_encerramento' => now()->addDays(2),
        ]);

        $response->assertSessionHasErrors(['descricao']);
    }

}
