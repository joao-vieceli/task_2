<?php

namespace App\Mail;

use App\Models\Tarefa;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TarefaCriadaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tarefa;
    public $user;

    public function __construct(Tarefa $tarefa, User $user)
    {
        $this->tarefa = $tarefa;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Nova Tarefa Criada')
                    ->markdown('emails.task-created')
                    ->with([
                        'tarefa' => $this->tarefa,
                        'user' => $this->user,
                    ]);
    }
}
