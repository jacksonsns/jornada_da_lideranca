@extends('layouts.app-admin')

@section('content')
@push('styles')
<style>
    .admin-desafios-shell {
        padding: 2.2rem 1.9rem 2rem;
        background:
            radial-gradient(circle at 0 0, rgba(59,130,246,0.40), transparent 55%),
            radial-gradient(circle at 100% 100%, rgba(56,189,248,0.32), transparent 55%),
            linear-gradient(135deg,#020617 0%,#020617 40%,#02061b 100%);
        border-radius: 26px;
        box-shadow: 0 26px 70px rgba(0,0,0,0.95);
    }

    .admin-desafios-header-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #e5edff;
    }

    .admin-desafios-header-subtitle {
        font-size: 0.9rem;
        color: #9ca3af;
    }

    .admin-desafios-cta {
        border-radius: 999px;
        border: none;
        padding: 0.45rem 1.2rem;
        font-size: 0.9rem;
        font-weight: 600;
        background: linear-gradient(135deg,#1d4ed8,#6366f1);
        box-shadow: 0 16px 40px rgba(15,23,42,0.9);
        color: #ffffff !important;
    }

    .admin-desafios-cta i {
        margin-right: 0.35rem;
    }

    .admin-desafios-card {
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

    .admin-desafios-card .card-body {
        padding: 1.3rem 1.4rem 1.4rem;
    }

    .admin-desafios-table-wrapper table {
        color: #e5e7eb;
        margin-bottom: 0;
    }

    .admin-desafios-table-wrapper thead {
        background: linear-gradient(135deg,rgba(15,23,42,0.98),rgba(30,64,175,0.95));
    }

    .admin-desafios-table-wrapper thead th {
        border-bottom: none;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #9ca3af;
    }

    .admin-desafios-table-wrapper tbody tr {
        background-color: transparent;
        transition: background-color .16s ease, transform .16s ease;
    }

    .admin-desafios-table-wrapper tbody tr:hover {
        background-color: rgba(30,64,175,0.18);
        transform: translateY(-1px);
    }

    .admin-desafios-table-wrapper tbody td {
        border-top-color: rgba(55,65,81,0.9);
        font-size: 0.9rem;
    }

    .admin-desafios-table-actions .btn {
        border-radius: 999px;
        padding: 0.25rem 0.55rem;
        font-size: 0.8rem;
    }

    .admin-desafios-pagination {
        margin-top: 1.2rem;
    }

    @media (max-width: 767.98px) {
        .admin-desafios-shell {
            padding: 1.6rem 1.1rem 1.6rem;
        }

        .admin-desafios-header-title {
            font-size: 1.3rem;
        }
    }
</style>
@endpush

<div class="container-fluid py-4">
    <div class="admin-desafios-shell">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h1 class="admin-desafios-header-title mb-1">Gerenciar Desafios</h1>
                <p class="admin-desafios-header-subtitle mb-0">Crie, edite e acompanhe os desafios ativos.</p>
            </div>
            <div>
                <button type="button" class="btn admin-desafios-cta" data-bs-toggle="modal" data-bs-target="#createDesafioModal">
                    <i class="fas fa-plus"></i> Novo Desafio
                </button>
            </div>
        </div>

        <div class="card admin-desafios-card mb-0">
            <div class="card-body">
                <div class="table-responsive admin-desafios-table-wrapper">
                <table class="table table-bordered" id="desafiosTable">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Pontos</th>
                            <th>Participantes</th>
                            <th>Concluídos</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($desafios as $desafio)
                        <tr>
                            <td>{{ $desafio->titulo }}</td>
                            <td>{{ $desafio->pontos }}</td>
                            <td>{{ $desafio->users_count }}</td>
                            <td>{{ $desafio->users->count() }}</td>
                            <td class="admin-desafios-table-actions">
                                <button type="button" class="btn btn-sm btn-info edit-desafio" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editDesafioModal"
                                    data-desafio="{{ $desafio->id }}"
                                    data-titulo="{{ $desafio->titulo }}"
                                    data-descricao="{{ $desafio->descricao }}"
                                    data-pontos="{{ $desafio->pontos }}"
                                    data-prazo="{{ $desafio->prazo ? $desafio->prazo->format('Y-m-d') : '' }}"
                                    data-tipo="{{ $desafio->tipo }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger delete-desafio"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteDesafioModal"
                                    data-desafio="{{ $desafio->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center admin-desafios-pagination">
                {{ $desafios->links() }}
            </div>
        </div>
        </div>
    </div>
</div>

<!-- Modal Criar Desafio -->
<div class="modal fade" id="createDesafioModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Desafio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createDesafioForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="pontos" class="form-label">Pontos</label>
                        <input type="number" class="form-control" id="pontos" name="pontos" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="prazo" class="form-label">Prazo</label>
                        <input type="date" class="form-control" id="prazo" name="prazo">
                    </div>
                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-select" id="tipo" name="tipo" required>
                            <option value="diario">Diário</option>
                            <option value="semanal">Semanal</option>
                            <option value="mensal">Mensal</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Criar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Desafio -->
<div class="modal fade" id="editDesafioModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Desafio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editDesafioForm">
                <div class="modal-body">
                    <input type="hidden" id="edit_desafio_id" name="desafio_id">
                    <div class="mb-3">
                        <label for="edit_titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="edit_titulo" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="edit_descricao" name="descricao" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_pontos" class="form-label">Pontos</label>
                        <input type="number" class="form-control" id="edit_pontos" name="pontos" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_prazo" class="form-label">Prazo</label>
                        <input type="date" class="form-control" id="edit_prazo" name="prazo">
                    </div>
                    <div class="mb-3">
                        <label for="edit_tipo" class="form-label">Tipo</label>
                        <select class="form-select" id="edit_tipo" name="tipo" required>
                            <option value="diario">Diário</option>
                            <option value="semanal">Semanal</option>
                            <option value="mensal">Mensal</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Excluir Desafio -->
<div class="modal fade" id="deleteDesafioModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir este desafio?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Excluir</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Configurar o token CSRF globalmente
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Criar Desafio
    $('#createDesafioForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("admin.desafios.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    $('#createDesafioModal').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr) {
                alert('Erro ao criar desafio');
                console.log(xhr.responseText);
            }
        });
    });

    // Editar Desafio
    $('.edit-desafio').click(function() {
        const data = $(this).data();
        $('#edit_desafio_id').val(data.desafio);
        $('#edit_titulo').val(data.titulo);
        $('#edit_descricao').val(data.descricao);
        $('#edit_pontos').val(data.pontos);
        $('#edit_prazo').val(data.prazo);
        $('#edit_tipo').val(data.tipo);
    });

    $('#editDesafioForm').on('submit', function(e) {
        e.preventDefault();
        const desafioId = $('#edit_desafio_id').val();

        $.ajax({
            url: `/admin/desafios/${desafioId}`,
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    $('#editDesafioModal').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr) {
                alert('Erro ao atualizar desafio');
                console.log(xhr.responseText);
            }
        });
    });

    // Excluir Desafio
    let desafioToDelete = null;

    $('.delete-desafio').click(function() {
        desafioToDelete = $(this).data('desafio');
    });

    $('#confirmDelete').click(function() {
        if(desafioToDelete) {
            $.ajax({
                url: `/admin/desafios/${desafioToDelete}`,
                method: 'DELETE',
                success: function(response) {
                    if(response.success) {
                        $('#deleteDesafioModal').modal('hide');
                        location.reload();
                    }
                },
                error: function(xhr) {
                    alert('Erro ao excluir desafio');
                    console.log(xhr.responseText);
                }
            });
        }
    });
});
</script>
@endpush
@endsection
