@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Dashboard</h1>
        </div>
    </div>

    <div class="row">
        <!-- Quadro dos Sonhos -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-star text-warning"></i>
                        Quadro dos Sonhos
                    </h5>
                    <p class="card-text">Visualize e gerencie seus sonhos e objetivos.</p>
                    <a href="{{ route('quadro-dos-sonhos.index') }}" class="btn btn-primary">Acessar</a>
                </div>
            </div>
        </div>

        <!-- Desafios -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-trophy text-warning"></i>
                        Desafios
                    </h5>
                    <p class="card-text">Participe dos desafios e conquiste pontos.</p>
                    <a href="{{ route('desafios.index') }}" class="btn btn-primary">Acessar</a>
                </div>
            </div>
        </div>

        <!-- Jornada do Aspirante -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-road text-info"></i>
                        Jornada do Aspirante
                    </h5>
                    <p class="card-text">Acompanhe sua evolução na jornada.</p>
                    <a href="{{ route('jornada-aspirante.index') }}" class="btn btn-primary">Acessar</a>
                </div>
            </div>
        </div>

        <!-- Escola de Líderes -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-graduation-cap text-primary"></i>
                        Escola de Líderes
                    </h5>
                    <p class="card-text">Acesse os conteúdos da escola de líderes.</p>
                    <a href="#" class="btn btn-primary btn-modal">Acessar</a>
                </div>
            </div>
        </div>

        <!-- Capacitações -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-book text-success"></i>
                        Capacitações
                    </h5>
                    <p class="card-text">Participe das capacitações disponíveis.</p>
                    <a href="#" class="btn btn-primary btn-modal">Acessar</a>
                </div>
            </div>
        </div>

        <!-- Projeto Individual -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-project-diagram text-purple"></i>
                        Projeto Individual
                    </h5>
                    <p class="card-text">Gerencie seu projeto individual.</p>
                    <a href="#" class="btn btn-primary btn-modal">Acessar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalEmDesenvolvimento" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-warning">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title" id="modalLabel">Área em Desenvolvimento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body text-center">
        <p>Essa área ainda está em desenvolvimento.</p>
        <p>Estamos trabalhando para disponibilizá-la em breve!</p>
        <img src="https://cdn-icons-png.flaticon.com/512/2784/2784461.png" alt="Em desenvolvimento" width="80">
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = new bootstrap.Modal(document.getElementById('modalEmDesenvolvimento'));

        document.querySelectorAll('.btn-modal').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                modal.show();
            });
        });
    });
</script>
@endpush
