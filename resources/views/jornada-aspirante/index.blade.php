@extends('layouts.app')

@section('title', 'Jornada do Aspirante')

@section('content')
<div class="row">
    <!-- Desafios Ativos -->
    <div class="col-lg-8">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="text-light">🔥 Desafios Ativos</h4>
            </div>
            <div class="card-body">
                <div class="list-group" id="challenge-list">
                    @foreach($desafios as $desafio)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $desafio->descricao }}</span>
                        <span class="badge bg-{{ $desafio->pontos > 5 ? 'danger' : ($desafio->pontos > 2 ? 'warning' : 'success') }}">
                            +{{ $desafio->pontos }} pontos
                        </span>
                        @if(!$desafio->concluido)
                        <form action="{{ route('jornada.concluir', $desafio) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-success">Concluir</button>
                        </form>
                        @else
                            <span class="text-success">✅ Concluído</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Minhas Conquistas -->
    <div class="col-lg-4">
        <div class="card shadow-lg">
            <div class="card-header bg-dark text-white text-center">
                <h4 class="text-light">🏆 Minhas Conquistas</h4>
            </div>
            <div class="card-body text-center">
                <i class="fas fa-medal fa-3x text-warning"></i>
                <h2>{{ $totalPontos }} Pontos</h2>
                <p class="mt-3">Você desbloqueou <span id="achievements-count">{{ $desafiosConcluidos }}</span> conquistas!</p>
            </div>
        </div>

        <!-- Barra de Progresso -->
        <div class="card shadow-lg mt-3">
            <div class="card-header bg-success text-white text-center">
                <h4 class="text-light">📊 Progresso Geral</h4>
            </div>
            <div class="card-body text-center">
                <div class="progress">
                    <div class="progress" style="width: 100%">
                        <div class="progress-bar bg-success" id="progress-bar" style="width: {{ (float) $progresso }}%" role="progressbar">{{ $progresso }}%</div>
                    </div>
                </div>
                <p class="mt-2">Desafios concluídos: <span id="completed-count">{{ $desafiosConcluidos }}</span> / {{ $totalDesafios }}</p>
            </div>
        </div>
    </div>
</div>

@endsection 