@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Novo Sonho</h1>
            <a href="{{ route('quadro-dos-sonhos.index') }}" class="text-blue-500 hover:text-blue-700">
                Voltar para o quadro
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('quadro-dos-sonhos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="titulo" class="block text-gray-700 text-sm font-bold mb-2">Título do Sonho</label>
                    <input type="text" name="titulo" id="titulo" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('titulo') border-red-500 @enderror"
                           value="{{ old('titulo') }}" required>
                    @error('titulo')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="descricao" class="block text-gray-700 text-sm font-bold mb-2">Descrição</label>
                    <textarea name="descricao" id="descricao" rows="4"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('descricao') border-red-500 @enderror"
                            required>{{ old('descricao') }}</textarea>
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
                        <option value="pessoal" {{ old('categoria') === 'pessoal' ? 'selected' : '' }}>Pessoal</option>
                        <option value="profissional" {{ old('categoria') === 'profissional' ? 'selected' : '' }}>Profissional</option>
                        <option value="financeiro" {{ old('categoria') === 'financeiro' ? 'selected' : '' }}>Financeiro</option>
                        <option value="saude" {{ old('categoria') === 'saude' ? 'selected' : '' }}>Saúde</option>
                        <option value="relacionamentos" {{ old('categoria') === 'relacionamentos' ? 'selected' : '' }}>Relacionamentos</option>
                        <option value="outros" {{ old('categoria') === 'outros' ? 'selected' : '' }}>Outros</option>
                    </select>
                    @error('categoria')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="data_realizacao" class="block text-gray-700 text-sm font-bold mb-2">Data Prevista para Realização</label>
                    <input type="date" name="data_realizacao" id="data_realizacao"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('data_realizacao') border-red-500 @enderror"
                           value="{{ old('data_realizacao') }}">
                    @error('data_realizacao')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="imagem" class="block text-gray-700 text-sm font-bold mb-2">Imagem do Sonho</label>
                    <input type="file" name="imagem" id="imagem" accept="image/*"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('imagem') border-red-500 @enderror">
                    <p class="text-gray-500 text-xs mt-1">Opcional: Adicione uma imagem que represente seu sonho</p>
                    @error('imagem')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Adicionar Sonho
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 