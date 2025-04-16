@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Detalhes do Sonho</h1>
            <div class="space-x-2">
                <a href="{{ route('quadro-dos-sonhos.index') }}" class="text-blue-500 hover:text-blue-700">
                    Voltar para o quadro
                </a>
                <a href="{{ route('quadro-dos-sonhos.edit', $sonho) }}" class="text-indigo-500 hover:text-indigo-700">
                    Editar
                </a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            @if($sonho->imagem)
                <div class="w-full h-64 bg-gray-100">
                    <img src="{{ Storage::url($sonho->imagem) }}" alt="{{ $sonho->titulo }}" class="w-full h-full object-cover">
                </div>
            @endif

            <div class="p-6">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-2">{{ $sonho->titulo }}</h2>
                    <div class="flex items-center space-x-4 mb-4">
                        <span class="px-3 py-1 text-sm rounded-full {{ $sonho->status === 'realizado' ? 'bg-green-100 text-green-800' : ($sonho->status === 'em_andamento' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ ucfirst(str_replace('_', ' ', $sonho->status)) }}
                        </span>
                        <span class="text-sm text-gray-600">
                            Categoria: {{ ucfirst($sonho->categoria) }}
                        </span>
                    </div>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 whitespace-pre-line">{{ $sonho->descricao }}</p>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-600">Data Prevista</h3>
                            <p class="text-gray-800">
                                {{ $sonho->data_realizacao ? $sonho->data_realizacao->format('d/m/Y') : 'Não definida' }}
                            </p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-600">Criado em</h3>
                            <p class="text-gray-800">{{ $sonho->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                @if($sonho->status !== 'realizado')
                    <div class="mt-6 border-t pt-6">
                        <form action="{{ route('quadro-dos-sonhos.realizar', $sonho) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Marcar como Realizado
                            </button>
                        </form>
                    </div>
                @endif

                <div class="mt-6 border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Ações</h3>
                    <div class="flex space-x-4">
                        <a href="{{ route('quadro-dos-sonhos.edit', $sonho) }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Editar Sonho
                        </a>
                        <form action="{{ route('quadro-dos-sonhos.destroy', $sonho) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                    onclick="return confirm('Tem certeza que deseja excluir este sonho?')">
                                Excluir Sonho
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 