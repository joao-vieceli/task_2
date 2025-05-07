<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista de Tarefas</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Lista de Tarefas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Data Criação</th>
                <th>Data Prevista</th>
                <th>Data Encerramento</th>
                <th>Situação</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tarefas as $tarefa)
            <tr>
                <td>{{ $tarefa->id }}</td>
                <td>{{ $tarefa->descricao }}</td>
                <td>{{ $tarefa->data_criacao }}</td>
                <td>{{ $tarefa->data_prevista }}</td>
                <td>{{ $tarefa->data_encerramento }}</td>
                <td>{{ $tarefa->situacao }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
