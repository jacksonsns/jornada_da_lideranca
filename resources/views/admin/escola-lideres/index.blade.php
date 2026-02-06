@extends('layouts.app-admin')

@section('title', 'Gerenciar Módulos - Escola de Líderes')

@section('content')
<div class="admin-escola-shell">
    <div class="admin-escola-shell-inner">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card admin-escola-card shadow-lg border-0">
                    <div class="card-header admin-escola-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 admin-escola-header-title">
                                <i class="fas fa-graduation-cap me-2"></i>
                                Gerenciar Módulos - Escola de Líderes
                            </h4>
                            <p class="mb-0 admin-escola-header-subtitle">
                                Organize, edite e acompanhe os módulos da Escola de Líderes.
                            </p>
                        </div>
                        <button type="button" class="btn admin-escola-cta" data-bs-toggle="modal" data-bs-target="#modalCriar">
                            <span class="admin-escola-cta-icon-wrapper me-1">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="admin-escola-cta-label">Novo Módulo</span>
                        </button>
                    </div>
                    <div class="card-body admin-escola-card-body">
                        <div class="table-responsive admin-escola-table-wrapper">
                            <table class="table mb-0 admin-escola-table">
                                <thead>
                                    <tr>
                                        <th>Ordem</th>
                                        <th>Título</th>
                                        <th>Descrição</th>
                                        <th>Aulas</th>
                                        <th>Material</th>
                                        <th class="text-center" width="150">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($modulos as $modulo)
                                        <tr>
                                            <td class="align-middle">{{ $modulo->ordem }}</td>
                                            <td class="align-middle fw-semibold">{{ $modulo->titulo }}</td>
                                            <td class="align-middle admin-escola-text-truncate">{{ Str::limit($modulo->descricao, 100) }}</td>
                                            <td class="align-middle">
                                                <span class="badge admin-escola-badge-pill">
                                                    {{ $modulo->aulas_count }} aulas
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                @if($modulo->material_url)
                                                    <a href="{{ $modulo->material_url }}" target="_blank" class="btn btn-sm admin-escola-btn-download">
                                                        <i class="fas fa-download me-1"></i>
                                                        Baixar
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex justify-content-center gap-2 admin-escola-table-actions">
                                                    <button type="button" class="btn btn-sm admin-escola-btn-action edit" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalEditar"
                                                            data-modulo="{{ $modulo }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm admin-escola-btn-action delete" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalExcluir"
                                                            data-modulo="{{ $modulo }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="admin-escola-pagination-wrapper mt-3">
                            {{ $modulos->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Criar -->
<div class="modal fade" id="modalCriar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content admin-escola-modal">
            <div class="modal-header admin-escola-modal-header">
                <h5 class="modal-title text-light d-flex align-items-center">
                    <i class="fas fa-plus me-2"></i> Novo Módulo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formCriar" action="{{ route('admin.escola-lideres.store') }}" method="POST">
                @csrf
                <div class="modal-body admin-escola-modal-body">
                    <div class="mb-3">
                        <label class="form-label">Ordem</label>
                        <input type="number" name="ordem" class="form-control admin-escola-input" required min="1">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" name="titulo" class="form-control admin-escola-input" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control admin-escola-input" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">URL do Material</label>
                        <input type="url" name="material_url" class="form-control admin-escola-input">
                    </div>
                </div>
                <div class="modal-footer admin-escola-modal-footer">
                    <button type="button" class="btn admin-escola-btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn admin-escola-btn-primary">Criar Módulo</button>
                </div>
            </form>
        </div>
    </div>
    </div>

<!-- Modal Editar -->
<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content admin-escola-modal">
            <div class="modal-header admin-escola-modal-header">
                <h5 class="modal-title d-flex align-items-center">
                    <i class="fas fa-edit me-2"></i> Editar Módulo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditar" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body admin-escola-modal-body">
                    <div class="mb-3">
                        <label class="form-label">Ordem</label>
                        <input type="number" name="ordem" class="form-control admin-escola-input" required min="1">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" name="titulo" class="form-control admin-escola-input" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control admin-escola-input" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">URL do Material</label>
                        <input type="url" name="material_url" class="form-control admin-escola-input">
                    </div>
                </div>
                <div class="modal-footer admin-escola-modal-footer">
                    <button type="button" class="btn admin-escola-btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn admin-escola-btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Excluir -->
<div class="modal fade" id="modalExcluir" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content admin-escola-modal admin-escola-modal-danger">
            <div class="modal-header admin-escola-modal-header-danger">
                <h5 class="modal-title d-flex align-items-center">
                    <i class="fas fa-trash me-2"></i> Excluir Módulo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body admin-escola-modal-body">
                <p class="mb-2">Tem certeza que deseja excluir este módulo?</p>
                <p class="mb-0"><strong>Título:</strong> <span id="moduloTitulo"></span></p>
            </div>
            <div class="modal-footer admin-escola-modal-footer">
                <form id="formExcluir" method="POST" class="w-100 d-flex justify-content-between">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn admin-escola-btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn admin-escola-btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .admin-escola-shell {
        min-height: 100vh;
        padding: 32px 16px;
        background: radial-gradient(circle at top left, rgba(88, 101, 242, 0.22), transparent 55%),
                    radial-gradient(circle at bottom right, rgba(56, 189, 248, 0.18), transparent 55%),
                    linear-gradient(135deg, #020617 0%, #020617 40%, #020617 100%);
        display: flex;
        align-items: stretch;
    }

    .admin-escola-shell-inner {
        width: 100%;
        max-width: 1240px;
        margin: 0 auto;
    }

    .admin-escola-card {
        border-radius: 26px;
        overflow: hidden;
        background:
            radial-gradient(circle at top left, rgba(56, 189, 248, 0.22), transparent 60%),
            radial-gradient(circle at bottom right, rgba(59, 130, 246, 0.25), transparent 60%),
            linear-gradient(135deg, rgba(15, 23, 42, 0.92), rgba(15, 23, 42, 0.96));
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border: 1px solid rgba(148, 163, 184, 0.4);
        box-shadow: 0 24px 80px rgba(15, 23, 42, 0.9);
    }

    .admin-escola-header {
        padding: 20px 24px 18px;
        background:
            linear-gradient(120deg, rgba(37, 99, 235, 0.95), rgba(79, 70, 229, 0.95));
        border-bottom: 1px solid rgba(148, 163, 184, 0.4);
    }

    .admin-escola-header-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #e5f0ff;
        letter-spacing: 0.01em;
    }

    .admin-escola-header-title i {
        color: #bfdbfe;
    }

    .admin-escola-header-subtitle {
        font-size: 0.86rem;
        color: rgba(226, 232, 240, 0.85);
    }

    .admin-escola-cta {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 9px 18px;
        border-radius: 999px;
        border: 1px solid rgba(226, 232, 240, 0.5);
        background: radial-gradient(circle at top left, rgba(248, 250, 252, 0.28), transparent 55%),
                    linear-gradient(135deg, #0ea5e9, #2563eb);
        color: #f9fafb;
        font-weight: 600;
        font-size: 0.88rem;
        box-shadow: 0 14px 40px rgba(37, 99, 235, 0.6);
        transition: all 0.18s ease-out;
    }

    .admin-escola-cta:hover {
        transform: translateY(-1px) scale(1.01);
        box-shadow: 0 18px 55px rgba(37, 99, 235, 0.85);
        color: #ffffff;
    }

    .admin-escola-cta-icon-wrapper {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        border-radius: 999px;
        background: rgba(15, 23, 42, 0.22);
    }

    .admin-escola-cta i {
        font-size: 0.9rem;
        color: #f9fafb;
    }

    .admin-escola-cta-label {
        white-space: nowrap;
    }

    .admin-escola-card-body {
        padding: 18px 22px 22px;
    }

    .admin-escola-table-wrapper {
        border-radius: 18px;
        border: 1px solid rgba(148, 163, 184, 0.35);
        overflow: hidden;
        background:
            radial-gradient(circle at top left, rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.98));
    }

    .admin-escola-table {
        color: #e5e7eb;
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
        background-color: transparent;
    }

    .admin-escola-table thead {
        background:
            linear-gradient(120deg, rgba(15, 23, 42, 0.95), rgba(30, 64, 175, 0.98));
    }

    .admin-escola-table thead th {
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

    .admin-escola-table tbody tr {
        transition: all 0.14s ease-out;
        background: rgba(15, 23, 42, 0.9);
    }

    .admin-escola-table tbody tr:nth-child(even) {
        background: rgba(15, 23, 42, 0.96);
    }

    .admin-escola-table tbody tr:hover {
        background: linear-gradient(90deg, rgba(30, 64, 175, 0.72), rgba(15, 23, 42, 0.98));
        transform: translateY(-1px);
    }

    .admin-escola-table tbody td {
        border-top: 1px solid rgba(30, 64, 175, 0.5);
        padding: 9px 14px;
        font-size: 0.88rem;
        vertical-align: middle;
    }

    .admin-escola-text-truncate {
        max-width: 360px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: rgba(209, 213, 219, 0.92);
    }

    .admin-escola-badge-pill {
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 0.72rem;
        font-weight: 600;
        background: rgba(22, 163, 74, 0.12);
        color: #bbf7d0;
        border: 1px solid rgba(34, 197, 94, 0.45);
    }

    .admin-escola-btn-download {
        border-radius: 999px;
        padding: 5px 12px;
        border: 1px solid rgba(250, 204, 21, 0.7);
        background: radial-gradient(circle at top left, rgba(250, 250, 250, 0.04), transparent 55%),
                    linear-gradient(135deg, #facc15, #ea580c);
        color: #111827;
        font-size: 0.8rem;
        font-weight: 600;
        box-shadow: 0 10px 26px rgba(234, 179, 8, 0.45);
        transition: all 0.16s ease-out;
    }

    .admin-escola-btn-download i {
        font-size: 0.8rem;
    }

    .admin-escola-btn-download:hover {
        transform: translateY(-1px);
        box-shadow: 0 14px 32px rgba(234, 179, 8, 0.65);
        color: #020617;
    }

    .admin-escola-table-actions .btn {
        min-width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: 0;
        border: 1px solid transparent;
    }

    .admin-escola-btn-action {
        font-size: 0.82rem;
        transition: all 0.16s ease-out;
    }

    .admin-escola-btn-action.edit {
        background: linear-gradient(135deg, #0ea5e9, #2563eb);
        border-color: rgba(191, 219, 254, 0.8);
        color: #eff6ff;
        box-shadow: 0 10px 26px rgba(37, 99, 235, 0.55);
    }

    .admin-escola-btn-action.delete {
        background: linear-gradient(135deg, #f97316, #dc2626);
        border-color: rgba(254, 202, 202, 0.9);
        color: #fef2f2;
        box-shadow: 0 10px 26px rgba(220, 38, 38, 0.55);
    }

    .admin-escola-btn-action:hover {
        transform: translateY(-1px) scale(1.03);
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.85);
        color: #ffffff;
    }

    .admin-escola-pagination-wrapper {
        display: flex;
        justify-content: center;
    }

    .admin-escola-pagination-wrapper nav {
        background: rgba(15, 23, 42, 0.7);
        padding: 6px 14px;
        border-radius: 999px;
        border: 1px solid rgba(148, 163, 184, 0.5);
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.7);
    }

    .admin-escola-pagination-wrapper .page-link {
        background: transparent;
        border: none;
        color: rgba(209, 213, 219, 0.9);
        font-size: 0.82rem;
        padding: 6px 10px;
        border-radius: 999px !important;
    }

    .admin-escola-pagination-wrapper .page-item.active .page-link {
        background: linear-gradient(135deg, #0ea5e9, #2563eb);
        color: #f9fafb;
    }

    .admin-escola-pagination-wrapper .page-link:hover {
        background: rgba(30, 64, 175, 0.8);
        color: #e5e7eb;
    }

    /* Modais */
    .admin-escola-modal {
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

    .admin-escola-modal-header {
        background: linear-gradient(120deg, rgba(37, 99, 235, 0.98), rgba(79, 70, 229, 0.98));
        border-bottom: 1px solid rgba(148, 163, 184, 0.7);
        padding: 14px 18px;
        color: #eff6ff;
    }

    .admin-escola-modal-header i {
        color: #dbeafe;
    }

    .admin-escola-modal-body {
        padding: 18px 20px 16px;
    }

    .admin-escola-modal-footer {
        border-top: 1px solid rgba(148, 163, 184, 0.6);
        padding: 12px 18px 14px;
        background: rgba(15, 23, 42, 0.92);
    }

    .admin-escola-input {
        background: rgba(15, 23, 42, 0.9);
        border-radius: 999px;
        border: 1px solid rgba(148, 163, 184, 0.7);
        color: #e5e7eb;
        font-size: 0.9rem;
        padding: 8px 14px;
    }

    .admin-escola-input:focus {
        background: rgba(15, 23, 42, 0.98);
        border-color: rgba(59, 130, 246, 0.9);
        box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.9);
        color: #f9fafb;
    }

    textarea.admin-escola-input {
        border-radius: 18px;
        min-height: 90px;
        resize: vertical;
    }

    .admin-escola-btn-primary {
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

    .admin-escola-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 16px 40px rgba(37, 99, 235, 0.9);
        color: #ffffff;
    }

    .admin-escola-btn-secondary {
        border-radius: 999px;
        padding: 7px 16px;
        font-size: 0.86rem;
        font-weight: 500;
        border: 1px solid rgba(148, 163, 184, 0.7);
        background: rgba(15, 23, 42, 0.8);
        color: rgba(209, 213, 219, 0.9);
        transition: all 0.16s ease-out;
    }

    .admin-escola-btn-secondary:hover {
        background: rgba(15, 23, 42, 0.95);
        color: #e5e7eb;
    }

    .admin-escola-modal-danger {
        border-color: rgba(248, 113, 113, 0.8);
    }

    .admin-escola-modal-header-danger {
        background: linear-gradient(120deg, rgba(239, 68, 68, 0.96), rgba(248, 113, 113, 0.96));
        border-bottom: 1px solid rgba(254, 202, 202, 0.85);
        padding: 14px 18px;
        color: #fef2f2;
    }

    .admin-escola-btn-danger {
        border-radius: 999px;
        padding: 7px 18px;
        font-size: 0.88rem;
        font-weight: 600;
        border: 1px solid rgba(254, 202, 202, 0.9);
        background: linear-gradient(135deg, #f97316, #dc2626);
        color: #fef2f2;
        box-shadow: 0 12px 32px rgba(220, 38, 38, 0.8);
        transition: all 0.16s ease-out;
    }

    .admin-escola-btn-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 18px 40px rgba(185, 28, 28, 0.9);
        color: #fef2f2;
    }

    @media (max-width: 991.98px) {
        .admin-escola-shell {
            padding: 18px 10px 24px;
        }

        .admin-escola-card {
            border-radius: 22px;
        }

        .admin-escola-header {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 10px;
        }

        .admin-escola-cta {
            align-self: flex-start;
        }

        .admin-escola-text-truncate {
            max-width: 220px;
        }
    }

    @media (max-width: 575.98px) {
        .admin-escola-card-body {
            padding: 14px 12px 16px;
        }

        .admin-escola-table thead th,
        .admin-escola-table tbody td {
            padding: 8px 8px;
        }

        .admin-escola-shell {
            padding-top: 16px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form Criar
    const formCriar = document.getElementById('formCriar');
    formCriar.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: 'Ocorreu um erro ao criar o módulo.'
            });
        });
    });

    // Modal Editar
    const modalEditar = document.getElementById('modalEditar');
    modalEditar.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const modulo = JSON.parse(button.dataset.modulo);
        const form = this.querySelector('form');
        
        form.action = `/admin/escola-lideres/${modulo.id}`;
        form.querySelector('[name="ordem"]').value = modulo.ordem;
        form.querySelector('[name="titulo"]').value = modulo.titulo;
        form.querySelector('[name="descricao"]').value = modulo.descricao;
        form.querySelector('[name="material_url"]').value = modulo.material_url;
    });

    // Form Editar
    const formEditar = document.getElementById('formEditar');
    formEditar.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: 'Ocorreu um erro ao atualizar o módulo.'
            });
        });
    });

    // Modal Excluir
    const modalExcluir = document.getElementById('modalExcluir');
    modalExcluir.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const modulo = JSON.parse(button.dataset.modulo);
        const form = this.querySelector('form');
        
        form.action = `/admin/escola-lideres/${modulo.id}`;
        document.getElementById('moduloTitulo').textContent = modulo.titulo;
    });

    // Form Excluir
    const formExcluir = document.getElementById('formExcluir');
    formExcluir.addEventListener('submit', function(e) {
        e.preventDefault();

        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: 'Ocorreu um erro ao excluir o módulo.'
            });
        });
    });
});
</script>
@endpush 