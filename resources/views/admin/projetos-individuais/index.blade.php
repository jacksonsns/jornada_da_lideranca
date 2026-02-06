@extends('layouts.app-admin')

@section('title', 'Gerenciar Projetos Individuais')

@push('styles')
<style>
    .admin-projetos-shell {
        min-height: 100vh;
        padding: 32px 16px;
        background: radial-gradient(circle at top left, rgba(88, 101, 242, 0.22), transparent 55%),
                    radial-gradient(circle at bottom right, rgba(56, 189, 248, 0.18), transparent 55%),
                    linear-gradient(135deg, #020617 0%, #020617 40%, #020617 100%);
        display: flex;
        align-items: stretch;
    }

    .admin-projetos-shell-inner {
        width: 100%;
        max-width: 1240px;
        margin: 0 auto;
    }

    .admin-projetos-card {
        border-radius: 26px;
        overflow: hidden;
        border: 1px solid rgba(148, 163, 184, 0.45);
        background:
            radial-gradient(circle at top left, rgba(56, 189, 248, 0.22), transparent 60%),
            radial-gradient(circle at bottom right, rgba(59, 130, 246, 0.25), transparent 60%),
            linear-gradient(135deg, rgba(15, 23, 42, 0.92), rgba(15, 23, 42, 0.97));
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        box-shadow: 0 24px 80px rgba(15, 23, 42, 0.9);
    }

    .admin-projetos-header {
        padding: 20px 24px 18px;
        background:
            linear-gradient(120deg, rgba(37, 99, 235, 0.97), rgba(79, 70, 229, 0.97));
        border-bottom: 1px solid rgba(148, 163, 184, 0.55);
    }

    .admin-projetos-header-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #e5f0ff;
        letter-spacing: 0.01em;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .admin-projetos-header-title i {
        color: #bfdbfe;
    }

    .admin-projetos-header-subtitle {
        font-size: 0.86rem;
        color: rgba(226, 232, 240, 0.85);
        margin: 0;
    }

    .admin-projetos-card-body {
        padding: 18px 22px 22px;
    }

    .admin-projetos-alert-success {
        border-radius: 999px;
        border: 1px solid rgba(34, 197, 94, 0.5);
        background: radial-gradient(circle at top left, rgba(22, 163, 74, 0.18), transparent 60%),
                    rgba(15, 23, 42, 0.9);
        color: #bbf7d0;
    }

    .admin-projetos-alert-error {
        border-radius: 999px;
        border: 1px solid rgba(248, 113, 113, 0.8);
        background: radial-gradient(circle at top left, rgba(248, 113, 113, 0.22), transparent 60%),
                    rgba(15, 23, 42, 0.92);
        color: #fecaca;
    }

    .admin-projetos-table-wrapper {
        border-radius: 18px;
        border: 1px solid rgba(148, 163, 184, 0.35);
        overflow: hidden;
        background:
            radial-gradient(circle at top left, rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.98));
    }

    .admin-projetos-table {
        color: #e5e7eb;
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
        background-color: transparent;
    }

    .admin-projetos-table thead {
        background:
            linear-gradient(120deg, rgba(15, 23, 42, 0.96), rgba(30, 64, 175, 0.98));
    }

    .admin-projetos-table thead th {
        border-bottom: 1px solid rgba(148, 163, 184, 0.6);
        border-top: none;
        padding: 10px 14px;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: rgba(148, 163, 184, 0.96);
        font-weight: 600;
        white-space: nowrap;
    }

    .admin-projetos-table tbody tr {
        transition: all 0.14s ease-out;
        background: rgba(15, 23, 42, 0.9);
    }

    .admin-projetos-table tbody tr:nth-child(even) {
        background: rgba(15, 23, 42, 0.96);
    }

    .admin-projetos-table tbody tr:hover {
        background: linear-gradient(90deg, rgba(30, 64, 175, 0.72), rgba(15, 23, 42, 0.98));
        transform: translateY(-1px);
    }

    .admin-projetos-table tbody td {
        border-top: 1px solid rgba(30, 64, 175, 0.5);
        padding: 9px 14px;
        font-size: 0.88rem;
        vertical-align: middle;
    }

    .admin-projetos-badge-status {
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 0.72rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .admin-projetos-badge-status.dot::before {
        content: '';
        width: 7px;
        height: 7px;
        border-radius: 999px;
        background: currentColor;
        opacity: 0.9;
    }

    .admin-projetos-status-andamento {
        background: rgba(59, 130, 246, 0.15);
        color: #bfdbfe;
        border: 1px solid rgba(59, 130, 246, 0.5);
    }

    .admin-projetos-status-concluido {
        background: rgba(22, 163, 74, 0.15);
        color: #bbf7d0;
        border: 1px solid rgba(22, 163, 74, 0.5);
    }

    .admin-projetos-status-cancelado {
        background: rgba(239, 68, 68, 0.18);
        color: #fecaca;
        border: 1px solid rgba(248, 113, 113, 0.7);
    }

    .admin-projetos-table-actions .btn {
        min-width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: 0;
        border: 1px solid transparent;
        font-size: 0.82rem;
        transition: all 0.16s ease-out;
    }

    .admin-projetos-btn-view {
        background: linear-gradient(135deg, #22c55e, #0ea5e9);
        border-color: rgba(187, 247, 208, 0.85);
        color: #ecfdf5;
        box-shadow: 0 10px 26px rgba(34, 197, 94, 0.6);
    }

    .admin-projetos-btn-edit {
        background: linear-gradient(135deg, #0ea5e9, #2563eb);
        border-color: rgba(191, 219, 254, 0.85);
        color: #eff6ff;
        box-shadow: 0 10px 26px rgba(37, 99, 235, 0.6);
    }

    .admin-projetos-btn-view:hover,
    .admin-projetos-btn-edit:hover {
        transform: translateY(-1px) scale(1.03);
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.85);
        color: #ffffff;
    }

    .admin-projetos-pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 1rem;
    }

    .admin-projetos-pagination-wrapper nav {
        background: rgba(15, 23, 42, 0.7);
        padding: 6px 14px;
        border-radius: 999px;
        border: 1px solid rgba(148, 163, 184, 0.5);
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.7);
    }

    .admin-projetos-pagination-wrapper .page-link {
        background: transparent;
        border: none;
        color: rgba(209, 213, 219, 0.9);
        font-size: 0.82rem;
        padding: 6px 10px;
        border-radius: 999px !important;
    }

    .admin-projetos-pagination-wrapper .page-item.active .page-link {
        background: linear-gradient(135deg, #0ea5e9, #2563eb);
        color: #f9fafb;
    }

    .admin-projetos-pagination-wrapper .page-link:hover {
        background: rgba(30, 64, 175, 0.8);
        color: #e5e7eb;
    }

    /* Modais */
    .admin-projetos-modal {
        background:
            radial-gradient(circle at top left, rgba(56, 189, 248, 0.22), transparent 55%),
            radial-gradient(circle at bottom right, rgba(59, 130, 246, 0.22), transparent 55%),
            linear-gradient(135deg, rgba(15, 23, 42, 0.96), rgba(15, 23, 42, 0.98));
        border-radius: 22px;
        border: 1px solid rgba(148, 163, 184, 0.65);
        box-shadow: 0 26px 80px rgba(15, 23, 42, 0.95);
        overflow: hidden;
        color: #e5e7eb;
    }

    .admin-projetos-modal-header-primary {
        background: linear-gradient(120deg, rgba(37, 99, 235, 0.98), rgba(79, 70, 229, 0.98));
        border-bottom: 1px solid rgba(148, 163, 184, 0.7);
        padding: 14px 18px;
        color: #eff6ff;
    }

    .admin-projetos-modal-header-info {
        background: linear-gradient(120deg, rgba(56, 189, 248, 0.98), rgba(59, 130, 246, 0.98));
        border-bottom: 1px solid rgba(191, 219, 254, 0.9);
        padding: 14px 18px;
        color: #e0f2fe;
    }

    .admin-projetos-modal-body {
        padding: 18px 20px 16px;
    }

    .admin-projetos-modal-footer {
        border-top: 1px solid rgba(148, 163, 184, 0.6);
        padding: 12px 18px 14px;
        background: rgba(15, 23, 42, 0.92);
    }

    .admin-projetos-select {
        background: rgba(15, 23, 42, 0.9);
        border-radius: 999px;
        border: 1px solid rgba(148, 163, 184, 0.7);
        color: #e5e7eb;
        font-size: 0.9rem;
        padding: 8px 14px;
    }

    .admin-projetos-select:focus {
        background: rgba(15, 23, 42, 0.98);
        border-color: rgba(59, 130, 246, 0.9);
        box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.9);
        color: #f9fafb;
    }

    .admin-projetos-btn-primary {
        border-radius: 999px;
        padding: 7px 18px;
        font-size: 0.88rem;
        font-weight: 600;
        border: 1px solid rgba(191, 219, 254, 0.8);
        background: linear-gradient(135deg, #0ea5e9, #2563eb);
        color: #f9fafb;
        box-shadow: 0 12px 30px rgba(37, 99, 235, 0.7);
        transition: all 0.16s ease-out;
    }

    .admin-projetos-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 16px 40px rgba(37, 99, 235, 0.9);
        color: #ffffff;
    }

    .admin-projetos-btn-secondary {
        border-radius: 999px;
        padding: 7px 16px;
        font-size: 0.86rem;
        font-weight: 500;
        border: 1px solid rgba(148, 163, 184, 0.7);
        background: rgba(15, 23, 42, 0.8);
        color: rgba(209, 213, 219, 0.9);
        transition: all 0.16s ease-out;
    }

    .admin-projetos-btn-secondary:hover {
        background: rgba(15, 23, 42, 0.95);
        color: #e5e7eb;
    }

    @media (max-width: 991.98px) {
        .admin-projetos-shell {
            padding: 18px 10px 24px;
        }

        .admin-projetos-card {
            border-radius: 22px;
        }

        .admin-projetos-header {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 10px;
        }
    }

    @media (max-width: 575.98px) {
        .admin-projetos-card-body {
            padding: 14px 12px 16px;
        }

        .admin-projetos-table thead th,
        .admin-projetos-table tbody td {
            padding: 8px 8px;
        }

        .admin-projetos-shell {
            padding-top: 16px;
        }
    }
