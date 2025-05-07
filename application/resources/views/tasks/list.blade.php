<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white p-6 shadow-xl sm:rounded-lg">
                <form method="GET" action="{{ route('tasks.index') }}" class="flex flex-col sm:flex-row sm:items-end gap-2 mb-4">
                    <div>
                        <label for="situacao" class="block text-sm font-medium text-gray-700">Situação</label>
                        <select name="situacao" id="situacao" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Todas</option>
                            <option value="Pendente" {{ request('situacao') === 'Pendente' ? 'selected' : '' }}>Pendente</option>
                            <option value="Em Andamento" {{ request('situacao') === 'Em Andamento' ? 'selected' : '' }}>Em Andamento</option>
                            <option value="Concluída" {{ request('situacao') === 'Concluída' ? 'selected' : '' }}>Concluída</option>
                        </select>
                    </div>
                    <div>
                        <label for="data_inicio" class="block text-sm font-medium text-gray-700">Data Inicial</label>
                        <input type="date" name="data_inicio" id="data_inicio" value="{{ request('data_inicio') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="data_fim" class="block text-sm font-medium text-gray-700">Data Final</label>
                        <input type="date" name="data_fim" id="data_fim" value="{{ request('data_fim') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Filtrar
                        </button>
                    </div>
                </form>
             
                <a href="{{ route('tasks.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Criar Tarefa
                </a>
                <!-- Tabela -->
                <div class="overflow-x-auto py-12">
                    <table class="min-w-full divide-y divide-gray-200 mx-auto ">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descrição</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Criação</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Prevista</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Encerramento</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Situação</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($tarefas as $tarefa)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 relative">
                                        <div x-data="{ open: false }" class="relative">
                                            <button @click="open = !open" style="color: rgb(42 181 181);" class="hover:text-indigo-900 font-medium focus:outline-none">
                                                Ações ▾
                                            </button>
                                            <div x-show="open" @click.away="open = false"
                                                 class="absolute z-10 mt-2 w-32 bg-white border border-gray-200 rounded-md shadow-lg">
                                                <a href="{{ route('tasks.edit', $tarefa->id) }}"
                                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Editar</a>
                                    
                                                <form action="{{ route('tasks.destroy', $tarefa->id) }}" method="POST"
                                                      onsubmit="return confirm('Tem certeza que deseja excluir esta tarefa?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                                        Excluir
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $tarefa->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $tarefa->descricao }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $tarefa->data_criacao }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $tarefa->data_prevista }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $tarefa->data_encerramento }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium 
                                            {{ $tarefa->situacao === 'Concluída' ? 'bg-green-100 text-green-800' : ($tarefa->situacao === 'Em Andamento' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $tarefa->situacao }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Nenhuma tarefa encontrada.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $tarefas->links() }}
                </div>
                <a href="{{ route('tasks.exportPdf') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Gerar PDF
                </a>
            </div>

            
        </div>
    </div>
</x-app-layout>
