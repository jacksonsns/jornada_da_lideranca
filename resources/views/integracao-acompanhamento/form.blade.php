@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ isset($sessao) ? 'Editar' : 'Nova' }} Sessão de Integração/Acompanhamento</h5>
                </div>

                <div class="card-body">
                    <form action="{{ isset($sessao) ? route('integracao-acompanhamento.update', $sessao) : route('integracao-acompanhamento.store') }}" method="POST">
                        @csrf
                        @if(isset($sessao))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="mentor_id" class="form-label">Mentor</label>
                            <select name="mentor_id" id="mentor_id" class="form-select @error('mentor_id') is-invalid @enderror" required>
                                <option value="">Selecione um mentor</option>
                                @foreach($mentores as $mentor)
                                    <option value="{{ $mentor->id }}" {{ (old('mentor_id', $sessao->mentor_id ?? '') == $mentor->id) ? 'selected' : '' }}>
                                        {{ $mentor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mentor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo de Sessão</label>
                            <select name="tipo" id="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                                <option value="">Selecione o tipo</option>
                                <option value="mentoria" {{ (old('tipo', $sessao->tipo ?? '') == 'mentoria') ? 'selected' : '' }}>Mentoria</option>
                                <option value="feedback" {{ (old('tipo', $sessao->tipo ?? '') == 'feedback') ? 'selected' : '' }}>Feedback</option>
                                <option value="avaliacao" {{ (old('tipo', $sessao->tipo ?? '') == 'avaliacao') ? 'selected' : '' }}>Avaliação</option>
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="data_agendada" class="form-label">Data e Hora</label>
                            <input type="datetime-local" name="data_agendada" id="data_agendada" 
                                   class="form-control @error('data_agendada') is-invalid @enderror"
                                   value="{{ old('data_agendada', isset($sessao) ? $sessao->data_agendada->format('Y-m-d\TH:i') : '') }}"
                                   required>
                            @error('data_agendada')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="duracao_minutos" class="form-label">Duração (minutos)</label>
                            <input type="number" name="duracao_minutos" id="duracao_minutos" 
                                   class="form-control @error('duracao_minutos') is-invalid @enderror"
                                   value="{{ old('duracao_minutos', $sessao->duracao_minutos ?? '') }}"
                                   min="15" max="240" step="15" required>
                            @error('duracao_minutos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="observacoes" class="form-label">Observações</label>
                            <textarea name="observacoes" id="observacoes" 
                                      class="form-control @error('observacoes') is-invalid @enderror"
                                      rows="3">{{ old('observacoes', $sessao->observacoes ?? '') }}</textarea>
                            @error('observacoes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="metas_definidas" class="form-label">Metas Definidas</label>
                            <textarea name="metas_definidas" id="metas_definidas" 
                                      class="form-control @error('metas_definidas') is-invalid @enderror"
                                      rows="3">{{ old('metas_definidas', $sessao->metas_definidas ?? '') }}</textarea>
                            @error('metas_definidas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="proximos_passos" class="form-label">Próximos Passos</label>
                            <textarea name="proximos_passos" id="proximos_passos" 
                                      class="form-control @error('proximos_passos') is-invalid @enderror"
                                      rows="3">{{ old('proximos_passos', $sessao->proximos_passos ?? '') }}</textarea>
                            @error('proximos_passos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="">Selecione o status</option>
                                <option value="agendado" {{ (old('status', $sessao->status ?? '') == 'agendado') ? 'selected' : '' }}>Agendado</option>
                                <option value="realizado" {{ (old('status', $sessao->status ?? '') == 'realizado') ? 'selected' : '' }}>Realizado</option>
                                <option value="cancelado" {{ (old('status', $sessao->status ?? '') == 'cancelado') ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('integracao-acompanhamento.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ isset($sessao) ? 'Atualizar' : 'Salvar' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 