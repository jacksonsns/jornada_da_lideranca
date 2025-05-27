@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light px-3 py-2 rounded">
            <li class="breadcrumb-item"><a href="{{ route('painel-parceiros.index') }}">Painel Parceiros</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Anúncio</li>
        </ol>
    </nav>

    <!-- Card de edição -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h1 class="h5 mb-1">Editar Anúncio</h1>
            <p class="text-muted mb-0">Atualize as informações do seu anúncio abaixo.</p>
        </div>

        <div class="card-body">
            <form action="{{ route('painel-parceiros.update', $classificado) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Título -->
                <div class="form-group">
                    <label for="titulo">Título do Anúncio</label>
                    <input type="text" name="titulo" id="titulo" class="form-control @error('titulo') is-invalid @enderror"
                           value="{{ old('titulo', $classificado->titulo) }}" placeholder="Ex: Casa com 3 quartos em bairro tranquilo" required>
                    @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Descrição -->
                <div class="form-group">
                    <label for="descricao">Descrição Detalhada</label>
                    <textarea name="descricao" id="descricao" rows="4"
                              class="form-control @error('descricao') is-invalid @enderror"
                              placeholder="Inclua detalhes relevantes sobre o que está anunciando" required>{{ old('descricao', $classificado->descricao) }}</textarea>
                    @error('descricao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Localização -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="estado">Estado</label>
                        <select name="estado" id="estado" class="form-control @error('estado') is-invalid @enderror" required>
                            <option value="">Escolha o estado</option>
                            @foreach($estados as $sigla => $nome)
                                <option value="{{ $sigla }}" {{ old('estado', $classificado->estado) === $sigla ? 'selected' : '' }}>{{ $nome }}</option>
                            @endforeach
                        </select>
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="cidade">Cidade</label>
                        <input type="text" name="cidade" id="cidade"
                               class="form-control @error('cidade') is-invalid @enderror"
                               value="{{ old('cidade', $classificado->cidade) }}" placeholder="Digite a cidade" required>
                        @error('cidade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Bairro -->
                <div class="form-group">
                    <label for="bairro">Bairro <span class="text-muted">(opcional)</span></label>
                    <input type="text" name="bairro" id="bairro"
                           class="form-control @error('bairro') is-invalid @enderror"
                           value="{{ old('bairro', $classificado->bairro) }}" placeholder="Digite o bairro">
                    @error('bairro')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Telefone -->
                <div class="form-group">
                    <label for="telefone">Telefone para Contato <span class="text-muted">(opcional)</span></label>
                    <input type="text" name="telefone" id="telefone"
                           class="form-control @error('telefone') is-invalid @enderror"
                           value="{{ old('telefone', $classificado->telefone) }}" placeholder="(00) 00000-0000">
                    @error('telefone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Imagens existentes -->
                @if($classificado->imagens->count() > 0)
                    <div class="form-group">
                        <label>Imagens Atuais</label>
                        <div class="row mt-2">
                            @foreach($classificado->imagens as $imagem)
                                <div class="col-md-3 mb-3">
                                    <div class="position-relative">
                                        <img src="{{ Storage::url($imagem->caminho) }}"
                                             class="img-thumbnail" alt="Imagem" style="height: 150px; object-fit: cover; width: 100%;">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2"
                                                onclick="excluirImagem({{ $imagem->id }})">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Upload de novas imagens -->
                <div class="form-group">
                    <label for="imagens">Adicionar Novas Imagens</label>
                    <input type="file" name="imagens[]" id="imagens" class="form-control @error('imagens') is-invalid @enderror"
                           multiple accept="image/*">
                    <small class="form-text text-muted">Você pode selecionar várias imagens. Tamanho máximo: 2MB por imagem.</small>
                    @error('imagens')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div id="image-preview" class="row mt-3"></div>

                <!-- Destaque -->
                <div class="form-group form-check">
                    <input class="form-check-input" type="checkbox" name="destaque" id="destaque" value="1" {{ old('destaque', $classificado->destaque) ? 'checked' : '' }}>
                    <label class="form-check-label" for="destaque">Marcar como destaque</label>
                </div>

                <!-- Botões -->
                <div class="mt-4 d-flex justify-content-end">
                    <a href="{{ route('painel-parceiros.show', $classificado) }}" class="btn btn-outline-secondary mr-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Atualizar Anúncio</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
@push('scripts')
<script>
    // Prévia das imagens
    document.getElementById('imagens').addEventListener('change', function(e) {
        const preview = document.getElementById('image-preview');
        preview.innerHTML = '';
        
        [...e.target.files].forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'col-md-3 mb-3';
                div.innerHTML = `
                    <div class="position-relative">
                        <img src="${e.target.result}" class="img-thumbnail" style="height: 150px; object-fit: cover; width: 100%;">
                    </div>
                `;
                preview.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    });

    // Exclusão de imagem
    function excluirImagem(id) {
        if (confirm('Tem certeza que deseja excluir esta imagem?')) {
            fetch(`/classificados/imagens/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Erro ao excluir imagem');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao excluir imagem');
            });
        }
    }
</script>
@endpush
@endsection
