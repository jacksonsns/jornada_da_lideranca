@extends('layouts.app')

@section('content')
<style>
    .clube-header {
        background: #fff;
        border-radius: 18px 18px 0 0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        padding: 18px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0;
    }
    .clube-header .logo {
        height: 40px;
    }
    .clube-header .search-bar {
        flex: 1;
        max-width: 420px;
        margin: 0 32px;
    }
    .clube-header .user {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .clube-categorias {
        background: #fff;
        border-radius: 0 0 18px 18px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        padding: 18px 32px 0 32px;
        display: flex;
        gap: 32px;
        justify-content: center;
        margin-bottom: 0;
    }
    .clube-categorias .cat-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 13px;
        color: #6c6c6c;
        text-align: center;
        width: 80px;
        gap: 6px;
    }
    .clube-categorias .cat-item i {
        font-size: 28px;
        color: #7c3aed;
    }
    .clube-hero {
        background: linear-gradient(90deg, #7c3aed 60%, #a78bfa 100%);
        border-radius: 18px;
        min-height: 220px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 40px 48px;
        color: #fff;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
    }
    .clube-hero .hero-text {
        z-index: 2;
    }
    .clube-hero .hero-title {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 10px;
    }
    .clube-hero .hero-subtitle {
        font-size: 1.2rem;
        font-weight: 400;
    }
    .clube-hero .hero-img {
        height: 180px;
        z-index: 2;
    }
    .clube-hero::after {
        content: '';
        position: absolute;
        right: 0; bottom: 0; top: 0;
        width: 320px;
        background: url('/img/hero-characters.png') no-repeat right center/contain;
        opacity: 1;
        z-index: 1;
    }
    .clube-beneficios {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        padding: 32px 32px 16px 32px;
        margin-bottom: 32px;
    }
    .clube-beneficios .beneficios-list {
        display: flex;
        gap: 32px;
        justify-content: center;
        flex-wrap: wrap;
    }
    .clube-beneficios .beneficio-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        width: 110px;
    }
    .clube-beneficios .beneficio-logo {
        background: #f3f3f3;
        border-radius: 12px;
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 6px;
    }
    .clube-beneficios .beneficio-logo img {
        max-width: 60px;
        max-height: 60px;
    }
    .clube-beneficios .beneficio-nome {
        font-size: 15px;
        font-weight: 500;
        color: #222;
        text-align: center;
    }
    .clube-section-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #7c3aed;
        margin-bottom: 18px;
        text-align: left;
    }
    .clube-recentes {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        padding: 32px;
    }
    .clube-recentes .recentes-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 28px;
    }
    .clube-recentes .parceiro-card {
        background: #faf9ff;
        border-radius: 16px;
        box-shadow: 0 1px 4px rgba(124,58,237,0.06);
        padding: 18px 14px 14px 14px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        min-height: 220px;
        position: relative;
    }
    .clube-recentes .parceiro-logo {
        background: #fff;
        border-radius: 50%;
        width: 64px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        border: 2px solid #e5e7eb;
    }
    .clube-recentes .parceiro-logo img {
        max-width: 48px;
        max-height: 48px;
        border-radius: 50%;
        object-fit: cover;
    }
    .clube-recentes .parceiro-nome {
        font-size: 1.1rem;
        font-weight: 600;
        color: #222;
        margin-bottom: 4px;
    }
    .clube-recentes .parceiro-desc {
        font-size: 0.95rem;
        color: #6c6c6c;
        margin-bottom: 8px;
    }
    .clube-recentes .parceiro-stars {
        color: #fbbf24;
        font-size: 1rem;
        margin-bottom: 6px;
    }
    @media (max-width: 576px) {
        .btn-fazer-parte {
            width: 100% !important;
            display: block;
            text-align: center;
        }
        .d-flex.justify-content-end.align-items-center.mb-2 {
            justify-content: center !important;
        }
    }
</style>

<div class="container my-4" style="max-width: 1300px;">
    {{-- HERO SECTION --}}
    <div class="clube-hero">
        <div class="hero-text">
            <div class="hero-title">Seja bem-vindo ao<br>Clube <span style="color:#fff;">Sua Marca</span></div>
            <div class="hero-subtitle">Aproveite benefícios exclusivos para você!</div>
        </div>
        <img src="/img/hero-characters.png" alt="Personagens" class="hero-img d-none d-md-block">
    </div>

    <div class="d-flex justify-content-end align-items-center mb-2" style="max-width: 100%;">
        <a href="{{ route('painel-parceiros.create') }}" class="btn px-4 py-2 btn-fazer-parte" style="background: #7c3aed; color: #fff; border-radius: 28px; font-weight: 600; font-size: 1.08rem; box-shadow: 0 2px 8px rgba(124,58,237,0.07); transition: background 0.2s;">
            <i class="fas fa-user-plus me-2"></i> Quero fazer parte
        </a>
    </div>

    {{-- CAMPO DE BUSCA --}}
    <form method="GET" action="{{ route('painel-parceiros.index') }}" class="mb-4">
        <div class="input-group" style="max-width: 400px; margin: 0 auto;">
            <input type="text" name="busca" class="form-control" placeholder="Buscar parceiro ou benefício..." value="{{ request('busca') }}">
            <button class="btn btn-primary" type="submit" style="background: #7c3aed; border: none;">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>

    {{-- BENEFÍCIOS EM DESTAQUE --}}
    <div class="clube-beneficios mb-5">
        <div class="clube-section-title text-center mb-4">Benefícios em Destaque</div>
        <div class="beneficios-list">
            @foreach($destaques as $destaque)
                <a href="{{ route('painel-parceiros.show', $destaque) }}" class="text-decoration-none beneficio-item">
                    <div class="beneficio-logo">
                        @if($destaque->imagens->count())
                            <img src="{{ Storage::url($destaque->imagens[0]->caminho) }}" alt="{{ $destaque->titulo }}">
                        @else
                            <span class="text-muted">Sem Imagem</span>
                        @endif
                    </div>
                    <div class="beneficio-nome">{{ $destaque->titulo }}</div>
                </a>
            @endforeach
        </div>
    </div>

    {{-- ADICIONADOS RECENTEMENTE --}}
    <div class="clube-recentes">
        <div class="clube-section-title">Adicionados recentemente</div>
        <div class="recentes-list">
            @foreach($classificados as $classificado)
                <a href="{{ route('painel-parceiros.show', $classificado) }}" class="text-decoration-none parceiro-card">
                    <div class="parceiro-logo">
                        @if($classificado->imagens && is_object($classificado->imagens) && $classificado->imagens->count() > 0)
                            <img src="{{ Storage::url($classificado->imagens->first()->caminho) }}" alt="{{ $classificado->titulo }}">
                        @else
                            <span class="text-muted">Sem Imagem</span>
                        @endif
                    </div>
                    <div class="parceiro-nome">{{ $classificado->titulo }}</div>
                    <div class="parceiro-desc">{{ $classificado->descricao ?? 'Benefício exclusivo no site ' . $classificado->titulo }}</div>
                </a>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $classificados->links() }}
        </div>
    </div>
</div>
@endsection
