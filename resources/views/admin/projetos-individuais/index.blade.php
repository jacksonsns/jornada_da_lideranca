@extends('layouts.app-admin')

@section('title', 'Gerenciar Projetos Individuais')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0 text-light">
                        <i class="fas fa-project-diagram"></i>
                        Gerenciar Projetos Individuais
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Usuário</th>
                                    <th>Título</th>
                                    <th>Data Início</th>
                                    <th>Data Fim</th>
                                    <th>Status</th>
                                    <th>Última Atualização</th>
                                    <th width="150">Ações</th>
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
                                            <span class="badge bg-{{ $projeto->status === 'em_andamento' ? 'primary' : ($projeto->status === 'concluido' ? 'success' : 'danger') }}">
                                                {{ ucfirst(str_replace('_', ' ', $projeto->status)) }}
                                            </span>
                                        </td>
                                        <td>{{ $projeto->updated_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalVisualizar"
                                                    data-projeto='@json($projeto)'>
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalStatus"
                                                    data-id="{{ $projeto->id }}"
                                                    data-status="{{ $projeto->status }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $projetos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Visualizar -->
<div class="modal fade" id="modalVisualizar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title text-light">
                    <i class="fas fa-eye"></i> Detalhes do Projeto
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Status -->
<div class="modal fade" id="modalStatus" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-light">
                    <i class="fas fa-edit"></i> Atualizar Status
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formStatus" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="em_andamento">Em Andamento</option>
                            <option value="concluido">Concluído</option>
                            <option value="cancelado">Cancelado</option>
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