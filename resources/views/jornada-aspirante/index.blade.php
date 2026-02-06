@extends('layouts.app')

@section('title', 'Jornada do Aspirante')

@section('content')
<style>
    .jornada-page-wrapper {
        padding: 1.5rem 1.5rem 1rem;
    }

    .jornada-shell-card {
        border-radius: 26px;
        border: none;
        background: radial-gradient(circle at 0 0, rgba(255,255,255,0.96), rgba(233,239,255,0.98));
        box-shadow: 0 22px 55px rgba(0,0,0,0.65);
        overflow: hidden;
    }

    .jornada-shell-card .card-header {
        border: none;
        border-radius: 26px 26px 0 0 !important;
        background: linear-gradient(135deg,#1b7aff,#33b3ff);
        box-shadow: 0 10px 25px rgba(15,35,95,0.45);
    }

    .jornada-shell-card.secondary-header .card-header {
        background: linear-gradient(135deg,#1bbf7f,#2fd58e);
    }

    .jornada-shell-card.dark-header .card-header {
        background: linear-gradient(135deg,#050c1f,#14223f);
    }

    .jornada-list-group {
        border-radius: 18px;
        overflow: hidden;
    }

    .jornada-list-item {
        background: linear-gradient(90deg,rgba(7,19,55,0.03),rgba(7,19,55,0.08));
        border: none;
        padding: 14px 18px;
        color: #101626;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .jornada-list-item + .jornada-list-item {
        border-top: 1px solid rgba(15,23,42,0.08);
    }

    .jornada-desc {
        flex: 1;
        font-weight: 500;
        font-size: 14px;
    }

    .jornada-badge-pontos {
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 12px;
        box-shadow: 0 8px 18px rgba(37,99,235,0.45);
    }

    .jornada-status {
        font-size: 13px;
        min-width: 90px;
        text-align: center;
    }

    .jornada-btn-concluir {
        border-radius: 999px;
        padding: 6px 14px;
        font-size: 12px;
        box-shadow: 0 10px 22px rgba(22,163,74,0.5);
    }

    .jornada-metric-card h2 {
        font-size: 28px;
        font-weight: 700;
        color: #071327;
        margin-top: 10px;
    }

    .jornada-progress .progress {
        background-color: rgba(15,23,42,0.22);
        border-radius: 999px;
        overflow: hidden;
    }

    .jornada-progress .progress-bar {
        border-radius: 999px;
        box-shadow: 0 10px 25px rgba(22,163,74,0.6);
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .jornada-page-wrapper {
            padding: 1rem 1rem 0.75rem;
        }
    }
</style>

<div class="jornada-page-wrapper">
<div class="row">
    <!-- Desafios Ativos -->
    <div class="col-lg-8">
        <div class="card shadow-lg jornada-shell-card">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="text-light">🔥 Desafios Ativos</h4>
            </div>
            <div class="card-body">
                <div class="list-group jornada-list-group" id="challenge-list">
                    @foreach($desafios as $desafio)
                    <div class="list-group-item d-flex justify-content-between align-items-center jornada-list-item">
                        <span class="jornada-desc">{{ $desafio->descricao }}</span>
                        <span class="badge jornada-badge-pontos bg-{{ $desafio->pontos > 5 ? 'danger' : ($desafio->pontos > 2 ? 'warning' : 'success') }}">
                            +{{ $desafio->pontos }} pontos
                        </span>
                        @if(!$desafio->concluido)
                        <form action="{{ route('jornada.concluir', $desafio) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-success jornada-btn-concluir">Concluir</button>
                        </form>
                        @else
                            <span class="text-success jornada-status">✅ Concluído</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Minhas Conquistas -->
    <div class="col-lg-4">
        <div class="card shadow-lg jornada-shell-card dark-header jornada-metric-card">
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
        <div class="card shadow-lg mt-3 jornada-shell-card secondary-header jornada-progress">
            <div class="card-header bg-success text-white text-center">
                <h4 class="text-light">📊 Progresso Geral</h4>
            </div>
            <div class="card-body text-center">
                <div class="progress" style="width: 100%">
                    <div class="progress-bar bg-success" id="progress-bar" style="width: {{ (float) $progresso }}%" role="progressbar">{{ $progresso }}%</div>
                </div>
                <p class="mt-2">Desafios concluídos: <span id="completed-count">{{ $desafiosConcluidos }}</span> / {{ $totalDesafios }}</p>
            </div>
        </div>
    </div>
</div>

@endsection 