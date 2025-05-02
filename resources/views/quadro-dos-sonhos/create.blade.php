@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="mx-auto" style="max-width: 600px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Novo Sonho</h1>
            <a href="{{ route('quadro-dos-sonhos.index') }}" class="text-primary">
                Voltar para o quadro
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('quadro-dos-sonhos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título do Sonho</label>
                        <input type="text" name="titulo" id="titulo" 
                               class="form-control @error('titulo') is-invalid @enderror"
                               value="{{ old('titulo') }}" required>
                        @error('titulo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea name="descricao" id="descricao" rows="4"
                                  class="form-control @error('descricao') is-invalid @enderror"
                                  required>{{ old('descricao') }}</textarea>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoria</label>
                        <select name="categoria" id="categoria" class="form-select @error('categoria') is-invalid @enderror" required>
                            <option value="">Selecione uma categoria</option>
                            <option value="pessoal" {{ old('categoria') === 'pessoal' ? 'selected' : '' }}>Pessoal</option>
                            <option value="profissional" {{ old('categoria') === 'profissional' ? 'selected' : '' }}>Profissional</option>
                            <option value="financeiro" {{ old('categoria') === 'financeiro' ? 'selected' : '' }}>Financeiro</option>
                            <option value="saude" {{ old('categoria') === 'saude' ? 'selected' : '' }}>Saúde</option>
                            <option value="relacionamentos" {{ old('categoria') === 'relacionamentos' ? 'selected' : '' }}>Relacionamentos</option>
                            <option value="outros" {{ old('categoria') === 'outros' ? 'selected' : '' }}>Outros</option>
                        </select>
                        @error('categoria')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="data_realizacao" class="form-label">Data Prevista para Realização</label>
                        <input type="date" name="data_realizacao" id="data_realizacao"
                               class="form-control @error('data_realizacao') is-invalid @enderror"
                               value="{{ old('data_realizacao') }}">
                        @error('data_realizacao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="imagem" class="form-label">Imagem do Sonho</label>
                        <input type="file" name="imagem" id="imagem" accept="image/*"
                               class="form-control @error('imagem') is-invalid @enderror">
                        <div class="form-text">Opcional: Adicione uma imagem que represente seu sonho</div>
                        @error('imagem')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            Adicionar Sonho
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
