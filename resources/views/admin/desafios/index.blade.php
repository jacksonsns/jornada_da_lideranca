@extends('layouts.app-admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gerenciar Desafios</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDesafioModal">
            <i class="fas fa-plus"></i> Novo Desafio
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
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
                            <td>
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
            {{ $desafios->links() }}
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
