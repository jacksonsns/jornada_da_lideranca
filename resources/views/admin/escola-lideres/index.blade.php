@extends('layouts.app-admin')

@section('title', 'Gerenciar Módulos - Escola de Líderes')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-light">
                        <i class="fas fa-graduation-cap"></i>
                        Gerenciar Módulos - Escola de Líderes
                    </h4>
                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalCriar">
                        <i class="fas fa-plus"></i> Novo Módulo
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Ordem</th>
                                    <th>Título</th>
                                    <th>Descrição</th>
                                    <th>Aulas</th>
                                    <th>Material</th>
                                    <th width="150">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modulos as $modulo)
                                    <tr>
                                        <td>{{ $modulo->ordem }}</td>
                                        <td>{{ $modulo->titulo }}</td>
                                        <td>{{ Str::limit($modulo->descricao, 100) }}</td>
                                        <td>{{ $modulo->aulas_count }}</td>
                                        <td>
                                            @if($modulo->material_url)
                                                <a href="{{ $modulo->material_url }}" target="_blank" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-download"></i> Baixar
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalEditar"
                                                    data-modulo="{{ $modulo }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalExcluir"
                                                    data-modulo="{{ $modulo }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $modulos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Criar -->
<div class="modal fade" id="modalCriar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-light">
                    <i class="fas fa-plus"></i> Novo Módulo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formCriar" action="{{ route('admin.escola-lideres.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Ordem</label>
                        <input type="number" name="ordem" class="form-control" required min="1">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" name="titulo" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">URL do Material</label>
                        <input type="url" name="material_url" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Criar Módulo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i> Editar Módulo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditar" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Ordem</label>
                        <input type="number" name="ordem" class="form-control" required min="1">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" name="titulo" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">URL do Material</label>
                        <input type="url" name="material_url" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Excluir -->
<div class="modal fade" id="modalExcluir" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-trash"></i> Excluir Módulo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir este módulo?</p>
                <p class="mb-0"><strong>Título:</strong> <span id="moduloTitulo"></span></p>
            </div>
            <div class="modal-footer">
                <form id="formExcluir" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

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