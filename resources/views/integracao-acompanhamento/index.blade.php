@extends('layouts.app')

@section('content')
<style>
    .integracao-page-wrapper {
        padding: 2.2rem 1.8rem 2rem;
        background:
            radial-gradient(circle at 0 0, rgba(59,130,246,0.40), transparent 55%),
            radial-gradient(circle at 100% 100%, rgba(56,189,248,0.32), transparent 55%),
            linear-gradient(135deg,#020617 0%,#020617 40%,#02061b 100%);
        border-radius: 26px;
        box-shadow: 0 26px 70px rgba(0,0,0,0.9);
    }

    .integracao-shell-card {
        border: none;
        background: radial-gradient(circle at 0 0, rgba(59,130,246,0.22), transparent 55%),
                    radial-gradient(circle at 100% 100%, rgba(129,140,248,0.18), transparent 55%),
                    rgba(15,23,42,0.98);
        border-radius: 22px;
        box-shadow: 0 22px 60px rgba(15,23,42,0.9);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border: 1px solid rgba(148,163,184,0.30);
        overflow: hidden;
    }

    .integracao-shell-card .card-header {
        background: linear-gradient(135deg,rgba(37,99,235,0.85),rgba(124,58,237,0.9));
        border-bottom: 1px solid rgba(148,163,184,0.35);
        color: #e5edff;
        padding: 0.9rem 1.3rem;
    }

    .integracao-shell-card .card-header h5 {
        font-weight: 600;
        margin-bottom: 0;
    }

    .integracao-shell-card .card-body {
        padding: 1.3rem 1.4rem 1.4rem;
    }

    .integracao-shell-card .card-body h5,
    .integracao-shell-card .card-body h6 {
        color: #e5e7eb;
    }

    .integracao-shell-card .card-body p,
    .integracao-shell-card .card-body span,
    .integracao-shell-card .card-body td,
    .integracao-shell-card .card-body th {
        color: #e5e7eb;
    }

    .integracao-shell-card .btn.btn-primary {
        border-radius: 999px;
        border: none;
        padding: 0.38rem 1.1rem;
        font-size: 0.86rem;
        font-weight: 600;
        background: linear-gradient(135deg,#1d4ed8,#6366f1);
        box-shadow: 0 14px 35px rgba(15,23,42,0.9);
    }

    .integracao-shell-card .btn.btn-primary:hover {
        background: linear-gradient(135deg,#2563eb,#4f46e5);
    }

    .integracao-table-wrapper {
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid rgba(31,41,55,0.8);
        background: rgba(15,23,42,0.85);
    }

    .integracao-table-wrapper table {
        margin-bottom: 0;
        color: #e5e7eb;
    }

    .integracao-table-wrapper thead {
        background: linear-gradient(135deg,rgba(15,23,42,0.98),rgba(30,64,175,0.95));
    }

    .integracao-table-wrapper thead th {
        border-bottom: none;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #9ca3af;
    }

    .integracao-table-wrapper tbody tr {
        background-color: transparent;
        transition: background-color .16s ease, transform .16s ease;
    }

    .integracao-table-wrapper tbody tr:hover {
        background-color: rgba(30,64,175,0.18);
        transform: translateY(-1px);
    }

    .integracao-table-wrapper tbody td {
        border-top-color: rgba(55,65,81,0.9);
        font-size: 0.92rem;
    }

    .integracao-status-badge.badge {
        padding: 0.35rem 0.7rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .integracao-table-actions .btn {
        border-radius: 999px;
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }

    .integracao-empty-cell {
        color: #9ca3af;
    }

    .integracao-pagination {
        margin-top: 1.4rem;
    }

    .integracao-shell-card .alert.alert-success {
        border-radius: 999px;
        border: 1px solid rgba(34,197,94,0.6);
        background: linear-gradient(135deg, rgba(22,163,74,0.22), rgba(21,128,61,0.4));
        color: #bbf7d0;
        box-shadow: 0 16px 40px rgba(6,95,70,0.65);
        padding: 0.55rem 1.1rem;
        font-size: 0.9rem;
    }

    @media (max-width: 767.98px) {
        .integracao-page-wrapper {
            padding: 1.5rem 1.1rem 1.5rem;
        }
    }
</style>

<div class="container my-4" style="max-width: 1200px;">
    <div class="integracao-page-wrapper">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card integracao-shell-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Sessões de Integração e Acompanhamento</h5>
                    @can('create', App\Models\IntegracaoAcompanhamento::class)
                        <a href="{{ route('integracao-acompanhamento.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Nova Sessão
                        </a>
                    @endcan
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive integracao-table-wrapper">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Mentor</th>
                                    <th>Tipo</th>
                                    <th>Status</th>
                                    <th>Duração</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sessoes as $sessao)
                                    <tr>
                                        <td>{{ $sessao->data_agendada->format('d/m/Y H:i') }}</td>
                                        <td>{{ $sessao->mentor->name }}</td>
                                        <td class="integracao-table-actions">
                                            @switch($sessao->tipo)
                                                @case('mentoria')
                                                    <span class="badge bg-primary integracao-status-badge">Mentoria</span>
                                                    @break
                                                @case('feedback')
                                                    <span class="badge bg-info integracao-status-badge">Feedback</span>
                                                    @break
                                                @case('avaliacao')
                                                    <span class="badge bg-warning integracao-status-badge">Avaliação</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            @switch($sessao->status)
                                                @case('agendado')
                                                    <span class="badge bg-secondary integracao-status-badge">Agendado</span>
                                                    @break
                                                @case('realizado')
                                                    <span class="badge bg-success integracao-status-badge">Realizado</span>
                                                    @break
                                                @case('cancelado')
                                                    <span class="badge bg-danger integracao-status-badge">Cancelado</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>{{ $sessao->duracao_minutos }} min</td>
                                        <td>
                                            <a href="{{ route('integracao-acompanhamento.show', $sessao) }}" class="btn btn-sm btn-info" title="Ver detalhes">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @can('update', $sessao)
                                                <a href="{{ route('integracao-acompanhamento.edit', $sessao) }}" class="btn btn-sm btn-primary" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('delete', $sessao)
                                                <form action="{{ route('integracao-acompanhamento.destroy', $sessao) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir esta sessão?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center integracao-empty-cell">Nenhuma sessão encontrada.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center integracao-pagination">
                        {{ $sessoes->links() }}
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection