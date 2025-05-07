@extends('layouts.app-admin')

@section('content')
<div class="container-fluid">
    <!-- Cards de Estatísticas -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
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
            <div class="card border-left-success shadow h-100 py-2">
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
            <div class="card border-left-info shadow h-100 py-2">
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
            <div class="card border-left-warning shadow h-100 py-2">
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

    <!-- Gráficos -->
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Crescimento de Usuários</h6>
                </div>
                <div class="card-body">
                    <canvas id="usuariosChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Status dos Desafios</h6>
                </div>
                <div class="card-body">
                    <canvas id="desafiosChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Listas e Tabelas -->
    <div class="row">
        <!-- Últimos Usuários -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Últimos Usuários Cadastrados</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Data de Cadastro</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ultimosUsuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->name }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Próximos Eventos -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Próximos Eventos</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Evento</th>
                                    <th>Data</th>
                                    <th>Local</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proximosEventos as $evento)
                                <tr>
                                    <td>{{ $evento->titulo }}</td>
                                    <td>{{ $evento->data->format('d/m/Y H:i') }}</td>
                                    <td>{{ $evento->local }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
.border-left-primary {
    border-left: 4px solid #4e73df !important;
}
.border-left-success {
    border-left: 4px solid #1cc88a !important;
}
.border-left-info {
    border-left: 4px solid #36b9cc !important;
}
.border-left-warning {
    border-left: 4px solid #f6c23e !important;
}
</style>
@endpush
@endsection