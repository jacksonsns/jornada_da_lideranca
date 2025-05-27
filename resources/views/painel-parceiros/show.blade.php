@extends('layouts.app')

@section('content')
<div class="py-5 bg-light min-vh-100">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('painel-parceiros.index') }}">Classificados</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $classificado->titulo }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <!-- Galeria de Imagens -->
                    @if($classificado->imagens->count() > 0)
                        <div id="classificadoCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($classificado->imagens as $index => $imagem)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ Storage::url($imagem->caminho) }}" class="d-block w-100" alt="Imagem do anúncio" style="height: 400px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#classificadoCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#classificadoCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                    @else
                        <div class="d-flex justify-content-center align-items-center bg-secondary bg-opacity-10" style="height: 400px;">
                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                        </div>
                    @endif

                    <div class="card-body">
                        <!-- Informações do Anúncio -->
                        <div class="d-flex justify-content-between">
                            <div>
                                <h1 class="h4">{{ $classificado->titulo }}</h1>
                                <div class="text-muted small">
                                    <i class="bi bi-geo-alt"></i> {{ $classificado->cidade }}, {{ $classificado->estado }}
                                    @if($classificado->bairro)
                                        - {{ $classificado->bairro }}
                                    @endif
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="text-muted small">Publicado em {{ $classificado->created_at->format('d/m/Y') }}</div>
                            </div>
                        </div>

                        <!-- Descrição -->
                        <div class="mt-4">
                            <h5>Descrição</h5>
                            <p class="text-muted">{{ $classificado->descricao }}</p>
                        </div>


                        <!-- Detalhes -->
                        <hr>
                        <h5>Detalhes</h5>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong>Categoria:</strong> {{ ucfirst($classificado->categoria) }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Localização:</strong> {{ $classificado->cidade }}, {{ $classificado->estado }} @if($classificado->bairro) - {{ $classificado->bairro }} @endif
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Visualizações:</strong> {{ $classificado->visualizacoes }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Status:</strong> {{ $classificado->destaque ? 'Destaque' : 'Normal' }}
                            </div>
                        </div>

                        <!-- Ações -->
                        @can('update', $classificado)
                            <div class="mt-4 d-flex gap-2 justify-content-end">
                                <a href="{{ route('painel-parceiros.edit', $classificado) }}" class="btn btn-outline-secondary">Editar Anúncio</a>
                                <form action="{{ route('painel-parceiros.destroy', $classificado) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este anúncio?')" class="btn btn-danger">
                                        Excluir Anúncio
                                    </button>
                                </form>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Informações do Anunciante -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Anunciante</h5>
                        <div class="d-flex align-items-center mt-3">
                            <img src="{{ $classificado->user->profile_photo_url }}" class="rounded-circle me-3" width="50" height="50" alt="{{ $classificado->user->name }}">
                            <div>
                                <strong class="text-dark">{{ $classificado->user->name }}</strong><br>
                                <small class="text-muted">Membro desde {{ $classificado->user->created_at->format('d/m/Y') }}</small>
                            </div>
                        </div>
                        
                        <!-- Contato -->
                        @if($classificado->telefone)
                        <div class="mt-4">
                            <h5>Contato</h5>
                            <p class="text-muted mb-2">
                                <i class="fas fa-phone me-2"></i>{{ $classificado->telefone }}
                            </p>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $classificado->telefone) }}" 
                               class="btn btn-success w-100" 
                               target="_blank">
                                <i class="fab fa-whatsapp me-2"></i>Contatar via WhatsApp
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Anúncios Relacionados (estrutura base) -->
                <div>
                    <h5>Anúncios Relacionados</h5>
                    <!-- Aqui você pode iterar sobre os relacionados -->
                    <div class="row">
                        <!-- Exemplo -->
                        {{-- @foreach($relacionados as $item)
                            <div class="col-12 mb-2">
                                <div class="card">
                                    <img src="..." class="card-img-top">
                                    <div class="card-body p-2">
                                        <h6 class="card-title mb-1">{{ $item->titulo }}</h6>
                                        <small class="text-muted">R$ {{ number_format($item->preco, 2, ',', '.') }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
