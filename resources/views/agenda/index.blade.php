<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agenda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Agenda Compartilhada</h3>
                        <a href="{{ route('agenda.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Novo Evento
                        </a>
                    </div>

                    <div class="mb-6">
                        <iframe 
                            src="https://calendar.google.com/calendar/embed?src={{ config('services.google.calendar_id') }}&ctz=America/Sao_Paulo" 
                            style="border: 0" 
                            width="100%" 
                            height="600" 
                            frameborder="0" 
                            scrolling="no">
                        </iframe>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h4 class="text-lg font-medium mb-4">Meus Eventos</h4>
                            @if($eventos->count() > 0)
                                <div class="space-y-4">
                                    @foreach($eventos as $evento)
                                        <div class="border-b pb-4">
                                            <h5 class="font-medium">{{ $evento->titulo }}</h5>
                                            <p class="text-sm text-gray-600">
                                                {{ \Carbon\Carbon::parse($evento->data_inicio)->format('d/m/Y H:i') }} - 
                                                {{ \Carbon\Carbon::parse($evento->data_fim)->format('d/m/Y H:i') }}
                                            </p>
                                            <p class="text-sm text-gray-600">{{ $evento->local }}</p>
                                            <div class="mt-2">
                                                <a href="{{ route('agenda.show', $evento) }}" class="text-blue-500 hover:text-blue-700 text-sm">Ver detalhes</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">Nenhum evento encontrado.</p>
                            @endif
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h4 class="text-lg font-medium mb-4">Eventos que Participo</h4>
                            @if($eventosParticipantes->count() > 0)
                                <div class="space-y-4">
                                    @foreach($eventosParticipantes as $evento)
                                        <div class="border-b pb-4">
                                            <h5 class="font-medium">{{ $evento->titulo }}</h5>
                                            <p class="text-sm text-gray-600">
                                                {{ \Carbon\Carbon::parse($evento->data_inicio)->format('d/m/Y H:i') }} - 
                                                {{ \Carbon\Carbon::parse($evento->data_fim)->format('d/m/Y H:i') }}
                                            </p>
                                            <p class="text-sm text-gray-600">{{ $evento->local }}</p>
                                            <div class="mt-2">
                                                <a href="{{ route('agenda.show', $evento) }}" class="text-blue-500 hover:text-blue-700 text-sm">Ver detalhes</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">Nenhum evento encontrado.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 