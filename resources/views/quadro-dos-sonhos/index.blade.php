@extends('layouts.app')

@section('content')
<style>
    .dream-gallery {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        padding: 15px;
    }

    .dream-item {
        width: 180px;
        height: 150px;
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease-in-out;
        background: #f8f9fa;
    }

    .dream-item:hover {
        transform: scale(1.05);
    }

    .dream-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .dream-title {
        position: absolute;
        bottom: 0;
        width: 100%;
        padding: 5px 10px;
        background: rgba(0, 0, 0, 0.5);
        color: #fff;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .dream-title i {
        color: gold;
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

    .upload-btn:hover {
        background-color: #0056b3;
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
                            <div id="image-feedback" class="mt-2 text-success" style="display:none;">
                                <i class="fas fa-check-circle"></i> Imagem selecionada com sucesso!
                            </div>

                            <textarea name="descricao" class="form-control mt-3" placeholder="Descreva seu sonho..." rows="3" required></textarea>
                            <input type="text" name="titulo" class="form-control mt-3" placeholder="Título do sonho" required>

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
        if (this.files && this.files.length > 0) {
            feedback.style.display = 'block';
        } else {
            feedback.style.display = 'none';
        }
    });
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
