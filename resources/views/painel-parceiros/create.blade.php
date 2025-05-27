@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
            <li class="breadcrumb-item"><a href="{{ route('painel-parceiros.index') }}">Painel Parceiros</a></li>
            <li class="breadcrumb-item active" aria-current="page">Criar Anúncio</li>
        </ol>
    </nav>

    <div class="card shadow-sm border-0 mt-3">
        <div class="card-header bg-primary text-white rounded-top">
            <h1 class="h5 mb-0 text-light">Criar Novo Anúncio</h1>
            <small class="text-white-50">Preencha os campos abaixo para criar seu anúncio</small>
        </div>

        <div class="card-body">
            <form action="{{ route('painel-parceiros.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Título -->
                <div class="form-group">
                    <label for="titulo">Título</label>
                    <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" required
                        class="form-control @error('titulo') is-invalid @enderror"
                        placeholder="Ex: Apartamento 2 quartos no centro">
                    @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Descrição -->
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea name="descricao" id="descricao" rows="4" required
                        class="form-control @error('descricao') is-invalid @enderror"
                        placeholder="Descreva detalhadamente o que você está anunciando">{{ old('descricao') }}</textarea>
                    @error('descricao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <!-- Estado e Cidade -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="estado">Estado</label>
                        <select name="estado" id="estado" required
                            class="form-control @error('estado') is-invalid @enderror">
                            <option value="">Selecione um estado</option>
                            @foreach($estados as $sigla => $nome)
                                <option value="{{ $sigla }}" {{ old('estado') == $sigla ? 'selected' : '' }}>{{ $nome }}</option>
                            @endforeach
                        </select>
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="cidade">Cidade</label>
                        <input type="text" name="cidade" id="cidade" value="{{ old('cidade') }}" required
                            class="form-control @error('cidade') is-invalid @enderror"
                            placeholder="Digite sua cidade">
                        @error('cidade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Bairro -->
                <div class="form-group">
                    <label for="bairro">Bairro <small class="text-muted">(opcional)</small></label>
                    <input type="text" name="bairro" id="bairro" value="{{ old('bairro') }}"
                        class="form-control @error('bairro') is-invalid @enderror"
                        placeholder="Digite o bairro">
                    @error('bairro')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Telefone -->
                <div class="form-group">
                    <label for="telefone">Telefone para Contato <small class="text-muted">(opcional)</small></label>
                    <input type="text" name="telefone" id="telefone" value="{{ old('telefone') }}"
                        class="form-control @error('telefone') is-invalid @enderror"
                        placeholder="(00) 00000-0000">
                    @error('telefone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Imagens -->
                <div class="form-group">
                    <label for="imagens">Imagens</label>
                    <div class="custom-file">
                        <input type="file" name="imagens[]" id="imagens" class="custom-file-input @error('imagens') is-invalid @enderror" multiple accept="image/*">
                        <label class="custom-file-label" for="imagens">Escolher arquivos...</label>
                        @error('imagens')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div id="image-preview" class="row mt-3"></div>
                </div>

                <!-- Ações -->
                <div class="mt-4 text-right">
                    <a href="{{ route('painel-parceiros.index') }}" class="btn btn-outline-secondary mr-2">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-success">
                        Criar Anúncio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $('.custom-file-input').on('change', function () {
        let fileNames = [];
        for (let i = 0; i < this.files.length; i++) {
            fileNames.push(this.files[i].name);
        }
        $(this).next('.custom-file-label').html(fileNames.join(', '));

        $('#image-preview').empty();
        if (this.files && this.files.length > 0) {
            for (let i = 0; i < this.files.length; i++) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#image-preview').append(`
                        <div class="col-md-3 mb-3">
                            <div class="border rounded p-1 shadow-sm">
                                <img src="${e.target.result}" class="img-fluid" style="height: 100px; object-fit: cover;">
                            </div>
                        </div>
                    `);
                };
                reader.readAsDataURL(this.files[i]);
            }
        }
    });
</script>
@endpush
@endsection
