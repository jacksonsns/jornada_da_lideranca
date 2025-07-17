@extends('layouts.app-admin')

@section('title', 'Capacitações - Admin')

@push('styles')
<script src="https://cdn.tiny.cloud/1/arnqtux8mc5e5tdi0zd5osuhx5epskldqa6ntewso2cha78x/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
@endpush

@section('content')
<div class="white_card card_height_100 mb_30">
    <div class="white_card_header">
        <div class="box_header m-0">
            <div class="main-title">
                <h3 class="m-0">Capacitações</h3>
            </div>
            <div class="header_more_tool">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCapacitacaoModal">
                    <i class="fas fa-plus"></i> Nova Capacitação
                </button>
            </div>
        </div>
    </div>
    <div class="white_card_body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Título</th>
                        <th>Ações</th>
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

                                <button type="button" class="btn btn-sm btn-primary"
                                    onclick="editarCapacitacao({{ $capacitacao->id }}, '{{ $data }}', '{{ addslashes($titulo) }}', {{ $insights }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.capacitacoes.destroy', $capacitacao->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta capacitação?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Nenhuma capacitação registrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Adicionar/Editar Capacitação -->
<div class="modal fade" id="addCapacitacaoModal" tabindex="-1" aria-labelledby="addCapacitacaoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCapacitacaoModalLabel">Nova Capacitação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form id="capacitacaoForm" action="{{ route('admin.capacitacoes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="data" class="form-label">Data da Capacitação</label>
                        <input type="date" class="form-control" id="data" name="data" required>
                    </div>
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="insights" class="form-label">Insights</label>
                        <textarea class="form-control tinymce" id="insights" name="insights" rows="10"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Material</label>
                        <input type="file" name="material" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.rar">
                        <small class="text-muted">Formatos aceitos: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, RAR (máx. 10MB)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Salvar</button>
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