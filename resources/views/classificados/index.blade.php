@extends('layouts.app')

@section('content')
<div class="container my-5">

    {{-- HERO SECTION --}}
    <div class="mb-5">
        <div class="bg-dark rounded-4 overflow-hidden position-relative" style="height: 400px;">
            <img src="img/banner.png"
                 class="w-100 h-100 object-fit-cover position-absolute top-0 start-0"
                 alt="Banner">
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-black bg-opacity-50 d-flex flex-column justify-content-center align-items-center text-white text-center px-3">


                <form action="{{ route('classificados.index') }}" method="GET" class="w-100" style="max-width: 600px;">
                    <div class="input-group input-group-lg shadow">
                        <input type="text" name="busca" value="{{ request('busca') }}"
                               class="form-control rounded-start-pill border-0"
                               placeholder="Buscar em Comércio JCI...">
                        <button class="btn btn-warning rounded-end-pill px-4" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- FILTROS AVANÇADOS --}}
    <div class="accordion mb-5" id="filtrosAccordion">
        <div class="accordion-item shadow-sm rounded">
            <h2 class="accordion-header" id="headingFiltros">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFiltros">
                    Filtros Avançados
                </button>
            </h2>
            <div id="collapseFiltros" class="accordion-collapse collapse" data-bs-parent="#filtrosAccordion">
                <div class="accordion-body">
                    <form action="{{ route('classificados.index') }}" method="GET" class="row g-3">
                        <input type="hidden" name="busca" value="{{ request('busca') }}">

                        <div class="col-md-3">
                            <label class="form-label">Categoria</label>
                            <select name="categoria" class="form-select">
                                <option value="">Todas</option>
                                <option value="imoveis" {{ request('categoria') == 'imoveis' ? 'selected' : '' }}>Imóveis</option>
                                <option value="veiculos" {{ request('categoria') == 'veiculos' ? 'selected' : '' }}>Veículos</option>
                                <option value="eletronicos" {{ request('categoria') == 'eletronicos' ? 'selected' : '' }}>Eletrônicos</option>
                                <option value="servicos" {{ request('categoria') == 'servicos' ? 'selected' : '' }}>Serviços</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Estado</label>
                            <select name="estado" class="form-select">
                                <option value="">Todos</option>
                                @foreach($estados as $sigla => $nome)
                                    <option value="{{ $sigla }}" {{ request('estado') == $sigla ? 'selected' : '' }}>{{ $nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Cidade</label>
                            <input type="text" name="cidade" value="{{ request('cidade') }}"
                                   class="form-control" placeholder="Ex: São Paulo">
                        </div>

                        <div class="col-md-3 d-flex gap-2">
                            <div>
                                <label class="form-label">Preço Mínimo</label>
                                <input type="number" name="preco_min" value="{{ request('preco_min') }}"
                                       class="form-control" placeholder="R$">
                            </div>
                            <div>
                                <label class="form-label">Preço Máximo</label>
                                <input type="number" name="preco_max" value="{{ request('preco_max') }}"
                                       class="form-control" placeholder="R$">
                            </div>
                        </div>

                        <div class="col-12 text-center mt-3">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-filter me-1"></i> Aplicar Filtros
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ANÚNCIOS EM DESTAQUE --}}
    @if($destaques->count())
    <div class="mb-5">
        <h3 class="mb-4">🔥 Anúncios em Destaque</h3>
        <div class="row g-4">
            @foreach($destaques as $destaque)
                <div class="col-md-4 col-lg-3">
                    <div class="card border-0 shadow h-100">
                        <a href="{{ route('classificados.show', $destaque) }}" class="text-decoration-none text-dark">
                            @if($destaque->imagens->count())
                                <img src="{{ Storage::url($destaque->imagens[0]->caminho) }}"
                                     class="card-img-top" alt="{{ $destaque->titulo }}"
                                     style="height: 180px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                    <span class="text-muted">Sem Imagem</span>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title text-truncate">{{ $destaque->titulo }}</h5>
                                <p class="card-text small text-muted">{{ $destaque->cidade }}, {{ $destaque->estado }}</p>
                                <div class="d-flex justify-content-between">
                                    <span class="badge bg-warning text-dark">Destaque</span>
                                    <span class="fw-bold text-dark">R$ {{ number_format($destaque->preco, 2, ',', '.') }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- TODOS OS ANÚNCIOS --}}
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>📦 Todos os Anúncios</h3>
            <a href="{{ route('classificados.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle me-1"></i> Novo Anúncio
            </a>
        </div>

        <div class="row g-4">
            @forelse($classificados as $classificado)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <a href="{{ route('classificados.show', $classificado) }}" class="text-decoration-none text-dark">
                        @if($classificado->imagens && is_object($classificado->imagens) && $classificado->imagens->count() > 0)
                            <img src="{{ Storage::url($classificado->imagens->first()->caminho) }}"
                                 class="card-img-top" alt="{{ $classificado->titulo }}"
                                 style="height: 180px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                <span class="text-muted">Sem Imagem</span>
                            </div>
                        @endif
                        <div class="card-body">
                            <h6 class="card-title text-truncate">{{ $classificado->titulo }}</h6>
                            <p class="card-text small text-muted mb-1">{{ $classificado->cidade }}, {{ $classificado->estado }}</p>
                            <small class="text-muted"><i class="far fa-clock me-1"></i>{{ $classificado->created_at->diffForHumans() }}</small>
                            <div class="mt-2">
                                <span class="badge bg-info text-dark">{{ ucfirst($classificado->categoria) }}</span>
                                <span class="float-end fw-bold">R$ {{ number_format($classificado->preco, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="alert alert-info">Nenhum anúncio encontrado.</div>
                <i class="fas fa-box-open fa-3x text-muted"></i>
            </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $classificados->links() }}
        </div>
    </div>
</div>
@endsection
