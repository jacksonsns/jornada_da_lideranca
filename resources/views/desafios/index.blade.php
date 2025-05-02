@extends('layouts.app')

@section('content')
<div class="main_content_iner">
    <div class="container-fluid p-0 sm_padding_15px">
        <div class="row">
            <!-- Desafios Ativos -->
            <div class="col-lg-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="text-light">🔥 Desafio Junior</h4>
                    </div>
                    <div class="card-body">
                        <div class="list-group" id="challenge-list">
                            @foreach($desafios as $desafioUser)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $desafioUser->desafio->descricao }}</span>
                                    <span class="badge bg-success">+{{ $desafioUser->desafio->pontos }} pontos</span>
                            
                                    @if($desafioUser->concluido == 1)
                                        <span class="text-success">✅ Concluído</span>
                                    @endif

                                    @if($desafioUser->concluido == 0)
                                        <form action="{{ route('desafios.concluir') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="text" value="{{ $desafioUser->id }}" name="desafio_id" hidden>
                                            <button type="submit" class="btn btn-sm btn-outline-success">Concluir</button>
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
                <div class="card shadow-lg">
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
                <div class="card shadow-lg mt-3">
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
