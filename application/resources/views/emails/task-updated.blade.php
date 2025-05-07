<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Tarefa Atualizada</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            color: #000000;
            padding: 40px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            padding: 32px;
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 24px;
        }
        .details {
            background-color: #f3f4f6;
            padding: 16px;
            border-radius: 6px;
            margin-bottom: 24px;
        }
        .details p {
            margin: 6px 0;
        }
        .label {
            font-weight: bold;
            color: #111827;
        }
        .button {
            display: inline-block;
            background-color: #3b82f6;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 6px;
            font-weight: 600;
        }
        .footer {
            margin-top: 32px;
            font-size: 14px;
            color: #6b7280;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Tarefa Atualizada</div>

        <p>Olá, <strong>{{ $user->name }}</strong></p>

        <p>A seguinte tarefa foi <strong>atualizada</strong> com sucesso:</p>

        <div class="details">
            <p><span class="label">Descrição:</span> {{ $tarefa->descricao }}</p>
            <p><span class="label">Situação:</span> {{ $tarefa->situacao }}</p>
            <p><span class="label">Data Prevista:</span> {{ $tarefa->data_prevista }}</p>
            <p><span class="label">Encerramento:</span> {{ $tarefa->data_encerramento }}</p>
        </div>

    </div>
</body>
</html>
