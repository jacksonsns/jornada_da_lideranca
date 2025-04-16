<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes do Evento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium">{{ $evento->titulo }}</h3>
                            <p class="text-sm text-gray-500">{{ $evento->tipo }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Descrição</h4>
                            <p class="mt-1">{{ $evento->descricao }}</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Data e Hora de Início</h4>
                                <p class="mt-1">{{ $evento->data_inicio->format('d/m/Y H:i') }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Data e Hora de Término</h4>
                                <p class="mt-1">{{ $evento->data_fim->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Local</h4>
                            <p class="mt-1">{{ $evento->local ?? 'Não especificado' }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Organizador</h4>
                            <p class="mt-1">{{ $evento->user->name }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Participantes</h4>
                            <div class="mt-2 space-y-2">
                                @foreach($evento->participantes as $participante)
                                    <div class="flex items-center justify-between">
                                        <span>{{ $participante->name }}</span>
                                        <span class="text-sm {{ $participante->pivot->confirmado ? 'text-green-600' : 'text-gray-500' }}">
                                            {{ $participante->pivot->confirmado ? 'Confirmado' : 'Pendente' }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            @if($evento->user_id === auth()->id())
                                <a href="{{ route('agenda.edit', $evento) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                <form method="POST" action="{{ route('agenda.destroy', $evento) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                </form>
                            @else
                                @if(!$evento->participantes->find(auth()->id())->pivot->confirmado)
                                    <form method="POST" action="{{ route('agenda.confirmar-presenca', $evento) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900">Confirmar Presença</button>
                                    </form>
                                @endif
                            @endif
                            <a href="{{ route('agenda.index') }}" class="text-gray-600 hover:text-gray-900">Voltar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 