@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Informações Principais -->
        <div class="col-lg-4">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <div class="position-relative mb-4">
                        <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" 
                             class="rounded-circle img-thumbnail" 
                             style="width: 150px; height: 150px;"
                             alt="Foto de Perfil">
                        <button class="btn btn-sm btn-primary position-absolute bottom-0 end-0" 
                                style="border-radius: 50%;"
                                title="Alterar foto">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                    <h4 class="mb-0">{{ auth()->user()->name }}</h4>
                    <p class="text-muted">{{ '@' . auth()->user()->username }}</p>
                    <div class="d-flex justify-content-center gap-3 mb-3">
                        <div class="text-center">
                            <h5 class="mb-0">{{ auth()->user()->desafios()->count() }}</h5>
                            <small class="text-muted">Desafios</small>
                        </div>
                        <div class="text-center">
                            <h5 class="mb-0">{{ auth()->user()->desafios()->where('concluido', true)->count() }}</h5>
                            <small class="text-muted">Concluídos</small>
                        </div>
                        <div class="text-center">
                            <h5 class="mb-0">{{ auth()->user()->pontos ?? 0 }}</h5>
                            <small class="text-muted">Pontos</small>
                        </div>
                    </div>
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editarPerfilModal">
                        <i class="fas fa-edit"></i> Editar Perfil
                    </button>
                </div>
            </div>

            <!-- Conquistas Recentes -->
            <div class="card shadow-lg mt-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">🏆 Conquistas Recentes</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @forelse(auth()->user()->conquistas()->latest()->take(3)->get() as $conquista)
                            <div class="list-group-item d-flex align-items-center">
                                <span class="badge bg-warning me-2">
                                    <i class="fas fa-star"></i>
                                </span>
                                <div>
                                    <h6 class="mb-0">{{ $conquista->titulo }}</h6>
                                    <small class="text-muted">{{ $conquista->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center mb-0">Nenhuma conquista ainda</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Atividades e Estatísticas -->
        <div class="col-lg-8">
            <!-- Progresso Geral -->
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">📊 Progresso Geral</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-primary p-2">
                                        <i class="fas fa-tasks fa-2x"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Total de Desafios</h6>
                                    <h4 class="mb-0">{{ auth()->user()->desafios()->count() }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-success p-2">
                                        <i class="fas fa-check-circle fa-2x"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Concluídos</h6>
                                    <h4 class="mb-0">{{ auth()->user()->desafios()->where('concluido', true)->count() }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-warning p-2">
                                        <i class="fas fa-star fa-2x"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Pontuação</h6>
                                    <h4 class="mb-0">{{ auth()->user()->pontos ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Histórico de Atividades -->
            <div class="card shadow-lg">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">📝 Histórico de Atividades</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @forelse(auth()->user()->desafios()->latest()->take(5)->get() as $desafio)
                            <div class="timeline-item">
                                <div class="timeline-marker {{ $desafio->concluido ? 'bg-success' : 'bg-warning' }}"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-0">{{ $desafio->titulo }}</h6>
                                    <p class="text-muted mb-0">{{ $desafio->descricao }}</p>
                                    <small class="text-muted">
                                        {{ $desafio->pivot->concluido_em ? 'Concluído ' . \Carbon\Carbon::parse($desafio->pivot->concluido_em)->diffForHumans() : 'Em andamento' }}
                                    </small>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center mb-0">Nenhuma atividade registrada</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Edição de Perfil -->
<div class="modal fade" id="editarPerfilModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('perfil.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nova Senha</label>
                        <input type="password" class="form-control" name="password">
                        <small class="text-muted">Deixe em branco para manter a senha atual</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .timeline {
        position: relative;
        padding: 1rem 0;
    }

    .timeline-item {
        position: relative;
        padding-left: 2rem;
        margin-bottom: 1.5rem;
    }

    .timeline-marker {
        position: absolute;
        left: 0;
        top: 0;
        width: 15px;
        height: 15px;
        border-radius: 50%;
    }

    .timeline-content {
        position: relative;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e9ecef;
    }

    .timeline-item:last-child .timeline-content {
        border-bottom: none;
        padding-bottom: 0;
    }
</style>
@endpush
@endsection 