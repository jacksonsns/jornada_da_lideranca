@extends('layouts.app')

@section('title', 'Meus Projetos Individuais')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-light">
                        <i class="fas fa-project-diagram"></i>
                        Meus Projetos Individuais
                    </h4>
                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalCriar">
                        <i class="fas fa-plus"></i> Novo Projeto
                    </button>
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
                                                <i class="fas fa-eye text-light"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalEditar"
                                                    data-projeto='@json($projeto)'>
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalExcluir"
                                                    data-projeto='@json($projeto)'>
                                                <i class="fas fa-trash"></i>
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

<!-- Modal Criar -->
<div class="modal fade" id="modalCriar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-light">
                    <i class="fas fa-plus"></i> Novo Projeto Individual
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('projetos-individuais.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" name="titulo" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Data Início</label>
                                <input type="date" name="data_inicio" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Data Fim (opcional)</label>
                                <input type="date" name="data_fim" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Resultados (opcional)</label>
                        <textarea name="resultados" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Criar Projeto</button>
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
                <h5 class="modal-title text-light">
                    <i class="fas fa-edit"></i> Editar Projeto Individual
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditar" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" name="titulo" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Data Início</label>
                                <input type="date" name="data_inicio" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Data Fim (opcional)</label>
                                <input type="date" name="data_fim" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Resultados (opcional)</label>
                        <textarea name="resultados" class="form-control" rows="3"></textarea>
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
                <h5 class="modal-title text-light">
                    <i class="fas fa-trash"></i> Excluir Projeto Individual
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir este projeto individual?</p>
                <p class="mb-0"><strong>Título:</strong> <span id="projetoTitulo"></span></p>
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

<!-- Modal Visualizar -->
<div class="modal fade" id="modalVisualizar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title text-light">
                    <i class="fas fa-eye text-light"></i> Detalhes do Projeto
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Título:</strong> <span id="projetoTituloVisualizar"></span></p>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal Editar
    const modalEditar = document.getElementById('modalEditar');
    modalEditar.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const projeto = JSON.parse(button.getAttribute('data-projeto'));
        
        const form = document.getElementById('formEditar');
        form.action = `/projetos-individuais/${projeto.id}`;

        form.querySelector('[name="titulo"]').value = projeto.titulo;
        form.querySelector('[name="descricao"]').value = projeto.descricao;
        form.querySelector('[name="data_inicio"]').value = projeto.data_inicio;
        form.querySelector('[name="data_fim"]').value = projeto.data_fim || '';
        form.querySelector('[name="resultados"]').value = projeto.resultados || '';
    });

    // Modal Excluir
    const modalExcluir = document.getElementById('modalExcluir');
    modalExcluir.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const projeto = JSON.parse(button.getAttribute('data-projeto'));
        
        document.getElementById('projetoTitulo').textContent = projeto.titulo;
        document.getElementById('formExcluir').action = `/projetos-individuais/${projeto.id}`;
    });

    // Modal Visualizar
    const modalVisualizar = document.getElementById('modalVisualizar');
    modalVisualizar.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const projeto = JSON.parse(button.getAttribute('data-projeto'));
        
        document.getElementById('projetoTituloVisualizar').textContent = projeto.titulo;
        document.getElementById('projetoDataInicio').textContent = new Date(projeto.data_inicio).toLocaleDateString();
        document.getElementById('projetoDataFim').textContent = projeto.data_fim ? new Date(projeto.data_fim).toLocaleDateString() : '-';
        document.getElementById('projetoStatus').textContent = projeto.status.replace('_', ' ');
        document.getElementById('projetoCreated').textContent = new Date(projeto.created_at).toLocaleString();
        document.getElementById('projetoUpdated').textContent = new Date(projeto.updated_at).toLocaleString();
        document.getElementById('projetoDescricao').textContent = projeto.descricao;
        document.getElementById('projetoResultados').textContent = projeto.resultados || '-';
    });
});
</script>
@endsection 