</style>
@endpush

@section('content')
<div class="admin-projetos-shell">
    <div class="admin-projetos-shell-inner">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="admin-projetos-card">
                    <div class="admin-projetos-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 admin-projetos-header-title">
                                <i class="fas fa-project-diagram"></i>
                                Gerenciar Projetos Individuais
                            </h4>
                            <p class="admin-projetos-header-subtitle">Acompanhe o status e o progresso dos projetos individuais dos usuários.</p>
                        </div>
                    </div>
                    <div class="admin-projetos-card-body">
                        @if(session('success'))
                            <div class="alert alert-success admin-projetos-alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger admin-projetos-alert-error" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="table-responsive admin-projetos-table-wrapper mt-2">
                            <table class="table table-bordered table-hover mb-0 admin-projetos-table">
                                <thead>
                                    <tr>
                                        <th>Usuário</th>
                                        <th>Título</th>
                                        <th>Data Início</th>
                                        <th>Data Fim</th>
                                        <th>Status</th>
                                        <th>Última Atualização</th>
                                        <th width="150" class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($projetos as $projeto)
                                        <tr>
                                            <td>{{ $projeto->user->name }}</td>
                                            <td>{{ $projeto->titulo }}</td>
                                            <td>{{ $projeto->data_inicio->format('d/m/Y') }}</td>
                                            <td>{{ $projeto->data_fim ? $projeto->data_fim->format('d/m/Y') : '-' }}</td>
                                            <td>
                                                @php
                                                    $statusClass = $projeto->status === 'em_andamento'
                                                        ? 'admin-projetos-status-andamento'
                                                        : ($projeto->status === 'concluido'
                                                            ? 'admin-projetos-status-concluido'
                                                            : 'admin-projetos-status-cancelado');
                                                @endphp
                                                <span class="admin-projetos-badge-status dot {{ $statusClass }}">
                                                    {{ ucfirst(str_replace('_', ' ', $projeto->status)) }}
                                                </span>
                                            </td>
                                            <td>{{ $projeto->updated_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2 admin-projetos-table-actions">
                                                    <button type="button" class="btn admin-projetos-btn-view" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalVisualizar"
                                                            data-projeto='@json($projeto)'>
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn admin-projetos-btn-edit" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalStatus"
                                                            data-id="{{ $projeto->id }}"
                                                            data-status="{{ $projeto->status }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="admin-projetos-pagination-wrapper">
                            {{ $projetos->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Visualizar -->
<div class="modal fade" id="modalVisualizar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content admin-projetos-modal">
            <div class="modal-header admin-projetos-modal-header-info">
                <h5 class="modal-title text-light d-flex align-items-center gap-2">
                    <i class="fas fa-eye"></i> Detalhes do Projeto
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body admin-projetos-modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Usuário:</strong> <span id="projetoUsuario"></span></p>
                        <p><strong>Título:</strong> <span id="projetoTitulo"></span></p>
                        <p><strong>Data Início:</strong> <span id="projetoDataInicio"></span></p>
                        <p><strong>Data Fim:</strong> <span id="projetoDataFim"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status:</strong> <span id="projetoStatus"></span></p>
                        <p><strong>Criado em:</strong> <span id="projetoCreated"></span></p>
                        <p><strong>Última atualização:</strong> <span id="projetoUpdated"></span></p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <p><strong>Descrição:</strong></p>
                        <p id="projetoDescricao"></p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <p><strong>Resultados:</strong></p>
                        <p id="projetoResultados"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer admin-projetos-modal-footer">
                <button type="button" class="btn admin-projetos-btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Status -->
<div class="modal fade" id="modalStatus" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content admin-projetos-modal">
            <div class="modal-header admin-projetos-modal-header-primary">
                <h5 class="modal-title text-light d-flex align-items-center gap-2">
                    <i class="fas fa-edit"></i> Atualizar Status
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formStatus" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body admin-projetos-modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select admin-projetos-select" required>
                            <option value="em_andamento">Em Andamento</option>
                            <option value="concluido">Concluído</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer admin-projetos-modal-footer">
                    <button type="button" class="btn admin-projetos-btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn admin-projetos-btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal Visualizar
    const modalVisualizar = document.getElementById('modalVisualizar');
    modalVisualizar.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const projeto = JSON.parse(button.getAttribute('data-projeto'));
        
        document.getElementById('projetoUsuario').textContent = projeto.user.name;
        document.getElementById('projetoTitulo').textContent = projeto.titulo;
        document.getElementById('projetoDataInicio').textContent = new Date(projeto.data_inicio).toLocaleDateString();
        document.getElementById('projetoDataFim').textContent = projeto.data_fim ? new Date(projeto.data_fim).toLocaleDateString() : '-';
        document.getElementById('projetoStatus').textContent = projeto.status.replace('_', ' ');
        document.getElementById('projetoCreated').textContent = new Date(projeto.created_at).toLocaleString();
        document.getElementById('projetoUpdated').textContent = new Date(projeto.updated_at).toLocaleString();
        document.getElementById('projetoDescricao').textContent = projeto.descricao;
        document.getElementById('projetoResultados').textContent = projeto.resultados || '-';
    });

    // Modal Status
    const modalStatus = document.getElementById('modalStatus');
    modalStatus.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const status = button.getAttribute('data-status');
        
        const form = document.getElementById('formStatus');
        form.action = `/admin/projetos-individuais/${id}`;
        form.querySelector('[name="status"]').value = status;
    });
});
</script>
@endsection 