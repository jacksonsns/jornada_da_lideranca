<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Evento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('agenda.update', $evento) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="titulo" :value="__('Título')" />
                            <x-text-input id="titulo" name="titulo" type="text" class="mt-1 block w-full" :value="old('titulo', $evento->titulo)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('titulo')" />
                        </div>

                        <div>
                            <x-input-label for="descricao" :value="__('Descrição')" />
                            <textarea id="descricao" name="descricao" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('descricao', $evento->descricao) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('descricao')" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="data_inicio" :value="__('Data e Hora de Início')" />
                                <x-text-input id="data_inicio" name="data_inicio" type="datetime-local" class="mt-1 block w-full" :value="old('data_inicio', $evento->data_inicio->format('Y-m-d\TH:i'))" required />
                                <x-input-error class="mt-2" :messages="$errors->get('data_inicio')" />
                            </div>

                            <div>
                                <x-input-label for="data_fim" :value="__('Data e Hora de Término')" />
                                <x-text-input id="data_fim" name="data_fim" type="datetime-local" class="mt-1 block w-full" :value="old('data_fim', $evento->data_fim->format('Y-m-d\TH:i'))" required />
                                <x-input-error class="mt-2" :messages="$errors->get('data_fim')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="local" :value="__('Local')" />
                            <x-text-input id="local" name="local" type="text" class="mt-1 block w-full" :value="old('local', $evento->local)" />
                            <x-input-error class="mt-2" :messages="$errors->get('local')" />
                        </div>

                        <div>
                            <x-input-label for="tipo" :value="__('Tipo de Evento')" />
                            <select id="tipo" name="tipo" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="reuniao" {{ old('tipo', $evento->tipo) == 'reuniao' ? 'selected' : '' }}>Reunião</option>
                                <option value="capacitacao" {{ old('tipo', $evento->tipo) == 'capacitacao' ? 'selected' : '' }}>Capacitação</option>
                                <option value="mentoria" {{ old('tipo', $evento->tipo) == 'mentoria' ? 'selected' : '' }}>Mentoria</option>
                                <option value="projeto" {{ old('tipo', $evento->tipo) == 'projeto' ? 'selected' : '' }}>Projeto</option>
                                <option value="outro" {{ old('tipo', $evento->tipo) == 'outro' ? 'selected' : '' }}>Outro</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('tipo')" />
                        </div>

                        <div>
                            <x-input-label for="participantes" :value="__('Participantes')" />
                            <select id="participantes" name="participantes[]" multiple class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                @foreach(\App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}" {{ in_array($user->id, old('participantes', $evento->participantes->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('participantes')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Atualizar Evento') }}</x-primary-button>
                            <a href="{{ route('agenda.index') }}" class="text-gray-600 hover:text-gray-900">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 