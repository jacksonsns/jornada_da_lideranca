@extends('layouts.app')

@section('title', $modulo->titulo)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
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
                                <div class="card">
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
                                <div class="card mb-4">
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