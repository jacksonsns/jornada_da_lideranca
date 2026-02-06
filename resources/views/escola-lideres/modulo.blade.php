@extends('layouts.app')

@section('title', $modulo->titulo)

@section('content')
<style>
    .escola-modulo-page-wrapper {
        padding: 1.5rem 1.5rem 1rem;
    }

    .escola-shell-card {
        border-radius: 26px;
        border: none;
        background: radial-gradient(circle at 0 0, rgba(255,255,255,0.96), rgba(233,239,255,0.98));
        box-shadow: 0 22px 55px rgba(0,0,0,0.65);
        overflow: hidden;
    }

    .escola-shell-card .card-header {
        border: none;
        border-radius: 26px 26px 0 0 !important;
        background: linear-gradient(135deg,#1b7aff,#33b3ff);
        box-shadow: 0 10px 25px rgba(15,35,95,0.45);
    }

    .escola-shell-card.secondary-header .card-header {
        background: linear-gradient(135deg,#1bbf7f,#2fd58e);
    }

    .escola-aulas-card {
        border-radius: 18px;
        border: none;
        background: linear-gradient(145deg, rgba(246,248,255,0.98), rgba(228,237,255,0.98));
        box-shadow: 0 18px 34px rgba(15,23,42,0.4);
    }

    .escola-aulas-card .card-header {
        border-radius: 18px 18px 0 0 !important;
    }

    .escola-progresso-card .progress {
        background-color: rgba(15,23,42,0.18);
        border-radius: 999px;
        overflow: hidden;
    }

    .escola-progresso-card .progress-bar {
        border-radius: 999px;
        box-shadow: 0 10px 25px rgba(34,197,94,0.55);
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .escola-modulo-page-wrapper {
            padding: 1rem 1rem 0.75rem;
        }
    }
</style>

<div class="container-fluid escola-modulo-page-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4 escola-shell-card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-light">
                        <i class="fas fa-book"></i>
                        {{ $modulo->titulo }}
                    </h4>
                    <a href="{{ route('escola-lideres.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
                <div class="card-body">
                    <p class="lead mb-3">{{ $modulo->descricao }}</p>
                    
                    @if(!$matricula)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Você ainda não está matriculado neste módulo.
                            <form action="{{ route('escola-lideres.matricular', $modulo) }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-user-plus"></i> Matricular-se
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-8">
                                <!-- Lista de Aulas -->
                                <div class="card escola-aulas-card">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0 text-light">
                                            <i class="fas fa-list"></i>
                                            Aulas
                                        </h5>
                                    </div>
                                    <div class="list-group list-group-flush">
                                        @foreach($aulas as $aula)
                                            <div class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="mb-1">{{ $aula->titulo }}</h6>
                                                        <small class="text-muted">
                                                            <i class="fas fa-clock"></i> {{ $aula->duracao_minutos }} minutos
                                                        </small>
                                                    </div>
                                                    <div>
                                                        @if($matricula->aulasAssistidas->contains($aula->id))
                                                            <span class="badge bg-success">
                                                                <i class="fas fa-check"></i> Concluída
                                                            </span>
                                                            <a href="{{ route('escola-lideres.aula', $aula) }}" 
                                                               class="btn btn-primary btn-sm">
                                                                <i class="fas fa-play"></i> Assistir
                                                            </a>
                                                        @else
                                                            <a href="{{ route('escola-lideres.aula', $aula) }}" 
                                                               class="btn btn-primary btn-sm">
                                                                <i class="fas fa-play"></i> Assistir
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <!-- Progresso -->
                                <div class="card mb-4 escola-progresso-card escola-shell-card secondary-header">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="mb-0 text-light">
                                            <i class="fas fa-chart-line"></i>
                                            Seu Progresso
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        @php
                                            $totalAulas = $aulas->count();
                                            $aulasAssistidas = $matricula->aulasAssistidas->count();
                                            $percentual = $totalAulas > 0 ? round(($aulasAssistidas / $totalAulas) * 100) : 0;

                                        @endphp
                                        <div class="progress mb-3">
                                            <div class="progress-bar bg-info" role="progressbar" 
                                                style="width: {{ $percentual }}%" 
                                                aria-valuenow="{{ $percentual }}" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                                {{ $percentual }}%
                                            </div>
                                        </div>
                                        <p class="mb-0">
                                            <small class="text-muted">
                                                {{ $aulasAssistidas }} de {{ $totalAulas }} aulas concluídas
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 