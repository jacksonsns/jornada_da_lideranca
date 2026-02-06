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
    .clube-page-wrapper {
        padding: 2.2rem 1.8rem 1.8rem;
        background:
            radial-gradient(circle at 0 0, rgba(59,130,246,0.38), transparent 55%),
            radial-gradient(circle at 100% 100%, rgba(56,189,248,0.35), transparent 55%),
            linear-gradient(135deg,#071428 0%,#020815 100%);
        border-radius: 26px;
        box-shadow: 0 26px 70px rgba(0,0,0,0.75);
    }

    .clube-hero {
        background: linear-gradient(135deg,#1b7aff,#7c3aed);
        border-radius: 28px;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 32px 42px;
        color: #fff;
        margin-bottom: 22px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 26px 70px rgba(15,23,42,0.8);
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
    .clube-hero::before {
        content: '';
        position: absolute;
        inset: -40%;
        background:
            radial-gradient(circle at 0 0, rgba(59,130,246,0.65), transparent 60%),
            radial-gradient(circle at 100% 100%, rgba(147,51,234,0.7), transparent 55%);
        opacity: .8;
        z-index: 0;
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
        background: radial-gradient(circle at 0 0, rgba(255,255,255,0.96), rgba(233,239,255,0.98));
        border-radius: 22px;
        box-shadow: 0 22px 55px rgba(15,23,42,0.65);
        padding: 22px 32px 18px 32px;
        margin-bottom: 26px;
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
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .clube-beneficios .beneficio-logo {
        background: #f3f3ff;
        border-radius: 18px;
        width: 72px;
        height: 72px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 6px;
        box-shadow: 0 8px 22px rgba(148,163,184,0.45);
    }
    .clube-beneficios .beneficio-logo img {
        max-width: 60px;
        max-height: 60px;
    }
    .clube-beneficios .beneficio-nome {
        font-size: 15px;
        font-weight: 500;
        color: #111827;
        text-align: center;
    }

    .clube-beneficios .beneficio-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 30px rgba(15,23,42,0.35);
    }
    .clube-section-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0;
        text-align: center;
    }
    .clube-recentes {
        background: radial-gradient(circle at 0 0, rgba(255,255,255,0.96), rgba(233,239,255,0.98));
        border-radius: 26px;
        box-shadow: 0 26px 70px rgba(15,23,42,0.8);
        padding: 26px 32px 30px 32px;
    }
    .clube-recentes .recentes-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 30px;
    }
    .clube-recentes .parceiro-card {
        background: linear-gradient(145deg, rgba(246,248,255,0.98), rgba(228,237,255,0.98));
        border-radius: 24px;
        box-shadow: 0 26px 70px rgba(15,23,42,0.75);
        padding: 20px 18px 18px 18px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        min-height: 260px;
        position: relative;
        transition: transform .2s ease, box-shadow .2s ease;
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
        box-shadow: 0 10px 24px rgba(148,163,184,0.6);
    }
    .clube-recentes .parceiro-logo img {
        max-width: 48px;
        max-height: 48px;
        border-radius: 50%;
        object-fit: cover;
    }
    .clube-recentes .parceiro-nome {
        font-size: 1.05rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 4px;
    }
    .clube-recentes .parceiro-desc {
        font-size: 0.9rem;
        color: #6b7280;
        margin-bottom: 4px;
        max-height: 150px;
        overflow: hidden;
    }

    .clube-recentes .parceiro-cta {
        margin-top: auto;
        margin-bottom: 4px;
        padding: 8px 18px;
        border-radius: 999px;
        background: linear-gradient(135deg,#1d4ed8,#6366f1);
        color: #ffffff;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 12px 30px rgba(15,23,42,0.7);
    }

    .clube-recentes .parceiro-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(15,23,42,0.55);
    }
    .clube-recentes .parceiro-stars {
        color: #fbbf24;
        font-size: 1rem;
        margin-bottom: 6px;
    }
    .btn-fazer-parte {
        background: linear-gradient(135deg,#1b7aff,#7c3aed);
        border: none;
        border-radius: 28px;
        font-weight: 600;
        font-size: 0.98rem;
        box-shadow: 0 16px 40px rgba(15,23,42,0.85);
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
        color: #ffffff !important;
    }

    .btn-fazer-parte:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 36px rgba(30,64,175,0.75);
    }

    .btn-fazer-parte i {
        color: #ffffff !important;
    }

    .clube-search-group .form-control {
        border-radius: 999px 0 0 999px;
        border: none;
        box-shadow: 0 12px 30px rgba(15,23,42,0.55);
    }

    .clube-search-group .btn {
        border-radius: 0 999px 999px 0;
        border: none;
        background: linear-gradient(135deg,#1b7aff,#33b3ff);
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

<div class="container my-4 p-3" style="max-width: 1300px;">
    <div class="clube-page-wrapper">
        {{-- HERO SECTION --}}
        <div class="clube-hero">
            <div class="hero-text">
                <div class="hero-title">Seja bem-vindo ao<br>Clube <span style="color:#fff;">de Vantagens da JCI Rio do Sul</span></div>
                <div class="hero-subtitle">Aproveite benefícios exclusivos para você!</div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end align-items-center mb-2 mt-3" style="max-width: 100%;">
        <a href="{{ route('painel-parceiros.create') }}" class="btn px-4 py-2 btn-fazer-parte">
            <i class="fas fa-user-plus me-2"></i> Quero fazer parte
        </a>
    </div>

    {{-- CAMPO DE BUSCA --}}
    <form method="GET" action="{{ route('painel-parceiros.index') }}" class="mb-4">
        <div class="input-group clube-search-group" style="max-width: 400px; margin: 0 auto;">
            <input type="text" name="busca" class="form-control" placeholder="Buscar parceiro ou benefício..." value="{{ request('busca') }}">
            <button class="btn btn-primary" type="submit">
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
        <div class="clube-section-title mb-3">Adicionados recentemente</div>
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
                    <div class="parceiro-cta">
                        <span>Ver benefício</span>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $classificados->links() }}
        </div>
    </div>
</div>
@endsection
