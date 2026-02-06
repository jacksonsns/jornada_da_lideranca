@extends('layouts.app-admin')

@section('title', 'Capacitações - Admin')

@push('styles')
<script src="https://cdn.tiny.cloud/1/arnqtux8mc5e5tdi0zd5osuhx5epskldqa6ntewso2cha78x/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<style>
    .caps-admin-shell {
        min-height: 100vh;
        padding: 32px 16px;
        background: radial-gradient(circle at top left, rgba(88, 101, 242, 0.22), transparent 55%),
                    radial-gradient(circle at bottom right, rgba(56, 189, 248, 0.18), transparent 55%),
                    linear-gradient(135deg, #020617 0%, #020617 40%, #020617 100%);
        display: flex;
        align-items: stretch;
    }

    .caps-admin-shell-inner {
        width: 100%;
        max-width: 1240px;
        margin: 0 auto;
    }

    .caps-admin-card {
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

    .caps-admin-header {
        padding: 20px 24px 18px;
        background:
            linear-gradient(120deg, rgba(37, 99, 235, 0.97), rgba(79, 70, 229, 0.97));
        border-bottom: 1px solid rgba(148, 163, 184, 0.55);
    }

    .caps-admin-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #e5f0ff;
        letter-spacing: 0.01em;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .caps-admin-title i {
        color: #bfdbfe;
    }

    .caps-admin-subtitle {
        font-size: 0.86rem;
        color: rgba(226, 232, 240, 0.85);
        margin: 0;
    }

    .caps-admin-cta {
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

    .caps-admin-cta:hover {
        transform: translateY(-1px) scale(1.01);
        box-shadow: 0 18px 55px rgba(37, 99, 235, 0.85);
        color: #ffffff;
    }

    .caps-admin-cta i {
        font-size: 0.9rem;
    }

    .caps-admin-card-body {
        padding: 18px 22px 22px;
    }

    .caps-admin-alert {
        border-radius: 999px;
        border: 1px solid rgba(34, 197, 94, 0.5);
        background: radial-gradient(circle at top left, rgba(22, 163, 74, 0.18), transparent 60%),
                    rgba(15, 23, 42, 0.9);
        color: #bbf7d0;
    }

    .caps-admin-table-wrapper {
        border-radius: 18px;
        border: 1px solid rgba(148, 163, 184, 0.35);
        overflow: hidden;
        background:
            radial-gradient(circle at top left, rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.98));
    }

    .caps-admin-table {
        color: #e5e7eb;
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
        background-color: transparent;
    }

    .caps-admin-table thead {
        background:
            linear-gradient(120deg, rgba(15, 23, 42, 0.96), rgba(30, 64, 175, 0.98));
    }

    .caps-admin-table thead th {
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

    .caps-admin-table tbody tr {
        transition: all 0.14s ease-out;
        background: rgba(15, 23, 42, 0.9);
    }

    .caps-admin-table tbody tr:nth-child(even) {
        background: rgba(15, 23, 42, 0.96);
    }

    .caps-admin-table tbody tr:hover {
        background: linear-gradient(90deg, rgba(30, 64, 175, 0.72), rgba(15, 23, 42, 0.98));
        transform: translateY(-1px);
    }

    .caps-admin-table tbody td {
        border-top: 1px solid rgba(30, 64, 175, 0.5);
        padding: 9px 14px;
        font-size: 0.88rem;
        vertical-align: middle;
    }

    .caps-admin-table-actions .btn {
        min-width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: 0;
        border: 1px solid transparent;
    }

    .caps-admin-btn-edit {
        background: linear-gradient(135deg, #0ea5e9, #2563eb);
        border-color: rgba(191, 219, 254, 0.8);
        color: #eff6ff;
        box-shadow: 0 10px 26px rgba(37, 99, 235, 0.55);
        font-size: 0.82rem;
        transition: all 0.16s ease-out;
    }

    .caps-admin-btn-delete {
        background: linear-gradient(135deg, #f97316, #dc2626);
        border-color: rgba(254, 202, 202, 0.9);
        color: #fef2f2;
        box-shadow: 0 10px 26px rgba(220, 38, 38, 0.55);
        font-size: 0.82rem;
        transition: all 0.16s ease-out;
    }

    .caps-admin-btn-edit:hover,
    .caps-admin-btn-delete:hover {
        transform: translateY(-1px) scale(1.03);
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.85);
        color: #ffffff;
    }

    /* Modal */
    .caps-admin-modal-content {
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

    .caps-admin-modal-header {
        background: linear-gradient(120deg, rgba(37, 99, 235, 0.98), rgba(79, 70, 229, 0.98));
        border-bottom: 1px solid rgba(148, 163, 184, 0.7);
        padding: 14px 18px;
        color: #eff6ff;
    }

    .caps-admin-modal-header i {
        color: #dbeafe;
    }

    .caps-admin-modal-body {
        padding: 18px 20px 16px;
    }

    .caps-admin-modal-footer {
        border-top: 1px solid rgba(148, 163, 184, 0.6);
        padding: 12px 18px 14px;
        background: rgba(15, 23, 42, 0.92);
    }

    .caps-admin-input {
        background: rgba(15, 23, 42, 0.9);
        border-radius: 999px;
        border: 1px solid rgba(148, 163, 184, 0.7);
        color: #e5e7eb;
        font-size: 0.9rem;
        padding: 8px 14px;
    }

    .caps-admin-input:focus {
        background: rgba(15, 23, 42, 0.98);
        border-color: rgba(59, 130, 246, 0.9);
        box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.9);
        color: #f9fafb;
    }

    textarea.caps-admin-input {
        border-radius: 18px;
        min-height: 120px;
        resize: vertical;
    }

    .caps-admin-btn-primary {
        border-radius: 999px;
        padding: 7px 18px;
        font-size: 0.88rem;
        font-weight: 600;
        border: 1px solid rgba(191, 219, 254, 0.8);
        background: linear-gradient(135deg, #0ea5e9, #22c55e);
        color: #f9fafb;
        box-shadow: 0 12px 30px rgba(34, 197, 94, 0.7);
        transition: all 0.16s ease-out;
    }

    .caps-admin-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 16px 40px rgba(34, 197, 94, 0.9);
        color: #ffffff;
    }

    .caps-admin-btn-secondary {
        border-radius: 999px;
        padding: 7px 16px;
        font-size: 0.86rem;
        font-weight: 500;
        border: 1px solid rgba(148, 163, 184, 0.7);
        background: rgba(15, 23, 42, 0.8);
        color: rgba(209, 213, 219, 0.9);
        transition: all 0.16s ease-out;
    }

    .caps-admin-btn-secondary:hover {
        background: rgba(15, 23, 42, 0.95);
        color: #e5e7eb;
    }

    .caps-admin-file-help {
        color: rgba(248, 250, 252, 0.82) !important;
    }

    @media (max-width: 991.98px) {
        .caps-admin-shell {
            padding: 18px 10px 24px;
        }

        .caps-admin-card {
            border-radius: 22px;
        }

        .caps-admin-header {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 10px;
        }
    }

    @media (max-width: 575.98px) {
        .caps-admin-card-body {
            padding: 14px 12px 16px;
        }

        .caps-admin-table thead th,
        .caps-admin-table tbody td {
            padding: 8px 8px;
        }

        .caps-admin-shell {
            padding-top: 16px;
        }
    }
</style>
@endpush

@section('content')
<div class="caps-admin-shell">
    <div class="caps-admin-shell-inner">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="caps-admin-card">
                    <div class="caps-admin-header d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="caps-admin-title mb-1">
                                <i class="fas fa-chalkboard-teacher"></i>
                                Capacitações
                            </h3>
                            <p class="caps-admin-subtitle">Gerencie as capacitações, materiais e insights dos encontros.</p>
                        </div>
                        <button type="button" class="btn caps-admin-cta" data-bs-toggle="modal" data-bs-target="#addCapacitacaoModal">
                            <i class="fas fa-plus"></i>
                            Nova Capacitação
                        </button>
                    </div>
                    <div class="caps-admin-card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show caps-admin-alert" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive caps-admin-table-wrapper mt-2">
                            <table class="table table-hover mb-0 caps-admin-table">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Título</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($capacitacoes as $capacitacao)
                                        <tr>
                                            <td>{{ $capacitacao->data->format('d/m/Y') }}</td>
                                            <td>{{ $capacitacao->titulo }}</td>
                                            <td>
                                                @php
                                                    $data = $capacitacao->data->format('Y-m-d');
                                                    $titulo = $capacitacao->titulo;
                                                    $insights = json_encode($capacitacao->insights);
                                                @endphp

                                                <div class="d-flex justify-content-center gap-2 caps-admin-table-actions">
                                                    <button type="button" class="btn btn-sm caps-admin-btn-edit"
                                                        onclick="editarCapacitacao({{ $capacitacao->id }}, '{{ $data }}', '{{ addslashes($titulo) }}', {{ $insights }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('admin.capacitacoes.destroy', $capacitacao->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm caps-admin-btn-delete" onclick="return confirm('Tem certeza que deseja excluir esta capacitação?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4">Nenhuma capacitação registrada.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Adicionar/Editar Capacitação -->
<div class="modal fade" id="addCapacitacaoModal" tabindex="-1" aria-labelledby="addCapacitacaoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content caps-admin-modal-content">
            <div class="modal-header caps-admin-modal-header">
                <h5 class="modal-title d-flex align-items-center gap-2" id="addCapacitacaoModalLabel">
                    <i class="fas fa-calendar-plus"></i>
                    Nova Capacitação
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form id="capacitacaoForm" action="{{ route('admin.capacitacoes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="POST">
                <div class="modal-body caps-admin-modal-body">
                    <div class="mb-3">
                        <label for="data" class="form-label">Data da Capacitação</label>
                        <input type="date" class="form-control caps-admin-input" id="data" name="data" required>
                    </div>
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control caps-admin-input" id="titulo" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="insights" class="form-label">Insights</label>
                        <textarea class="form-control tinymce caps-admin-input" id="insights" name="insights" rows="10"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Material</label>
                        <input type="file" name="material" class="form-control caps-admin-input" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.rar">
                        <small class="text-danger caps-admin-file-help">Formatos aceitos: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, RAR (máx. 10MB)</small>
                    </div>
                </div>
                <div class="modal-footer caps-admin-modal-footer">
                    <button type="button" class="btn caps-admin-btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn caps-admin-btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    tinymce.init({
        selector: '.tinymce',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        height: 300,
        language: 'pt_BR',
        skin: 'oxide',
    });

    function editarCapacitacao(id, data, titulo, insights) {
        const form = document.getElementById('capacitacaoForm');
        const modalTitle = document.getElementById('addCapacitacaoModalLabel');
        
        form.action = `{{ route('admin.capacitacoes.index') }}/${id}`;
        form.querySelector('input[name="_method"]').value = 'PUT';
        
        document.getElementById('data').value = data;
        document.getElementById('titulo').value = titulo;
        tinymce.get('insights').setContent(insights);
        
        modalTitle.textContent = 'Editar Capacitação';
        
        new bootstrap.Modal(document.getElementById('addCapacitacaoModal')).show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('addCapacitacaoModal');
        modal.addEventListener('hidden.bs.modal', function() {
            const form = document.getElementById('capacitacaoForm');
            form.reset();
            form.action = "{{ route('admin.capacitacoes.store') }}";
            form.querySelector('input[name="_method"]').value = 'POST';
            tinymce.get('insights').setContent('');
            document.getElementById('addCapacitacaoModalLabel').textContent = 'Nova Capacitação';
        });
    });
</script>
@endpush
@endsection