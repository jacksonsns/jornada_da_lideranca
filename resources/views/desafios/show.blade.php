@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Detalhes do Desafio</h1>
            <div class="space-x-2">
                <a href="{{ route('desafios.index') }}" class="text-blue-500 hover:text-blue-700">
                    Voltar para lista
                </a>
                <a href="{{ route('desafios.edit', $desafio) }}" class="text-indigo-500 hover:text-indigo-700">
                    Editar
                </a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $desafio->titulo }}</h2>
                <div class="flex items-center mb-4">
                    <span class="px-3 py-1 text-sm rounded-full {{ $desafio->status === 'concluído' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($desafio->status) }}
                    </span>
                    @if($desafio->data_limite)
                        <span class="ml-4 text-sm text-gray-600">
                            Data Limite: {{ $desafio->data_limite->format('d/m/Y') }}
                        </span>
                    @endif
                </div>
                <div class="prose max-w-none">
                    <p class="text-gray-700 whitespace-pre-line">{{ $desafio->descricao }}</p>
                </div>
            </div>

            @if($desafio->status !== 'concluído')
                <div class="mt-6 border-t pt-6">
                    <form action="{{ route('desafios.concluir', $desafio) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Marcar como Concluído
                        </button>
                    </form>
                </div>
            @endif

            @if($desafio->created_at)
                <div class="mt-6 text-sm text-gray-500">
                    Criado em: {{ $desafio->created_at->format('d/m/Y H:i') }}
                    @if($desafio->updated_at && $desafio->updated_at->ne($desafio->created_at))
                        <br>
                        Última atualização: {{ $desafio->updated_at->format('d/m/Y H:i') }}
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 