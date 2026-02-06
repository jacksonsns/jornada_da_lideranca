@extends('layouts.app')

@section('title', 'Escola de Líderes')

@section('content')
<style>
    .escola-page-wrapper {
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

    .escola-shell-card.info-header .card-header {
        background: linear-gradient(135deg,#0ea5e9,#22c1c3);
    }

    .escola-modulo-card {
        border-radius: 18px;
        border: none;
        background: linear-gradient(145deg, rgba(246,248,255,0.98), rgba(228,237,255,0.98));
        box-shadow: 0 18px 34px rgba(15,23,42,0.4);
    }

    .escola-modulo-card .card-title {
        font-weight: 700;
        color: #071327;
    }

    .escola-modulo-card .card-text {
        font-size: 0.9rem;
        color: #4b5563;
    }

    .escola-progress .progress {
        background-color: rgba(15,23,42,0.18);
        border-radius: 999px;
        overflow: hidden;
    }

    .escola-progress .progress-bar {
        border-radius: 999px;
        box-shadow: 0 10px 25px rgba(34,197,94,0.55);
        font-weight: 600;
    }

    .escola-progress-small .progress-bar {
        box-shadow: 0 8px 20px rgba(56,189,248,0.55);
    }

    @media (max-width: 768px) {
        .escola-page-wrapper {
            padding: 1rem 1rem 0.75rem;
        }
    }
</style>

<div class="container-fluid escola-page-wrapper">
    <div class="row mt-3">
        <div class="col-12">
            <div class="card shadow mb-4 escola-shell-card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0 text-light">
                        <i class="fas fa-graduation-cap"></i>
                        Escola de Líderes
                    </h4>
                </div>
                <div class="card-body">
                    <p class="lead">
                        Bem-vindo à Escola de Líderes! Aqui você encontrará módulos e cursos para desenvolver suas habilidades de liderança.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Módulos Disponíveis -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4 escola-shell-card secondary-header">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-book"></i>
                        Módulos Disponíveis
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($modulos as $modulo)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 escola-modulo-card escola-progress">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $modulo->titulo }}</h5>
                                        <p class="card-text">{{ $modulo->descricao }}</p>
                                        
                                        @php
                                            $matricula = $modulo->matriculas->first();
                                            $totalAulas = $modulo->aulas->count();
                                            $aulasAssistidas = $matricula?->aulasAssistidas->count() ?? 0;
                                            $percentual = $totalAulas > 0 ? round(($aulasAssistidas / $totalAulas) * 100) : 0;
                                        @endphp

                                        <div class="mb-3 escola-progress">
                                            <small class="text-muted">Progresso:</small>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" 
                                                     style="width: {{ $percentual }}%" 
                                                     aria-valuenow="{{ $percentual }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    {{ $percentual }}%
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="fas fa-clock"></i> {{ $modulo->duracao_minutos }} minutos
                                            </small>
                                            <a href="{{ route('escola-lideres.modulo', $modulo) }}" 
                                               class="btn btn-primary btn-sm">
                                                {{ $matricula ? 'Continuar' : 'Iniciar' }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Meu Progresso -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4 escola-shell-card info-header escola-progress-small">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0 text-light">
                        <i class="fas fa-chart-line"></i>
                        Meu Progresso
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($modulos as $modulo)
                            @php
                                $matricula = $modulo->matriculas->first();
                                $totalAulas = $modulo->aulas->count();
                                $aulasAssistidas = $matricula?->aulasAssistidas->count() ?? 0;
                                $percentual = $totalAulas > 0 ? round(($aulasAssistidas / $totalAulas) * 100) : 0;
                            @endphp
                            <div class="col-md-6 mb-3">
                                <h6>{{ $modulo->titulo }}</h6>
                                <div class="progress">
                                    <div class="progress-bar bg-info" role="progressbar" 
                                         style="width: {{ $percentual }}%" 
                                         aria-valuenow="{{ $percentual }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        {{ $percentual }}%
                                    </div>
                                </div>
                                <small class="text-muted">
                                    {{ $aulasAssistidas }} de {{ $totalAulas }} aulas concluídas
                                </small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
