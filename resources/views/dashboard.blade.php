@extends('layouts.app')

@section('content')
<style>
    .dashboard-shell-wrapper {
        padding: 2.2rem 2rem 2rem;
        background:
            radial-gradient(circle at 0 0, rgba(59,130,246,0.42), transparent 55%),
            radial-gradient(circle at 100% 100%, rgba(56,189,248,0.40), transparent 55%),
            linear-gradient(135deg,#020617 0%,#020617 40%,#02061b 100%);
        border-radius: 26px;
        box-shadow: 0 26px 70px rgba(0,0,0,0.9);
    }

    .dashboard-page-header {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 26px;
    }

    .dashboard-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #e5edff;
        margin-bottom: 4px;
    }

    .dashboard-subtitle {
        font-size: 0.95rem;
        color: #9ca3af;
    }

    .dashboard-quick-actions {
        color: #9ca3af;
    }

    .quick-actions-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #6b7280;
    }

    .quick-action-btn {
        width: 38px;
        height: 38px;
        border-radius: 999px;
        border: 1px solid rgba(148,163,184,0.35);
        background: radial-gradient(circle at 0 0, rgba(59,130,246,0.3), transparent 60%),
                    rgba(15,23,42,0.92);
        color: #e5edff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 14px 35px rgba(15,23,42,0.85);
        transition: transform .18s ease, box-shadow .18s ease, background .18s ease, border-color .18s ease;
    }

    .quick-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 45px rgba(15,23,42,0.9);
        border-color: rgba(129,140,248,0.8);
        background: radial-gradient(circle at 0 0, rgba(59,130,246,0.45), transparent 60%),
                    rgba(15,23,42,0.98);
    }

    .dashboard-cards-row {
        margin-top: 8px;
    }

    .card.dashboard-card {
        border: none;
        background: radial-gradient(circle at 0 0, rgba(59,130,246,0.18), transparent 55%),
                    radial-gradient(circle at 100% 100%, rgba(129,140,248,0.16), transparent 55%),
                    rgba(15,23,42,0.98);
        border-radius: 22px;
        box-shadow: 0 22px 60px rgba(15,23,42,0.9);
        overflow: hidden;
        position: relative;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        border: 1px solid rgba(148,163,184,0.28);
    }

    .card.dashboard-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 0 0, rgba(59,130,246,0.22), transparent 60%);
        opacity: 0;
        pointer-events: none;
        transition: opacity .18s ease;
    }

    .card.dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 28px 70px rgba(15,23,42,0.95);
        border-color: rgba(129,140,248,0.9);
    }

    .card.dashboard-card:hover::before {
        opacity: 1;
    }

    .card.dashboard-card .card-body {
        padding: 1.3rem 1.4rem 1.3rem;
    }

    .dashboard-card-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.05rem;
        font-weight: 600;
        color: #e5edff;
        margin-bottom: 0.45rem;
    }

    .dashboard-card-title i {
        font-size: 1.1rem;
    }

    .dashboard-card .card-text {
        font-size: 0.9rem;
        color: #9ca3af;
        margin-bottom: 0.85rem;
    }

    .dashboard-card .btn.btn-primary {
        border-radius: 999px;
        border: none;
        padding: 0.38rem 1.1rem;
        font-size: 0.85rem;
        font-weight: 600;
        background: linear-gradient(135deg,#1d4ed8,#6366f1);
        box-shadow: 0 14px 35px rgba(15,23,42,0.9);
    }

    .dashboard-card .btn.btn-primary:hover {
        background: linear-gradient(135deg,#2563eb,#4f46e5);
    }

    @media (max-width: 767.98px) {
        .dashboard-shell-wrapper {
            padding: 1.4rem 1.1rem 1.4rem;
        }

        .dashboard-page-header {
            align-items: flex-start;
        }

        .dashboard-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="container-fluid py-4">
    <div class="dashboard-shell-wrapper">
        <div class="dashboard-page-header">
            <div>
                <h1 class="dashboard-title mb-1">Dashboard</h1>
                <p class="dashboard-subtitle mb-0">Bem-vindo de volta! Selecione uma das opções para iniciar</p>
            </div>
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
