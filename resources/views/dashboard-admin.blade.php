@extends('layouts.app-admin')

@section('content')
<div class="container-fluid py-4">
    <div class="admin-shell-wrapper">
        <div class="admin-header mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
            <div>
                <h1 class="admin-title mb-1">Integração e Acompanhamento</h1>
                <p class="admin-subtitle mb-0">Visão geral dos usuários, desafios e jornadas.</p>
            </div>
        </div>

        <!-- Cards de Estatísticas -->
        <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary admin-stat-card h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total de Usuários</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsuarios }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success admin-stat-card h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Desafios Completados</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $desafiosCompletados }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-trophy fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info admin-stat-card h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Módulos Disponíveis</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalModulos }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning admin-stat-card h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Projetos Ativos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProjetos }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-project-diagram fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <!-- Listas e Tabelas -->
        <div class="row">
            <!-- Usuários -->
            <div class="w-100">
                <div class="card admin-users-card mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Usuários</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive admin-users-table-wrapper">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Data de Cadastro</th>
                                        <th>Pontuação Desafios Junior</th>
                                        <th>Pontuação Jornadas Aspirante</th>
                                        <th>Pontuação Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($usuarios as $usuario)
                                    <tr>
                                        <td>{{ $usuario->name }}</td>
                                        <td>{{ $usuario->email }}</td>
                                        <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $usuario->total_pontos_desafios ?? 0 }}</td>
                                        <td>{{ $usuario->total_pontos_jornadas ?? 0 }}</td>
                                        <td>{{ $usuario->total_pontos_jornadas + $usuario->total_pontos_desafios ?? 0 }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center admin-users-pagination">
                                {{ $usuarios->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Gráfico de Usuários por Mês
const usuariosCtx = document.getElementById('usuariosChart').getContext('2d');
new Chart(usuariosCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($usuariosPorMes->pluck('mes')) !!},
        datasets: [{
            label: 'Usuários Cadastrados',
            data: {!! json_encode($usuariosPorMes->pluck('total')) !!},
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }]
    }
});

// Gráfico de Status dos Desafios
const desafiosCtx = document.getElementById('desafiosChart').getContext('2d');
new Chart(desafiosCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($desafiosPorStatus->pluck('status')) !!},
        datasets: [{
            data: {!! json_encode($desafiosPorStatus->pluck('total')) !!},
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
            ]
        }]
    }
});
</script>
@endpush

@push('styles')
<style>
    .admin-shell-wrapper {
        padding: 2.2rem 1.9rem 2rem;
        background:
            radial-gradient(circle at 0 0, rgba(59,130,246,0.40), transparent 55%),
            radial-gradient(circle at 100% 100%, rgba(56,189,248,0.32), transparent 55%),
            linear-gradient(135deg,#020617 0%,#020617 40%,#02061b 100%);
        border-radius: 26px;
        box-shadow: 0 26px 70px rgba(0,0,0,0.95);
    }

    .admin-title {
        font-size: 1.9rem;
        font-weight: 700;
        color: #e5edff;
    }

    .admin-subtitle {
        font-size: 0.95rem;
        color: #9ca3af;
    }

    .admin-stat-card {
        border: none;
        border-radius: 22px;
        background: radial-gradient(circle at 0 0, rgba(59,130,246,0.22), transparent 55%),
                    radial-gradient(circle at 100% 100%, rgba(129,140,248,0.18), transparent 55%),
                    rgba(15,23,42,0.98);
        box-shadow: 0 22px 60px rgba(15,23,42,0.9);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        position: relative;
        overflow: hidden;
    }

    .admin-stat-card .card-body {
        padding: 1.1rem 1.2rem;
    }

    .admin-stat-card .text-xs {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #9ca3af !important;
    }

    .admin-stat-card .h5 {
        font-size: 1.3rem;
        color: #e5edff;
    }

    .admin-stat-card .col-auto i {
        color: rgba(148,163,184,0.9) !important;
    }

    .border-left-primary {
        border-left: 4px solid rgba(59,130,246,0.8) !important;
    }

    .border-left-success {
        border-left: 4px solid rgba(34,197,94,0.8) !important;
    }

    .border-left-info {
        border-left: 4px solid rgba(56,189,248,0.8) !important;
    }

    .border-left-warning {
        border-left: 4px solid rgba(234,179,8,0.9) !important;
    }

    .admin-users-card {
        border: none;
        border-radius: 22px;
        background: radial-gradient(circle at 0 0, rgba(59,130,246,0.18), transparent 55%),
                    radial-gradient(circle at 100% 100%, rgba(129,140,248,0.16), transparent 55%),
                    rgba(15,23,42,0.98);
        box-shadow: 0 22px 60px rgba(15,23,42,0.9);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        overflow: hidden;
    }

    .admin-users-card .card-header {
        background: linear-gradient(135deg,rgba(37,99,235,0.9),rgba(124,58,237,0.95));
        border-bottom: 1px solid rgba(148,163,184,0.35);
        color: #e5edff;
    }

    .admin-users-card .card-header h6 {
        font-size: 0.95rem;
        font-weight: 600;
    }

    .admin-users-card .card-body {
        padding: 1.3rem 1.4rem 1.4rem;
    }

    .admin-users-table-wrapper table {
        color: #e5e7eb;
        margin-bottom: 0;
    }

    .admin-users-table-wrapper thead {
        background: linear-gradient(135deg,rgba(15,23,42,0.98),rgba(30,64,175,0.95));
    }

    .admin-users-table-wrapper thead th {
        border-bottom: none;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #9ca3af;
    }

    .admin-users-table-wrapper tbody tr {
        background-color: transparent;
        transition: background-color .16s ease, transform .16s ease;
    }

    .admin-users-table-wrapper tbody tr:hover {
        background-color: rgba(30,64,175,0.20);
        transform: translateY(-1px);
    }

    .admin-users-table-wrapper tbody td {
        border-top-color: rgba(55,65,81,0.9);
        font-size: 0.9rem;
    }

    .admin-users-pagination {
        margin-top: 1.3rem;
    }

    @media (max-width: 767.98px) {
        .admin-shell-wrapper {
            padding: 1.6rem 1.1rem 1.6rem;
        }

        .admin-title {
            font-size: 1.6rem;
        }
    }
</style>
@endpush
@endsection