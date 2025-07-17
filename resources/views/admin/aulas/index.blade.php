@extends('layouts.app-admin')

@section('title', 'Gerenciar Aulas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-light">
                        <i class="fas fa-play-circle"></i>
                        Gerenciar Aulas
                    </h4>
                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalCriar">
                        <i class="fas fa-plus"></i> Nova Aula
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Exibindo mensagem de erro -->
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Módulo</th>
                                    <th>Ordem</th>
                                    <th>Título</th>
                                    <th>Duração</th>
                                    <th>Vídeo</th>
                                    <th>Material</th>
                                    <th width="150">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aulas as $aula)
                                    <tr>
                                        <td>{{ $aula->modulo->titulo }}</td>
                                        <td>{{ $aula->ordem }}</td>
                                        <td>{{ $aula->titulo }}</td>
                                        <td>{{ $aula->duracao_minutos }} min</td>
                                        <td>
                                            @if(isset($aula->video_url))
                                                <a href="{{ $aula->video_url }}" target="_blank" class="btn btn-sm btn-info">
                                                    <i class="fas fa-play"></i> Ver
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($aula->material_url))
                                                <a href="{{ Storage::url($aula->material_url) }}" target="_blank" class="btn btn-sm btn-warning">
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
                                                    data-id="{{ $aula->id }}"
                                                    data-modulo="{{ $aula->modulo_escola_lideres_id }}"
                                                    data-ordem="{{ $aula->ordem }}"
                                                    data-titulo="{{ $aula->titulo }}"
                                                    data-descricao="{{ $aula->descricao }}"
                                                    data-conteudo="{{ $aula->conteudo }}"
                                                    data-video="{{ $aula->video_url }}"
                                                    data-duracao="{{ $aula->duracao_minutos }}"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalExcluir"
                                                    data-aula='@json($aula)'>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $aulas->links() }}
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
                    <i class="fas fa-plus"></i> Nova Aula
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.aulas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Módulo</label>
                            <select name="modulo_escola_lideres_id" class="form-select" required>
                                <option value="">Selecione...</option>
                                @foreach($modulos as $modulo)
                                    <option value="{{ $modulo->id }}">{{ $modulo->titulo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ordem</label>
                            <input type="number" name="ordem" class="form-control" required min="1">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" name="titulo" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Conteúdo</label>
                        <textarea name="conteudo" class="form-control" rows="5" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">URL do Vídeo (YouTube/Vimeo)</label>
                            <input type="url" name="video_url" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Material de Apoio</label>
                            <input type="file" name="material" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.rar">
                            <small class="text-muted">Formatos aceitos: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, RAR (máx. 10MB)</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Duração (minutos)</label>
                        <input type="number" name="duracao_minutos" class="form-control" required min="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Criar Aula</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="app">
<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-light">
                    <i class="fas fa-edit"></i> Editar Aula
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditar" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Módulo</label>
                            <select name="modulo_escola_lideres_id" class="form-select" required>
                                <option value="">Selecione...</option>
                                @foreach($modulos as $modulo)
                                    <option value="{{ $modulo->id }}">{{ $modulo->titulo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ordem</label>
                            <input type="number" name="ordem" class="form-control" required min="1">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" name="titulo" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Conteúdo</label>
                        <textarea name="conteudo" class="form-control" rows="5" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">URL do Vídeo (YouTube/Vimeo)</label>
                            <input type="url" name="video_url" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Material de Apoio</label>
                            <input type="file" name="material" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.rar">
                            <small class="text-muted">Formatos aceitos: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, RAR (máx. 10MB)</small>
                            @if(isset($aula->material_url))
                                <div class="mt-2">
                                    <a href="{{ Storage::url('materiais/' . $aula->material_url) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-download"></i> Material Atual
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Duração (minutos)</label>
                        <input type="number" name="duracao_minutos" class="form-control" required min="1">
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
                    <i class="fas fa-trash"></i> Excluir Aula
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir esta aula?</p>
                <p class="mb-0"><strong>Título:</strong> <span id="aulaTitulo"></span></p>
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
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal Editar
    const modalEditar = document.getElementById('modalEditar');
    modalEditar.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const modulo = button.getAttribute('data-modulo');
        const ordem = button.getAttribute('data-ordem');
        const titulo = button.getAttribute('data-titulo');
        const descricao = button.getAttribute('data-descricao');
        const conteudo = button.getAttribute('data-conteudo');
        const video = button.getAttribute('data-video');
        const duracao = button.getAttribute('data-duracao');

        const form = document.getElementById('formEditar');
        form.action = `/admin/aulas/${id}`;

        form.querySelector('[name="modulo_escola_lideres_id"]').value = modulo;
        form.querySelector('[name="ordem"]').value = ordem;
        form.querySelector('[name="titulo"]').value = titulo;
        form.querySelector('[name="descricao"]').value = descricao;
        form.querySelector('[name="conteudo"]').value = conteudo;
        form.querySelector('[name="video_url"]').value = video;
        form.querySelector('[name="duracao_minutos"]').value = duracao;
    });

    // Modal Excluir
    const modalExcluir = document.getElementById('modalExcluir');
    modalExcluir.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget; // Botão que acionou o modal
        const aula = JSON.parse(button.getAttribute('data-aula')); // Dados da aula
        
        document.getElementById('aulaTitulo').textContent = aula.titulo; // Exibir o título da aula no modal
        document.getElementById('formExcluir').action = `/admin/aulas/${aula.id}`; // Definir a URL para o DELETE
    });

});
</script>
@endsection
