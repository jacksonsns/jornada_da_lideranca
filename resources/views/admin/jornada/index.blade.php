@extends('layouts.app-admin')

@section('content')
@push('styles')
<style>
    .admin-jornada-shell {
        padding: 2.2rem 1.9rem 2rem;
        background:
            radial-gradient(circle at 0 0, rgba(59,130,246,0.40), transparent 55%),
            radial-gradient(circle at 100% 100%, rgba(56,189,248,0.32), transparent 55%),
            linear-gradient(135deg,#020617 0%,#020617 40%,#02061b 100%);
        border-radius: 26px;
        box-shadow: 0 26px 70px rgba(0,0,0,0.95);
    }

    .admin-jornada-header-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #e5edff;
    }

    .admin-jornada-header-subtitle {
        font-size: 0.9rem;
        color: #9ca3af;
    }

    .admin-jornada-cta {
        border-radius: 999px;
        border: none;
        padding: 0.45rem 1.2rem;
        font-size: 0.9rem;
        font-weight: 600;
        background: linear-gradient(135deg,#1d4ed8,#6366f1);
        box-shadow: 0 16px 40px rgba(15,23,42,0.9);
        color: #ffffff !important;
    }

    .admin-jornada-cta i {
        margin-right: 0.35rem;
    }

    .admin-jornada-card {
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

    .admin-jornada-card .card-body {
        padding: 1.3rem 1.4rem 1.4rem;
    }

    .admin-jornada-table-wrapper table {
        color: #e5e7eb;
        margin-bottom: 0;
    }

    .admin-jornada-table-wrapper thead {
        background: linear-gradient(135deg,rgba(15,23,42,0.98),rgba(30,64,175,0.95));
    }

    .admin-jornada-table-wrapper thead th {
        border-bottom: none;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #9ca3af;
    }

    .admin-jornada-table-wrapper tbody tr {
        background-color: transparent;
        transition: background-color .16s ease, transform .16s ease;
    }

    .admin-jornada-table-wrapper tbody tr:hover {
        background-color: rgba(30,64,175,0.18);
        transform: translateY(-1px);
    }

    .admin-jornada-table-wrapper tbody td {
        border-top-color: rgba(55,65,81,0.9);
        font-size: 0.9rem;
    }

    .admin-jornada-table-actions .btn {
        border-radius: 999px;
        padding: 0.25rem 0.55rem;
        font-size: 0.8rem;
    }

    .admin-jornada-status.badge {
        padding: 0.35rem 0.7rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .admin-jornada-pagination {
        margin-top: 1.2rem;
    }

    @media (max-width: 767.98px) {
        .admin-jornada-shell {
            padding: 1.6rem 1.1rem 1.6rem;
        }

        .admin-jornada-header-title {
            font-size: 1.3rem;
        }
    }
</style>
@endpush

<div class="container-fluid py-4">
    <div class="admin-jornada-shell">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h1 class="admin-jornada-header-title mb-1">Gerenciar Jornada do Aspirante</h1>
                <p class="admin-jornada-header-subtitle mb-0">Defina e organize as etapas da jornada.</p>
            </div>
            <div>
                <button type="button" class="btn admin-jornada-cta" data-bs-toggle="modal" data-bs-target="#createJornadaModal">
                    <i class="fas fa-plus"></i> Nova Jornada
                </button>
            </div>
        </div>

        <div class="card admin-jornada-card mb-0">
            <div class="card-body">
                <div class="table-responsive admin-jornada-table-wrapper">
                <table class="table table-bordered" id="jornadasTable">
                    <thead>
                        <tr>
                            <th>Ordem</th>
                            <th>Título</th>
                            <th>Pontos</th>
                            <th>Obrigatório</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jornadas as $jornada)
                        <tr>
                            <td>{{ $jornada->ordem }}</td>
                            <td>{{ $jornada->titulo }}</td>
                            <td>{{ $jornada->pontos }}</td>
                            <td>
                                <span class="badge admin-jornada-status bg-{{ $jornada->obrigatorio ? 'success' : 'warning' }}">
                                    {{ $jornada->obrigatorio ? 'Sim' : 'Não' }}
                                </span>
                            </td>
                            <td class="admin-jornada-table-actions">
                                <button type="button" class="btn btn-sm btn-info edit-jornada" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editJornadaModal"
                                    data-jornada="{{ $jornada->id }}"
                                    data-titulo="{{ $jornada->titulo }}"
                                    data-descricao="{{ $jornada->descricao }}"
                                    data-pontos="{{ $jornada->pontos }}"
                                    data-ordem="{{ $jornada->ordem }}"
                                    data-obrigatorio="{{ $jornada->obrigatorio }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger delete-jornada"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteJornadaModal"
                                    data-jornada="{{ $jornada->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center admin-jornada-pagination">
                {{ $jornadas->links() }}
            </div>
        </div>
        </div>
    </div>
</div>

<!-- Modal Criar Jornada -->
<div class="modal fade" id="createJornadaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nova Jornada</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createJornadaForm">
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
                        <input type="text" class="form-control" id="pontos" name="pontos">
                    </div>
                    <div class="mb-3">
                        <label for="ordem" class="form-label">Ordem</label>
                        <input type="number" class="form-control" id="ordem" name="ordem" min="1" required>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="obrigatorio" name="obrigatorio" value="1" checked>
                            <label class="form-check-label" for="obrigatorio">Obrigatório</label>
                        </div>
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

<!-- Modal Editar Jornada -->
<div class="modal fade" id="editJornadaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Jornada</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editJornadaForm">
                <div class="modal-body">
                    <input type="hidden" id="edit_jornada_id" name="jornada_id">
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
                        <input type="text" class="form-control" id="edit_pontos" name="pontos">
                    </div>
                    <div class="mb-3">
                        <label for="edit_ordem" class="form-label">Ordem</label>
                        <input type="number" class="form-control" id="edit_ordem" name="ordem" min="1" required>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="edit_obrigatorio" name="obrigatorio" value="1">
                            <label class="form-check-label" for="edit_obrigatorio">Obrigatório</label>
                        </div>
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

<!-- Modal Excluir Jornada -->
<div class="modal fade" id="deleteJornadaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir esta jornada?</p>
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
    // Configurar CSRF Token globalmente
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Criar Jornada
    $('#createJornadaForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("admin.jornada.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    $('#createJornadaModal').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr) {
                alert('Erro ao criar jornada');
                console.log(xhr.responseText);
            }
        });
    });

    // Editar Jornada
    $('.edit-jornada').click(function() {
        const data = $(this).data();
        $('#edit_jornada_id').val(data.jornada);
        $('#edit_titulo').val(data.titulo);
        $('#edit_descricao').val(data.descricao);
        $('#edit_pontos').val(data.pontos);
        $('#edit_ordem').val(data.ordem);
        $('#edit_obrigatorio').prop('checked', data.obrigatorio);
    });

    $('#editJornadaForm').on('submit', function(e) {
        e.preventDefault();
        const jornadaId = $('#edit_jornada_id').val();

        $.ajax({
            url: `/admin/jornada/${jornadaId}`,
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    $('#editJornadaModal').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr) {
                alert('Erro ao atualizar jornada');
                console.log(xhr.responseText);
            }
        });
    });

    // Excluir Jornada
    let jornadaToDelete = null;

    $('.delete-jornada').click(function() {
        jornadaToDelete = $(this).data('jornada');
    });

    $('#confirmDelete').click(function() {
        if(jornadaToDelete) {
            $.ajax({
                url: `/admin/jornada/${jornadaToDelete}`,
                method: 'DELETE',
                success: function(response) {
                    if(response.success) {
                        $('#deleteJornadaModal').modal('hide');
                        location.reload();
                    }
                },
                error: function(xhr) {
                    alert('Erro ao excluir jornada');
                    console.log(xhr.responseText);
                }
            });
        }
    });
});
</script>
@endpush
@endsection 