@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light px-3 py-2 rounded">
            <li class="breadcrumb-item"><a href="{{ route('classificados.index') }}">Classificados</a></li>
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
            <form action="{{ route('classificados.update', $classificado) }}" method="POST" enctype="multipart/form-data">
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

                <!-- Preço -->
                <div class="form-group">
                    <label for="preco">Preço</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">R$</span>
                        </div>
                        <input type="number" name="preco" id="preco"
                               class="form-control @error('preco') is-invalid @enderror"
                               value="{{ old('preco', $classificado->preco) }}" step="0.01" placeholder="0,00" required>
                    </div>
                    @error('preco')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Categoria -->
                <div class="form-group">
                    <label for="categoria">Categoria</label>
                    <select name="categoria" id="categoria" class="form-control @error('categoria') is-invalid @enderror" required>
                        <option value="">Selecione uma categoria</option>
                        @foreach(['imoveis' => 'Imóveis', 'veiculos' => 'Veículos', 'eletronicos' => 'Eletrônicos', 'servicos' => 'Serviços'] as $valor => $nome)
                            <option value="{{ $valor }}" {{ old('categoria', $classificado->categoria) === $valor ? 'selected' : '' }}>{{ $nome }}</option>
                        @endforeach
                    </select>
                    @error('categoria')
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
                                <div class="col-md-3">
                                    <img src="{{ Storage::url($imagem->caminho) }}"
                                         class="img-thumbnail mb-2" alt="Imagem" style="height: 100px; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Upload de novas imagens -->
                <div class="form-group">
                    <label for="imagens">Adicionar Novas Imagens</label>
                    <div class="custom-file">
                        <input type="file" name="imagens[]" id="imagens" class="custom-file-input @error('imagens') is-invalid @enderror"
                               multiple accept="image/*">
                        <label class="custom-file-label" for="imagens">Escolher arquivos...</label>
                        @error('imagens')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div id="image-preview" class="row mt-3"></div>
                </div>

                <!-- Destaque -->
                <div class="form-group form-check">
                    <input class="form-check-input" type="checkbox" name="destaque" id="destaque" value="1" {{ old('destaque', $classificado->destaque) ? 'checked' : '' }}>
                    <label class="form-check-label" for="destaque">Marcar como destaque</label>
                </div>

                <!-- Botões -->
                <div class="mt-4 d-flex justify-content-end">
                    <a href="{{ route('classificados.show', $classificado) }}" class="btn btn-outline-secondary mr-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Atualizar Anúncio</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
@push('scripts')
<script>
    document.querySelector('.custom-file-input').addEventListener('change', function () {
        const label = this.nextElementSibling;
        const previewContainer = document.getElementById('image-preview');
        label.innerHTML = Array.from(this.files).map(f => f.name).join(', ');
        previewContainer.innerHTML = '';

        Array.from(this.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail mb-2';
                img.style.height = '100px';
                img.style.objectFit = 'cover';
                const col = document.createElement('div');
                col.className = 'col-md-3';
                col.appendChild(img);
                previewContainer.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endpush
@endsection
