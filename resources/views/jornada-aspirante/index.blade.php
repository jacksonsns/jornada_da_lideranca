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
                            <form action="{{ route('desafios.concluir', $desafio) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-success complete-challenge">
                                    Concluir
                                </button>
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
                <p class="mt-3">Você desbloqueou <span id="achievements-count">{{ $conquistas->count() }}</span> conquistas!</p>
                <a href="" class="btn btn-outline-primary">Ver Conquistas</a>
            </div>
        </div>

        <!-- Barra de Progresso -->
        <div class="card shadow-lg mt-3">
            <div class="card-header bg-success text-white text-center">
                <h4 class="text-light">📊 Progresso Geral</h4>
            </div>
            <div class="card-body text-center">
                <div class="progress">
                    <div class="progress-bar bg-success" id="progress-bar" style="width: {{ $progresso }}%;" role="progressbar">
                        {{ $progresso }}%
                    </div>
                </div>
                <p class="mt-2">Desafios concluídos: <span id="completed-count">{{ $desafiosConcluidos }}</span> / {{ $totalDesafios }}</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const progressBar = document.getElementById("progress-bar");
        const completedText = document.getElementById("completed-count");
        const achievementsCount = document.getElementById("achievements-count");

        // Atualiza o progresso quando um desafio é concluído
        document.querySelectorAll(".complete-challenge").forEach(button => {
            button.addEventListener("click", function(e) {
                e.preventDefault();
                const form = this.closest('form');
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.closest('.list-group-item').querySelector('.badge').classList.add('bg-success');
                        this.closest('.list-group-item').querySelector('.complete-challenge').outerHTML = '<span class="text-success">✅ Concluído</span>';
                        
                        // Atualiza o progresso
                        const completedCount = parseInt(completedText.textContent) + 1;
                        const totalChallenges = {{ $totalDesafios }};
                        const progressPercentage = (completedCount / totalChallenges) * 100;
                        
                        progressBar.style.width = progressPercentage + "%";
                        progressBar.textContent = Math.round(progressPercentage) + "%";
                        completedText.textContent = completedCount;
                        
                        // Atualiza o número de conquistas
                        achievementsCount.textContent = parseInt(achievementsCount.textContent) + 1;
                    }
                });
            });
        });
    });
</script>
@endpush
@endsection 