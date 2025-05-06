<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarefa;

class TarefaController extends Controller
{
    public function index(Request $request)
    {
        $tarefas = Tarefa::query()
        ->when($request->situacao, function($query) use ($request) {
            return $query->where('situacao', $request->situacao);
        })
        ->when($request->data_inicio, function($query) use ($request) {
            return $query->where('data_criacao', '>=', $request->data_inicio);
        })
        ->when($request->data_fim, function($query) use ($request) {
            return $query->where('data_criacao', '<=', $request->data_fim);
        })->paginate(5);;
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

        Tarefa::create([
            'descricao' => $request->descricao,
            'data_criacao' => date('Y-m-d H:i:s'),
            'data_prevista' => $request->data_prevista,
            'data_encerramento' => $request->data_encerramento,
            'situacao' => $request->situacao,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tarefa criada com sucesso!');
    }
}
