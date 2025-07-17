@extends('layouts.app')

@section('title', $aula->titulo)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-light">
                        <i class="fas fa-play-circle"></i>
                        {{ $aula->titulo }}
                    </h4>
                    <a href="{{ route('escola-lideres.modulo', $aula->modulo) }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Voltar ao Módulo
                    </a>
                </div>
                <div class="card-body">
                    <!-- Conteúdo Principal (Desktop) -->
                    <div class="row d-none d-md-flex">
                        <div class="col-md-8">
                            <!-- Conteúdo da Aula -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Conteúdo</h5>
                                    <div class="mb-4">
                                        {!! $aula->conteudo !!}
                                    </div>
                        
                                    @if($aula->video_url)
                                        <div class="ratio ratio-16x9 mb-4">
                                            <iframe src="{{ $aula->video_url }}" 
                                                    allowfullscreen></iframe>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Avaliação (Desktop) -->
                            @if($matricula->aulasAssistidas->contains($aula->id))
                                <div class="card">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0 text-light">
                                            <i class="fas fa-star"></i>
                                            Avaliações
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        @if(!$aula->avaliacoes->where('user_id', auth()->id())->count())
                                            <form action="{{ route('escola-lideres.avaliar-aula', $aula) }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label class="form-label">Sua Avaliação</label>
                                                    <div class="rating">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <input type="radio" name="avaliacao" value="{{ $i }}" id="star{{ $i }}">
                                                            <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="comentario" class="form-label">Comentário (opcional)</label>
                                                    <textarea class="form-control" id="comentario" name="comentario" rows="3"></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fas fa-paper-plane"></i> Enviar Avaliação
                                                </button>
                                            </form>
                                        @endif

                                        @if($aula->avaliacoes->count() > 0)
                                            <hr>
                                            <h6 class="mb-3">Todas as Avaliações</h6>
                                            <div class="avaliacoes-list">
                                                @foreach($aula->avaliacoes->sortByDesc('created_at') as $avaliacao)
                                                    <div class="avaliacao-item mb-3 p-3 border rounded">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <div>
                                                                <strong>{{ $avaliacao->user->name }}</strong>
                                                                <div class="rating-display">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                        <i class="fas fa-star {{ $i <= $avaliacao->avaliacao ? 'text-warning' : 'text-muted' }}"></i>
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                            <small class="text-muted">
                                                                {{ $avaliacao->created_at->format('d/m/Y H:i') }}
                                                            </small>
                                                        </div>
                                                        @if($avaliacao->comentario)
                                                            <p class="mb-0">{{ $avaliacao->comentario }}</p>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="alert alert-info mt-3">
                                                <i class="fas fa-info-circle"></i> Nenhuma avaliação registrada ainda.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <!-- Progresso (Desktop) -->
                            <div class="card mb-4">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-chart-line"></i>
                                        Progresso da Aula
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @if($matricula->aulasAssistidas->contains($aula->id))
                                        <div class="alert alert-success">
                                            <i class="fas fa-check-circle"></i>
                                            Aula concluída!
                                        </div>
                                    @else
                                        <form action="{{ route('escola-lideres.concluir-aula', $aula) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-block">
                                                <i class="fas fa-check"></i> Marcar como Concluída
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <!-- Material de Apoio (Desktop) -->
                            @if($aula->material_url)
                                <div class="card">
                                    <div class="card-header bg-warning text-dark">
                                        <h5 class="mb-0">
                                            <i class="fas fa-file-alt"></i>
                                            Material de Apoio
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <a href="{{ Storage::url($aula->material_url) }}" 
                                           class="btn btn-warning btn-block" 
                                           target="_blank">
                                            <i class="fas fa-download"></i> Baixar Material
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Conteúdo Responsivo (Mobile) -->
                    <div class="d-md-none">
                        <!-- Vídeo (Mobile) -->
                        @if($aula->video_url)
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-play"></i>
                                        Vídeo da Aula
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="{{ $aula->video_url }}" 
                                                allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Progresso (Mobile) -->
                        <div class="card mb-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-chart-line"></i>
                                    Progresso da Aula
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($matricula->aulasAssistidas->contains($aula->id))
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle"></i>
                                        Aula concluída!
                                    </div>
                                @else
                                    <form action="{{ route('escola-lideres.concluir-aula', $aula) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-check"></i> Marcar como Concluída
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <!-- Material de Apoio (Mobile) -->
                        @if($aula->material_url)
                            <div class="card mb-4">
                                <div class="card-header bg-warning text-dark">
                                    <h5 class="mb-0">
                                        <i class="fas fa-file-alt"></i>
                                        Material de Apoio
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <a href="{{ asset('storage/' . $aula->material_url) }}" 
                                       class="btn btn-warning btn-block" 
                                       target="_blank">
                                        <i class="fas fa-download"></i> Baixar Material
                                    </a>
                                </div>
                            </div>
                        @endif

                        <!-- Conteúdo (Mobile) -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-book"></i>
                                    Conteúdo
                                </h5>
                            </div>
                            <div class="card-body">
                                {!! $aula->conteudo !!}
                            </div>
                        </div>

                        <!-- Avaliação (Mobile) -->
                        @if($matricula->aulasAssistidas->contains($aula->id))
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0 text-light">
                                        <i class="fas fa-star"></i>
                                        Avaliações
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @if(!$aula->avaliacoes->where('user_id', auth()->id())->count())
                                        <form action="{{ route('escola-lideres.avaliar-aula', $aula) }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label">Sua Avaliação</label>
                                                <div class="rating">
                                                    @for($i = 5; $i >= 1; $i--)
                                                        <input type="radio" name="avaliacao" value="{{ $i }}" id="star{{ $i }}">
                                                        <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="comentario" class="form-label">Comentário (opcional)</label>
                                                <textarea class="form-control" id="comentario" name="comentario" rows="3"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-paper-plane"></i> Enviar Avaliação
                                            </button>
                                        </form>
                                    @endif

                                    @if($aula->avaliacoes->count() > 0)
                                        <hr>
                                        <h6 class="mb-3">Todas as Avaliações</h6>
                                        <div class="avaliacoes-list">
                                            @foreach($aula->avaliacoes->sortByDesc('created_at') as $avaliacao)
                                                <div class="avaliacao-item mb-3 p-3 border rounded">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <div>
                                                            <strong>{{ $avaliacao->user->name }}</strong>
                                                            <div class="rating-display">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <i class="fas fa-star {{ $i <= $avaliacao->avaliacao ? 'text-warning' : 'text-muted' }}"></i>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                        <small class="text-muted">
                                                            {{ $avaliacao->created_at->format('d/m/Y H:i') }}
                                                        </small>
                                                    </div>
                                                    @if($avaliacao->comentario)
                                                        <p class="mb-0">{{ $avaliacao->comentario }}</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="alert alert-info mt-3">
                                            <i class="fas fa-info-circle"></i> Nenhuma avaliação registrada ainda.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }

    .rating input {
        display: none;
    }

    .rating label {
        cursor: pointer;
        font-size: 1.5rem;
        color: #ddd;
        padding: 0 0.1em;
    }

    .rating input:checked ~ label,
    .rating label:hover,
    .rating label:hover ~ label {
        color: #ffd700;
    }

    .rating-display {
        font-size: 1rem;
    }

    .rating-display .fas {
        margin-right: 0.1em;
    }

    .avaliacao-item {
        background-color: #f8f9fa;
    }

    .avaliacao-item:hover {
        background-color: #f1f3f5;
    }
</style>
@endpush
@endsection 