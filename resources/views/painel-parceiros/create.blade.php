@extends('layouts.app')

@section('content')
<style>
    .clube-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 32px 0;
    }
    .clube-breadcrumb {
        background: none;
        padding: 0;
        margin-bottom: 24px;
    }
    .clube-breadcrumb .breadcrumb-item a,
    .clube-breadcrumb .breadcrumb-item.active {
        color: #7c3aed;
        font-weight: 500;
        font-size: 1.05rem;
    }
    .clube-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        margin-bottom: 32px;
        padding: 0;
        border: none;
    }
    .clube-card .card-body {
        padding: 32px 28px 24px 28px;
    }
    .clube-title {
        color: #7c3aed;
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 8px;
    }
    .clube-section-title {
        color: #7c3aed;
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 12px;
    }
    .form-label, label {
        font-weight: 500;
        color: #5b21b6;
    }
    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        box-shadow: none;
        font-size: 1rem;
    }
    .form-control:focus, .form-select:focus {
        border-color: #7c3aed;
        box-shadow: 0 0 0 2px #ede9fe;
    }
    .btn-clube {
        background: #7c3aed;
        color: #fff;
        border-radius: 28px;
        font-weight: 600;
        font-size: 1.08rem;
        box-shadow: 0 2px 8px rgba(124,58,237,0.07);
        transition: background 0.2s;
        padding: 10px 32px;
    }
    .btn-clube:hover {
        background: #5b21b6;
        color: #fff;
    }
    .btn-outline-clube {
        border: 2px solid #7c3aed;
        color: #7c3aed;
        background: #fff;
        border-radius: 28px;
        font-weight: 600;
        font-size: 1.08rem;
        padding: 10px 32px;
    }
    .btn-outline-clube:hover {
        background: #ede9fe;
        color: #5b21b6;
    }
</style>
<div class="clube-container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="clube-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('painel-parceiros.index') }}">Clube de Vantagens</a></li>
            <li class="breadcrumb-item active" aria-current="page">Nova Empresa Parceira</li>
        </ol>
    </nav>
    <div class="clube-card">
        <div class="card-body">
            <h1 class="clube-title mb-3">Cadastrar nova empresa parceira</h1>
            <form action="{{ route('painel-parceiros.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="titulo" class="form-label">Nome da empresa</label>
                    <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" required class="form-control @error('titulo') is-invalid @enderror" placeholder="Ex: Sua Marca Ltda">
                    @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição institucional</label>
                    <textarea name="descricao" id="descricao" rows="4" required class="form-control @error('descricao') is-invalid @enderror" placeholder="Fale sobre a empresa, missão, diferenciais, etc.">{{ old('descricao') }}</textarea>
                    @error('descricao')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" id="estado" required class="form-select @error('estado') is-invalid @enderror">
                            <option value="">Selecione um estado</option>
                            @foreach($estados as $sigla => $nome)
                                <option value="{{ $sigla }}" {{ old('estado') == $sigla ? 'selected' : '' }}>{{ $nome }}</option>
                            @endforeach
                        </select>
                        @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" name="cidade" id="cidade" value="{{ old('cidade') }}" required class="form-control @error('cidade') is-invalid @enderror" placeholder="Digite sua cidade">
                        @error('cidade')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="bairro" class="form-label">Bairro <span class="text-muted">(opcional)</span></label>
                    <input type="text" name="bairro" id="bairro" value="{{ old('bairro') }}" class="form-control @error('bairro') is-invalid @enderror" placeholder="Digite o bairro">
                    @error('bairro')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="telefone" class="form-label">Telefone para contato <span class="text-muted">(opcional)</span></label>
                    <input type="text" name="telefone" id="telefone" value="{{ old('telefone') }}" class="form-control @error('telefone') is-invalid @enderror" placeholder="(00) 00000-0000">
                    @error('telefone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="categoria" class="form-label">Segmento/Ramo de atuação</label>
                    <input type="text" name="categoria" id="categoria" value="{{ old('categoria') }}" class="form-control @error('categoria') is-invalid @enderror" placeholder="Ex: Educação, Saúde, Tecnologia">
                    @error('categoria')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="beneficio" class="form-label">Benefício para associados <span class="text-muted">(opcional)</span></label>
                    <input type="text" name="beneficio" id="beneficio" value="{{ old('beneficio') }}" class="form-control @error('beneficio') is-invalid @enderror" placeholder="Ex: 10% de desconto para associados">
                    @error('beneficio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="site" class="form-label">Site <span class="text-muted">(opcional)</span></label>
                    <input type="url" name="site" id="site" value="{{ old('site') }}" class="form-control @error('site') is-invalid @enderror" placeholder="https://">
                    @error('site')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="instagram" class="form-label">Instagram <span class="text-muted">(opcional)</span></label>
                    <input type="url" name="instagram" id="instagram" value="{{ old('instagram') }}" class="form-control @error('instagram') is-invalid @enderror" placeholder="https://instagram.com/suaempresa">
                    @error('instagram')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="facebook" class="form-label">Facebook <span class="text-muted">(opcional)</span></label>
                    <input type="url" name="facebook" id="facebook" value="{{ old('facebook') }}" class="form-control @error('facebook') is-invalid @enderror" placeholder="https://facebook.com/suaempresa">
                    @error('facebook')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="imagens" class="form-label">Logo ou imagem principal</label>
                    <input type="file" name="imagens[]" id="imagens" class="form-control @error('imagens') is-invalid @enderror" multiple accept="image/*">
                    @error('imagens')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div id="image-preview" class="row mt-3"></div>
                </div>
                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('painel-parceiros.index') }}" class="btn btn-outline-clube">Cancelar</a>
                    <button type="submit" class="btn btn-clube">Cadastrar empresa</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.getElementById('imagens').addEventListener('change', function(e) {
        const preview = document.getElementById('image-preview');
        preview.innerHTML = '';
        [...e.target.files].forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'col-md-3 mb-3';
                div.innerHTML = `
                    <div class="border rounded p-1 shadow-sm">
                        <img src="${e.target.result}" class="img-fluid" style="height: 100px; object-fit: cover;">
                    </div>
                `;
                preview.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    });
</script>
@endpush
@endsection
