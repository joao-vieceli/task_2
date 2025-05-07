<?php

namespace App\Http\Controllers;

use App\Mail\ContatoMail;
use App\Mail\TarefaCriadaMail;
use App\Mail\TarefaEditadaMail;
use Illuminate\Http\Request;
use App\Models\Tarefa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class TarefaController extends Controller
{
    public function index(Request $request)
    {
        $tarefas = Tarefa::query()
        ->when($request->descricao, function ($query) use ($request) {
            return $query->where('descricao', 'like', '%' . $request->descricao . '%');
        })
        ->when($request->situacao, function($query) use ($request) {
            return $query->where('situacao', $request->situacao);
        })
        ->when($request->data_inicio, function($query) use ($request) {
            return $query->where('data_criacao', '>=', $request->data_inicio);
        })
        ->when($request->data_fim, function($query) use ($request) {
            return $query->where('data_criacao', '<=', $request->data_fim);
        })->paginate(5);

        return view('tasks.list', compact('tarefas'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'data_prevista' => 'nullable|date',
            'data_encerramento' => 'nullable|date',
            'situacao' => 'required|in:Pendente,Em Andamento,Concluída',
        ]);

        $tarefa = Tarefa::create([
            'descricao' => $request->descricao,
            'data_criacao' => date('Y-m-d H:i:s'),
            'data_prevista' => $request->data_prevista,
            'data_encerramento' => $request->data_encerramento,
            'situacao' => $request->situacao,
        ]);

        //Mail::to(auth()->user()->email)->send(new TarefaCriadaMail($tarefa, auth()->user()));
        Mail::to('joao.vieceli@universo.univates.br')->send(new TarefaCriadaMail($tarefa, auth()->user()));
        //Mail::to(auth()->user()->email)->queue(new TarefaCriadaMail($tarefa, auth()->user()));

        return redirect()->route('tasks.index')->with('success', 'Tarefa criada com sucesso!');
    }

    public function edit($id){
        $tarefa = Tarefa::findOrFail($id);
        return view('tasks.edit', compact('tarefa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'data_prevista' => 'nullable|date',
            'data_encerramento' => 'nullable|date',
            'situacao' => 'required|in:Pendente,Em Andamento,Concluída',
        ]);

        $tarefa = Tarefa::findOrFail($id);
        $tarefa->update([
            'descricao' => $request->descricao,
            'data_prevista' => $request->data_prevista,
            'data_encerramento' => $request->data_encerramento,
            'situacao' => $request->situacao,
        ]);

        Mail::to('joao.vieceli@universo.univates.br')->send(new TarefaEditadaMail($tarefa, auth()->user()));

        return redirect()->route('tasks.index')->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->delete();

        return redirect()->route('tasks.index')->with('success', 'Tarefa excluída com sucesso!');
    }

    public function exportPdf()
    {
        $tarefas = Tarefa::all();

        $pdf = Pdf::loadView('tasks.pdf', compact('tarefas'));

        return $pdf->download('lista_de_tarefas.pdf');
    }

}
