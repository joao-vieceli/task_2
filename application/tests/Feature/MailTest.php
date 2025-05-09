<?php

namespace Tests\Feature;

use App\Mail\TarefaCriadaMail;
use App\Mail\TarefaEditadaMail;
use App\Models\Tarefa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MailTest extends TestCase
{
    public function test_envia_email_ao_criar_tarefa()
    {
        Mail::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('tasks.store'), [
            'descricao' => 'Nova Tarefa Teste',
            'situacao' => 'Pendente',
            'data_prevista' => now()->addDays(1),
            'data_encerramento' => now()->addDays(2),
        ]);

        $response->assertRedirect();

        Mail::assertSent(TarefaCriadaMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function test_alterar_tarefa()
    {
        Mail::fake();

        $user = User::factory()->create();

        $tarefa = Tarefa::factory()->create([
            'descricao' => 'Tarefa Original',
            'situacao' => 'Pendente',
            'data_prevista' => now()->addDays(1),
            'data_encerramento' => now()->addDays(2),
        ]);

        $updatedData = [
            'descricao' => 'Tarefa Atualizada',
            'situacao' => 'Em Andamento',
            'data_prevista' => now()->addDays(3),
            'data_encerramento' => now()->addDays(4),
        ];

        $response = $this->actingAs($user)->put(route('tasks.update', $tarefa->id), $updatedData);

        $this->assertDatabaseHas('tarefas', [
            'id' => $tarefa->id,
            'descricao' => 'Tarefa Atualizada',
            'situacao' => 'Em Andamento',
            'data_prevista' => now()->addDays(3),
            'data_encerramento' => now()->addDays(4),
        ]);

        Mail::assertSent(TarefaEditadaMail::class, function ($mail) use ($tarefa,$user) {
            return $mail->hasTo($user->email) && $mail->tarefa->id === $tarefa->id;
        });

        $response->assertRedirect(route('tasks.index'));

        $response->assertSessionHas('success', 'Tarefa atualizada com sucesso!');
    }

    public function test_nao_envia_email_se_criacao_falhar_por_validacao()
    {
        Mail::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        // 'descricao' está faltando — validação deve falhar
        $response = $this->post(route('tasks.store'), [
            'situacao' => 'Pendente',
            'data_prevista' => now()->addDays(1),
            'data_encerramento' => now()->addDays(2),
        ]);

        $response->assertSessionHasErrors(['descricao']);

        // Verifica que nenhum e-mail foi enviado
        Mail::assertNothingSent();
    }

    public function test_nao_envia_email_ao_editar_sem_alteracoes()
    {
        Mail::fake();

        $user = User::factory()->create();

        $tarefa = Tarefa::factory()->create([
            'descricao' => 'Tarefa Original',
            'situacao' => 'Pendente',
            'data_prevista' => now()->addDays(1),
            'data_encerramento' => now()->addDays(2),
        ]);

        $this->actingAs($user);

        $response = $this->put(route('tasks.update', $tarefa->id), [
            'descricao' => 'Tarefa Original',
            'situacao' => 'Pendente',
            'data_prevista' => $tarefa->data_prevista,
            'data_encerramento' => $tarefa->data_encerramento,
        ]);

        $response->assertRedirect();

        Mail::assertNotSent(TarefaEditadaMail::class);
    }
}
