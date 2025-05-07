@extends('layouts.app')

@section('title', 'Escola de Líderes')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
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
            <div class="card shadow mb-4">
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
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $modulo->titulo }}</h5>
                                        <p class="card-text">{{ $modulo->descricao }}</p>
                                        
                                        @php
                                            $matricula = $modulo->matriculas->first();
                                            $totalAulas = $modulo->aulas->count();
                                            $aulasAssistidas = $matricula?->aulasAssistidas->count() ?? 0;
                                            $percentual = $totalAulas > 0 ? round(($aulasAssistidas / $totalAulas) * 100) : 0;
                                        @endphp

                                        <div class="mb-3">
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
            <div class="card shadow mb-4">
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
