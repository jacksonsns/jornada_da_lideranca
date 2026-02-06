@extends('layouts.app')

@section('content')
<style>
    .desafios-page-wrapper {
        padding: 1.5rem 1.5rem 1rem;
    }

    .desafios-shell-card {
        border-radius: 26px;
        border: none;
        background: radial-gradient(circle at 0 0, rgba(255,255,255,0.96), rgba(233,239,255,0.98));
        box-shadow: 0 22px 55px rgba(0,0,0,0.65);
        overflow: hidden;
    }

    .desafios-shell-card .card-header {
        border: none;
        border-radius: 26px 26px 0 0 !important;
        background: linear-gradient(135deg,#1b7aff,#33b3ff);
        box-shadow: 0 10px 25px rgba(15,35,95,0.45);
    }

    .desafios-shell-card.secondary-header .card-header {
        background: linear-gradient(135deg,#1bbf7f,#2fd58e);
    }

    .desafios-shell-card.dark-header .card-header {
        background: linear-gradient(135deg,#050c1f,#14223f);
    }

    .desafios-list-group {
        border-radius: 18px;
        overflow: hidden;
    }

    .desafios-list-item {
        background: linear-gradient(90deg,rgba(7,19,55,0.03),rgba(7,19,55,0.08));
        border: none;
        padding: 14px 18px;
        color: #101626;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .desafios-list-item + .desafios-list-item {
        border-top: 1px solid rgba(15,23,42,0.08);
    }

    .desafio-desc {
        flex: 1;
        font-weight: 500;
        font-size: 14px;
    }

    .desafio-badge-pontos {
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 12px;
        box-shadow: 0 8px 18px rgba(21,128,61,0.45);
    }

    .desafio-status {
        font-size: 13px;
        min-width: 90px;
        text-align: center;
    }

    .desafio-btn-concluir {
        border-radius: 999px;
        padding: 6px 14px;
        font-size: 12px;
        box-shadow: 0 10px 22px rgba(22,163,74,0.5);
    }

    .desafios-metric-card h3 {
        font-size: 28px;
        font-weight: 700;
        color: #071327;
        margin-top: 10px;
    }

    .desafios-progress .progress {
        background-color: rgba(15,23,42,0.22);
        border-radius: 999px;
        overflow: hidden;
    }

    .desafios-progress .progress-bar {
        border-radius: 999px;
        box-shadow: 0 10px 25px rgba(22,163,74,0.6);
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .desafios-page-wrapper {
            padding: 1rem 1rem 0.75rem;
        }
    }
</style>

<div class=" desafios-page-wrapper">
    <div class="container-fluid p-0 sm_padding_15px">
        <div class="row">
            <!-- Desafios Ativos -->
            <div class="col-lg-8">
                <div class="card shadow-lg desafios-shell-card">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="text-light">🔥 Desafio Junior</h4>
                    </div>
                    <div class="card-body">
                        <div class="list-group desafios-list-group" id="challenge-list">
                            @foreach($desafios as $desafioUser)
                                <div class="list-group-item d-flex justify-content-between align-items-center desafios-list-item">
                                    <span class="desafio-desc">{{ $desafioUser->desafio->descricao }}</span>
                                    <span class="badge bg-success desafio-badge-pontos">+{{ $desafioUser->desafio->pontos }} pontos</span>

                                    @if($desafioUser->concluido == 1)
                                        <span class="text-success desafio-status">✅ Concluído</span>
                                    @endif

                                    @if($desafioUser->concluido == 0)
                                        <form action="{{ route('desafios.concluir') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="text" value="{{ $desafioUser->id }}" name="desafio_id" hidden>
                                            <button type="submit" class="btn btn-sm btn-outline-success desafio-btn-concluir">Concluir</button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Minhas Conquistas -->
            <div class="col-lg-4">
                <div class="card shadow-lg desafios-shell-card dark-header desafios-metric-card">
                    <div class="card-header bg-dark text-white text-center">
                        <h4 class="text-light">🏆 Minhas Conquistas</h4>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-medal fa-3x text-warning"></i>
                        <h3>{{ $totalPontos }} Pontos</h3>
                        <strong>
                            <p class="mt-3">Você desbloqueou <span id="achievements-count">{{ $conquistas }}</span> conquistas!</p>
                        </strong>
                    </div>
                </div>

                <!-- Barra de Progresso -->
                <div class="card shadow-lg mt-3 desafios-shell-card secondary-header desafios-progress">
                    <div class="card-header bg-success text-white text-center">
                        <h4 class="text-light">📊 Progresso Geral</h4>
                    </div>
                    <div class="card-body text-center">
                        <div class="progress">
                            <div class="progress-bar bg-success" id="progress-bar" style="width: {{ ($progresso / $totalDesafios) * 100 }}%;" role="progressbar">{{ number_format(($progresso / $totalDesafios) * 100, 2) }}%</div>
                        </div>
                        <p class="mt-2">Desafios concluídos: <span id="completed-count">{{ $progresso }}</span> / {{ $totalDesafios }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
