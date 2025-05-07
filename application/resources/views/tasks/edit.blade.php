<x-app-layout>
    <x-slot name="header">
        <h2 class=font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Tarefa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-xl sm:rounded-lg">
                <form method="POST" action="{{ route('tasks.update', $tarefa->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="space-y-6">
                        <!-- Nome -->
                        <div>
                            <label for="descricao" class="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" name="descricao" id="descricao" value="{{ old('descricao', $tarefa->descricao) }}" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('descricao') border-red-500 @enderror">
                            @error('descricao')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Data Prevista -->
                        <div>
                            <label for="data_prevista" class="block text-sm font-medium text-gray-700">Data Prevista</label>
                            <input type="datetime-local" name="data_prevista" id="data_prevista"
                                   value="{{ old('data_prevista', \Carbon\Carbon::parse($tarefa->data_prevista)->format('Y-m-d\TH:i')) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('data_prevista') border-red-500 @enderror">
                            @error('data_prevista')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Data Encerramento -->
                        <div>
                            <label for="data_encerramento" class="block text-sm font-medium text-gray-700">Data Encerramento</label>
                            <input type="datetime-local" name="data_encerramento" id="data_encerramento"
                                   value="{{ old('data_encerramento', $tarefa->data_encerramento ? \Carbon\Carbon::parse($tarefa->data_encerramento)->format('Y-m-d\TH:i') : '') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('data_encerramento') border-red-500 @enderror">
                            @error('data_encerramento')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Situação -->
                        <div>
                            <label for="situacao" class="block text-sm font-medium text-gray-700">Situação</label>
                            <select name="situacao" id="situacao" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('situacao') border-red-500 @enderror">
                                <option value="Pendente" {{ old('situacao', $tarefa->situacao) === 'Pendente' ? 'selected' : '' }}>Pendente</option>
                                <option value="Em Andamento" {{ old('situacao', $tarefa->situacao) === 'Em Andamento' ? 'selected' : '' }}>Em Andamento</option>
                                <option value="Concluída" {{ old('situacao', $tarefa->situacao) === 'Concluída' ? 'selected' : '' }}>Concluída</option>
                            </select>
                            @error('situacao')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Botão de Enviar -->
                        <div class="flex justify-end">
                            <button type="submit" style="background-color: #4F46E5; color: white; padding: 10px 20px; border-radius: 5px;">
                                Salvar Alterações
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
