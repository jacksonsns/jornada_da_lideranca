@extends('layouts.app')

@section('content')
<div class="container-fluid dashboard-page py-4">
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h1 class="dashboard-title mb-2">Dashboard</h1>
            <p class="dashboard-subtitle mb-0">Bem-vindo de volta! Selecione uma das opções para iniciar</p>
        </div>
        <div class="col-md-4 d-flex justify-content-md-end mt-3 mt-md-0">
            <div class="dashboard-quick-actions text-md-right">
                <span class="quick-actions-label d-block mb-2">Atalhos rápidos</span>
                <div class="d-flex gap-2 justify-content-md-end">
                    <button type="button" class="quick-action-btn" title="Quadro dos Sonhos">
                        <i class="fas fa-star"></i>
                    </button>
                    <button type="button" class="quick-action-btn" title="Desafios">
                        <i class="fas fa-trophy"></i>
                    </button>
                    <button type="button" class="quick-action-btn" title="Agenda">
                        <i class="fas fa-calendar-alt"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row dashboard-cards-row">
        <!-- Quadro dos Sonhos -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card dashboard-card">
                <div class="card-body">
                    <h5 class="card-title dashboard-card-title">
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
            <div class="card dashboard-card">
                <div class="card-body">
                    <h5 class="card-title dashboard-card-title">
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
            <div class="card dashboard-card">
                <div class="card-body">
                    <h5 class="card-title dashboard-card-title">
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
            <div class="card dashboard-card">
                <div class="card-body">
                    <h5 class="card-title dashboard-card-title">
                        <i class="fas fa-graduation-cap text-primary"></i>
                        Escola de Líderes
                    </h5>
                    <p class="card-text">Acesse os conteúdos da escola de líderes.</p>
                    <a href="{{ route('escola-lideres.index') }}" class="btn btn-primary">Acessar</a>
                </div>
            </div>
        </div>

        <!-- Capacitações -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card dashboard-card">
                <div class="card-body">
                    <h5 class="card-title dashboard-card-title">
                        <i class="fas fa-book text-success"></i>
                        Capacitações
                    </h5>
                    <p class="card-text">Participe das capacitações disponíveis.</p>
                    <a href="{{ route('capacitacoes.index') }}" class="btn btn-primary">Acessar</a>
                </div>
            </div>
        </div>

        <!-- Projeto Individual -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card dashboard-card">
                <div class="card-body">
                    <h5 class="card-title dashboard-card-title">
                        <i class="fas fa-project-diagram text-purple"></i>
                        Projeto Individual
                    </h5>
                    <p class="card-text">Gerencie seu projeto individual.</p>
                    <a href="{{ route('projeto-individual.index') }}" class="btn btn-primary">Acessar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Removendo o script do modal pois não é mais necessário
</script>
@endpush
