@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Editar Desafio</h1>
            <a href="{{ route('desafios.index') }}" class="text-blue-500 hover:text-blue-700">
                Voltar para lista
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('desafios.update', $desafio) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="titulo" class="block text-gray-700 text-sm font-bold mb-2">Título</label>
                    <input type="text" name="titulo" id="titulo" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('titulo') border-red-500 @enderror"
                           value="{{ old('titulo', $desafio->titulo) }}" required>
                    @error('titulo')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="descricao" class="block text-gray-700 text-sm font-bold mb-2">Descrição</label>
                    <textarea name="descricao" id="descricao" rows="4"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('descricao') border-red-500 @enderror"
                            required>{{ old('descricao', $desafio->descricao) }}</textarea>
                    @error('descricao')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="data_limite" class="block text-gray-700 text-sm font-bold mb-2">Data Limite</label>
                    <input type="date" name="data_limite" id="data_limite"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('data_limite') border-red-500 @enderror"
                           value="{{ old('data_limite', $desafio->data_limite ? $desafio->data_limite->format('Y-m-d') : '') }}">
                    @error('data_limite')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Atualizar Desafio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 