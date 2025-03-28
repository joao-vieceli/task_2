<!-- resources/views/usuarios/index.blade.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tarefas</title>
</head>
<body>
    <h1>Lista de Tarefas</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Data Criação</th>
                <th>Data Prevista</th>
                <th>Data Encerramento</th>
                <th>Situacao</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tarefas as $tarefa)
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
