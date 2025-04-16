@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Relatório da Jornada</h1>
        <a href="{{ route('jornada-aspirante.index') }}" 
           class="text-blue-500 hover:text-blue-600">
            Voltar para a Jornada
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-blue-50 rounded-lg p-4">
                <h3 class="text-lg font-medium text-gray-800 mb-2">Total de Etapas</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $totalEtapas }}</p>
            </div>
            
            <div class="bg-green-50 rounded-lg p-4">
                <h3 class="text-lg font-medium text-gray-800 mb-2">Etapas Concluídas</h3>
                <p class="text-3xl font-bold text-green-600">{{ $etapasConcluidas }}</p>
            </div>
            
            <div class="bg-purple-50 rounded-lg p-4">
                <h3 class="text-lg font-medium text-gray-800 mb-2">Progresso Geral</h3>
                <p class="text-3xl font-bold text-purple-600">{{ number_format($progressoGeral, 1) }}%</p>
            </div>
        </div>

        <div class="space-y-4">
            @foreach($etapas as $etapa)
                <div class="border border-gray-200 rounded-lg p-4 {{ $etapa->pivot->concluido ? 'bg-green-50' : '' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-800">{{ $etapa->titulo }}</h3>
                            <p class="text-gray-600 mt-1">{{ $etapa->descricao }}</p>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            @if($etapa->pivot->concluido)
                                <span class="text-green-600 font-medium">
                                    Concluído em {{ $etapa->pivot->data_conclusao->format('d/m/Y') }}
                                </span>
                            @else
                                <div class="w-32">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">Progresso</span>
                                        <span class="text-sm font-medium text-gray-700">{{ $etapa->pivot->progresso }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $etapa->pivot->progresso }}%"></div>
                                    </div>
                                </div>
                            @endif
                            
                            <a href="{{ route('jornada-aspirante.show', $etapa) }}" 
                               class="text-blue-500 hover:text-blue-600">
                                Detalhes
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection 