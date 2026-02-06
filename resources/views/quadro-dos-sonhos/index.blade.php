@extends('layouts.app')

@section('content')
<style>
    .dream-page-wrapper {
        padding: 2.5rem 2.5rem 1.5rem;
    }

    .preview-container {
        margin-top: 18px;
        display: none;
    }

    .dream-shell-card {
        border-radius: 26px;
        border: none;
        background: radial-gradient(circle at 0 0, rgba(255,255,255,0.96), rgba(233,239,255,0.98));
        box-shadow: 0 22px 55px rgba(0,0,0,0.65);
        overflow: hidden;
    }

    .dream-shell-card .card-header {
        border: none;
        border-radius: 26px 26px 0 0 !important;
        background: linear-gradient(135deg,#1b7aff,#33b3ff);
        box-shadow: 0 10px 25px rgba(15,35,95,0.45);
    }

    .dream-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 22px;
        padding: 4px 4px 14px;
    }

    .dream-item {
        position: relative;
        border-radius: 18px;
        overflow: hidden;
        background: radial-gradient(circle at 0 0, rgba(255,255,255,0.9), rgba(229,235,255,0.96));
        box-shadow: 0 18px 45px rgba(0, 0, 0, 0.55);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 240px;
        cursor: pointer;
    }

    .dream-item:hover {
        transform: translateY(-6px) scale(1.01);
        box-shadow: 0 22px 40px rgba(0, 0, 0, 0.6);
    }

    .dream-image-container {
        position: relative;
        height: 65%;
        overflow: hidden;
        border-bottom: 1px solid rgba(255,255,255,0.55);
    }

    .dream-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
        transform-origin: center;
    }

    .dream-item:hover .dream-image {
        transform: scale(1.08);
    }

    .dream-title {
        padding: 10px 14px;
        background: linear-gradient(90deg,#051634,#10224f);
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 14px;
        flex: 1;
        border-radius: 0 0 18px 18px;
    }

    .dream-title span {
        max-width: 75%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-weight: 500;
        letter-spacing: 0.02em;
    }

    .dream-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to top, rgba(4, 23, 63, 0.85), rgba(4,23,63,0.25), transparent);
        opacity: 0;
        transition: opacity 0.35s ease;
    }

    .dream-delete {
        position: absolute;
        top: 8px;
        right: 8px;
        z-index: 2;
    }

    .delete-btn {
        background: rgba(255, 255, 255, 0.85);
        border: none;
        border-radius: 50%;
        padding: 6px;
        width: 32px;
        height: 32px;
        cursor: pointer;
        height: auto;
        transition: background 0.3s;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
    }

    .delete-btn:hover {
        background: radial-gradient(circle at 0 0, rgba(255,255,255,0.96), rgba(229,57,53,1));
        transform: scale(1.07) translateY(-1px);
        box-shadow: 0 12px 26px rgba(0,0,0,0.65);
    }

    .delete-btn i {
        font-size: 14px;
    }

    .upload-btn {
        display: inline-block;
        padding: 10px 15px;
        background-image: linear-gradient(135deg,#1b7aff,#33b3ff);
        color: white;
        border-radius: 999px;
        cursor: pointer;
        transition: background 0.3s, transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 10px 25px rgba(0,0,0,0.45);
    }

    .upload-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 14px 32px rgba(0,0,0,0.6);
    }

    .upload-hint {
        font-size: 12px;
        color: #6c8ab0;
        margin-top: 10px;
    }

    @media (max-width: 768px) {
        .dream-item {
            height: 200px;
        }
    }

    @media (max-width: 576px) {
        .dream-item {
            height: 180px;
        }
    }
</style>


<div class="main_content_iner dream-page-wrapper">
    <div class="container-fluid p-0 sm_padding_15px">
        <div class="row">
            <!-- Galeria de Sonhos -->
            <div class="col-lg-8">
                <div class="card shadow-lg dream-shell-card">
                    <div class="card-header bg-info text-white text-center">
                        <h4 class="text-light">🌟 Meu Quadro dos Sonhos</h4>
                    </div>
                    <div class="card-body">
                        <div class="dream-gallery">
                            @forelse($sonhos as $sonho)
                                <div class="dream-item">
                                    <div class="dream-delete">
                                        <form action="{{ route('quadro-dos-sonhos.destroy', $sonho->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este sonho?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-btn" title="Excluir sonho">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                    @if($sonho->imagem)
                                        <img src="{{ Storage::url($sonho->imagem) }}" alt="{{ $sonho->titulo }}">
                                    @endif
                                    <div class="dream-title">
                                        <i class="fas fa-star"></i>
                                        {{ $sonho->titulo }}
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted text-center">Nenhum sonho cadastrado ainda.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulário de Upload -->
            <div class="col-lg-4">
                <div class="card shadow-lg dream-shell-card">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="text-light">🎯 Adicione seu Sonho</h4>
                    </div>
                    <div class="card-body text-center">
                        <form action="{{ route('quadro-dos-sonhos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="upload-btn">
                                <input type="file" name="imagem" accept="image/*" id="image-upload" hidden>
                                📷 Escolher Imagem
                            </label>
                            <img id="image-preview" src="#" alt="Pré-visualização" style="display:none; max-width: 100%; margin-top: 10px; border-radius: 10px;" />

                            <div id="image-feedback" class="mt-2 text-success" style="display:none;">
                                <i class="fas fa-check-circle"></i> Imagem selecionada com sucesso!
                            </div>
                            <input type="text" name="titulo" class="form-control mt-3 mb-3" placeholder="Título do sonho" required>
                            <div class="mb-3">
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

                            <textarea name="descricao" class="form-control mt-3" placeholder="Descreva seu sonho..." rows="3" required></textarea>

                            <button type="submit" class="btn btn-success mt-3 w-100">Adicionar ao Quadro</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($sonhos->isNotEmpty())
            <div class="mt-4">
                {{ $sonhos->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    document.getElementById('image-upload').addEventListener('change', function () {
        const feedback = document.getElementById('image-feedback');
        const preview = document.getElementById('image-preview');

        if (this.files && this.files[0]) {
            feedback.style.display = 'block';

            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        } else {
            feedback.style.display = 'none';
            preview.style.display = 'none';
        }
    });
</script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
