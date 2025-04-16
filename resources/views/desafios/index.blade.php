@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Desafios</h1>
        <a href="{{ route('desafios.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Novo Desafio
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg">
        @if($desafios->isEmpty())
            <div class="p-6 text-center text-gray-500">
                Nenhum desafio encontrado.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descrição</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($desafios as $desafio)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $desafio->titulo }}</td>
                                <td class="px-6 py-4">{{ Str::limit($desafio->descricao, 100) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $desafio->status === 'concluído' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($desafio->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('desafios.show', $desafio) }}" class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                                    <a href="{{ route('desafios.edit', $desafio) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                                    @if($desafio->status !== 'concluído')
                                        <form action="{{ route('desafios.concluir', $desafio) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900">Concluir</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4">
                {{ $desafios->links() }}
            </div>
        @endif
    </div>
</div>
@endsection 