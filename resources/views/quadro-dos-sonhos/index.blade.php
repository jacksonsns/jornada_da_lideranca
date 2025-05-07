@extends('layouts.app')

@section('content')
<style>
    .dream-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .dream-item {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 240px;
        cursor: pointer;
    }

    .dream-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
    }

    .dream-item img {
        flex: 1;
        width: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .dream-title {
        background: rgba(0, 0, 0, 0.65);
        color: #fff;
        padding: 10px;
        font-size: 15px;
        font-weight: 600;
        text-align: center;
        position: absolute;
        bottom: 0;
        width: 100%;
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .upload-btn {
        display: inline-block;
        padding: 10px 15px;
        background-color: #007bff;
        color: white;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .dream-title i {
        color: #ffc107;
        font-size: 16px;
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
        background: rgba(255, 0, 0, 0.85);
        color: #fff;
    }

    .delete-btn i {
        font-size: 14px;
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


<div class="main_content_iner">
    <div class="container-fluid p-0 sm_padding_15px">
        <div class="row">
            <!-- Galeria de Sonhos -->
            <div class="col-lg-8">
                <div class="card shadow-lg">
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
                <div class="card shadow-lg">
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
