@extends('layouts.app-admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gerenciar Jornada do Aspirante</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createJornadaModal">
            <i class="fas fa-plus"></i> Nova Jornada
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
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
                                <span class="badge bg-{{ $jornada->obrigatorio ? 'success' : 'warning' }}">
                                    {{ $jornada->obrigatorio ? 'Sim' : 'Não' }}
                                </span>
                            </td>
                            <td>
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
            {{ $jornadas->links() }}
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