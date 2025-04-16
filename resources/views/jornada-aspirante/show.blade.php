@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">{{ $etapa->titulo }}</h1>
        <a href="{{ route('jornada-aspirante.index') }}" 
           class="text-blue-500 hover:text-blue-600">
            Voltar para a Jornada
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Descrição</h2>
            <p class="text-gray-600">{{ $etapa->descricao }}</p>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Progresso</h2>
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-700">Progresso Atual</span>
                <span class="text-sm font-medium text-gray-700">{{ $etapa->pivot->progresso }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $etapa->pivot->progresso }}%"></div>
            </div>
        </div>

        @if(!$etapa->pivot->concluido)
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4">Atualizar Progresso</h2>
                <form action="{{ route('jornada-aspirante.progresso', $etapa) }}" method="POST">
                    @csrf
                    <div class="flex items-center space-x-4">
                        <input type="range" 
                               name="progresso" 
                               min="0" 
                               max="100" 
                               value="{{ $etapa->pivot->progresso }}" 
                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                               oninput="this.nextElementSibling.value = this.value">
                        <output class="text-lg font-medium text-gray-700">{{ $etapa->pivot->progresso }}%</output>
                    </div>
                    <button type="submit" 
                            class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Salvar Progresso
                    </button>
                </form>
            </div>
        @else
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <p class="text-green-800">
                    <span class="font-medium">Concluído em:</span> 
                    {{ $etapa->pivot->data_conclusao->format('d/m/Y') }}
                </p>
            </div>
        @endif
    </div>

    @if($etapa->pivot->progresso == 100 && !$etapa->pivot->concluido)
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Concluir Etapa</h2>
            <p class="text-gray-600 mb-4">
                Você atingiu 100% do progresso nesta etapa. Clique no botão abaixo para marcá-la como concluída.
            </p>
            <form action="{{ route('jornada-aspirante.concluir', $etapa) }}" method="POST">
                @csrf
                <button type="submit" 
                        class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                    Concluir Etapa
                </button>
            </form>
        </div>
    @endif
</div>
@endsection 