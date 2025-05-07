<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Nova Tarefa Criada</title>
</head>
<body style="font-family: 'Segoe UI', Roboto, sans-serif; background-color: #f5f7fa; margin: 0; padding: 0;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f5f7fa; padding: 30px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background-color: #4F46E5; padding: 20px 30px;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">📋 Nova Tarefa Criada</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px;">
                            <p style="font-size: 16px; color: #333;">Olá, <strong>{{ $user->name }}</strong>,</p>

                            <p style="font-size: 16px; color: #333;">
                                Uma nova tarefa foi adicionada ao sistema. Veja os detalhes abaixo:
                            </p>

                            <table width="100%" cellpadding="10" cellspacing="0" style="margin-top: 15px; font-size: 15px; color: #333;">
                                <tr>
                                    <td style="font-weight: bold;">Descrição:</td>
                                    <td>{{ $tarefa->descricao }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">Situação:</td>
                                    <td>{{ $tarefa->situacao }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">Data Prevista:</td>
                                    <td>{{ $tarefa->data_prevista }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">Data de Encerramento:</td>
                                    <td>
                                        {{ $tarefa->data_encerramento ? $tarefa->data_encerramento : 'Não definida' }}
                                    </td>
                                </tr>
                            </table>

                            <p style="margin-top: 20px; font-size: 15px;">
                                Você pode visualizar ou editar essa tarefa diretamente no sistema.
                            </p>

                            <div style="text-align: center; margin-top: 30px;">
                                <a href="{{ route('tasks.index') }}" style="display: inline-block; padding: 12px 24px; background-color: #4F46E5; color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: 500;">
                                    📁 Ver Tarefas
                                </a>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
