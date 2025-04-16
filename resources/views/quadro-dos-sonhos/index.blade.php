@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Quadro dos Sonhos</h1>
        <a href="{{ route('quadro-dos-sonhos.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Novo Sonho
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($sonhos as $sonho)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($sonho->imagem)
                    <img src="{{ Storage::url($sonho->imagem) }}" alt="{{ $sonho->titulo }}" class="w-full h-48 object-cover">
                @endif
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $sonho->titulo }}</h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($sonho->descricao, 150) }}</p>
                    
                    <div class="flex items-center justify-between">
                        <span class="px-3 py-1 text-sm rounded-full {{ $sonho->status === 'realizado' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($sonho->status) }}
                        </span>
                        <div class="flex space-x-2">
                            <a href="{{ route('quadro-dos-sonhos.show', $sonho) }}" class="text-blue-500 hover:text-blue-700">
                                Ver
                            </a>
                            <a href="{{ route('quadro-dos-sonhos.edit', $sonho) }}" class="text-indigo-500 hover:text-indigo-700">
                                Editar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <p class="text-gray-500">Nenhum sonho cadastrado ainda.</p>
                    <a href="{{ route('quadro-dos-sonhos.create') }}" class="inline-block mt-4 text-blue-500 hover:text-blue-700">
                        Comece adicionando seu primeiro sonho
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    @if($sonhos->isNotEmpty())
        <div class="mt-6">
            {{ $sonhos->links() }}
        </div>
    @endif
</div>
@endsection 