@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Editar Sonho</h1>
            <a href="{{ route('quadro-dos-sonhos.index') }}" class="text-blue-500 hover:text-blue-700">
                Voltar para o quadro
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('quadro-dos-sonhos.update', $sonho) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="titulo" class="block text-gray-700 text-sm font-bold mb-2">Título do Sonho</label>
                    <input type="text" name="titulo" id="titulo" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('titulo') border-red-500 @enderror"
                           value="{{ old('titulo', $sonho->titulo) }}" required>
                    @error('titulo')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="descricao" class="block text-gray-700 text-sm font-bold mb-2">Descrição</label>
                    <textarea name="descricao" id="descricao" rows="4"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('descricao') border-red-500 @enderror"
                            required>{{ old('descricao', $sonho->descricao) }}</textarea>
                    @error('descricao')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="categoria" class="block text-gray-700 text-sm font-bold mb-2">Categoria</label>
                    <select name="categoria" id="categoria"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('categoria') border-red-500 @enderror"
                            required>
                        <option value="">Selecione uma categoria</option>
                        <option value="pessoal" {{ old('categoria', $sonho->categoria) === 'pessoal' ? 'selected' : '' }}>Pessoal</option>
                        <option value="profissional" {{ old('categoria', $sonho->categoria) === 'profissional' ? 'selected' : '' }}>Profissional</option>
                        <option value="financeiro" {{ old('categoria', $sonho->categoria) === 'financeiro' ? 'selected' : '' }}>Financeiro</option>
                        <option value="saude" {{ old('categoria', $sonho->categoria) === 'saude' ? 'selected' : '' }}>Saúde</option>
                        <option value="relacionamentos" {{ old('categoria', $sonho->categoria) === 'relacionamentos' ? 'selected' : '' }}>Relacionamentos</option>
                        <option value="outros" {{ old('categoria', $sonho->categoria) === 'outros' ? 'selected' : '' }}>Outros</option>
                    </select>
                    @error('categoria')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="data_realizacao" class="block text-gray-700 text-sm font-bold mb-2">Data Prevista para Realização</label>
                    <input type="date" name="data_realizacao" id="data_realizacao"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('data_realizacao') border-red-500 @enderror"
                           value="{{ old('data_realizacao', $sonho->data_realizacao ? $sonho->data_realizacao->format('Y-m-d') : '') }}">
                    @error('data_realizacao')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <select name="status" id="status"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('status') border-red-500 @enderror"
                            required>
                        <option value="pendente" {{ old('status', $sonho->status) === 'pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="em_andamento" {{ old('status', $sonho->status) === 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                        <option value="realizado" {{ old('status', $sonho->status) === 'realizado' ? 'selected' : '' }}>Realizado</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="imagem" class="block text-gray-700 text-sm font-bold mb-2">Imagem do Sonho</label>
                    @if($sonho->imagem)
                        <div class="mb-2">
                            <img src="{{ Storage::url($sonho->imagem) }}" alt="{{ $sonho->titulo }}" class="w-32 h-32 object-cover rounded">
                        </div>
                    @endif
                    <input type="file" name="imagem" id="imagem" accept="image/*"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('imagem') border-red-500 @enderror">
                    <p class="text-gray-500 text-xs mt-1">Opcional: Altere a imagem que representa seu sonho</p>
                    @error('imagem')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end space-x-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Atualizar Sonho
                    </button>
                    
                    <form action="{{ route('quadro-dos-sonhos.destroy', $sonho) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                onclick="return confirm('Tem certeza que deseja excluir este sonho?')">
                            Excluir
                        </button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 