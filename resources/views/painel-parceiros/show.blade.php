@extends('layouts.app')

@section('content')
<style>
    .clube-container {
        max-width: 1300px;
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
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 8px;
    }
    .clube-subtitle {
        color: #6c6c6c;
        font-size: 1.1rem;
        margin-bottom: 18px;
    }
    .clube-section-title {
        color: #7c3aed;
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 12px;
    }
    .clube-carousel {
        border-radius: 18px 18px 0 0;
        overflow: hidden;
    }
    .clube-carousel img {
        border-radius: 18px 18px 0 0;
    }
    .clube-info-row {
        margin-bottom: 18px;
    }
    .clube-info-label {
        color: #7c3aed;
        font-weight: 600;
    }
    .clube-btn-primary {
        background: #7c3aed;
        color: #fff;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        transition: background 0.2s;
    }
    .clube-btn-primary:hover {
        background: #5b21b6;
        color: #fff;
    }
    .clube-anunciante {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 18px;
    }
    .clube-anunciante img {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        border: 2px solid #ede9fe;
    }
    .clube-anunciante-info {
        font-size: 1rem;
    }
    .clube-sidebar-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        padding: 28px 22px 18px 22px;
        margin-bottom: 28px;
    }
    .clube-contato-btn {
        background: #22c55e;
        color: #fff;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        width: 100%;
        margin-top: 8px;
    }
    .clube-contato-btn:hover {
        background: #15803d;
        color: #fff;
    }
</style>
<div class="clube-container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="clube-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('painel-parceiros.index') }}">Empresas Parceiras</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $classificado->titulo }}</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-lg-8">
            <div class="clube-card">
                <!-- Imagem/Logo Principal -->
                @if($classificado->imagens->count() > 0)
                    <div class="clube-carousel d-flex align-items-center justify-content-center" style="background: #faf9ff; min-height: 260px;">
                        <img src="{{ Storage::url($classificado->imagens[0]->caminho) }}" class="img-fluid" alt="Logo da empresa" style="width: 100%;">
                    </div>
                @else
                    <div class="d-flex justify-content-center align-items-center bg-secondary bg-opacity-10 clube-carousel" style="height: 180px;">
                        <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                    </div>
                @endif
                <div class="card-body position-relative">
                    @can('update', $classificado)
                        <a href="{{ route('painel-parceiros.edit', $classificado) }}" class="btn btn-sm" style="position: absolute; top: 18px; right: 24px; background: #7c3aed; color: #fff; border-radius: 22px; font-weight: 600; z-index: 2;">
                            <i class="fas fa-edit me-1"></i> Editar
                        </a>
                    @endcan
                    <h1 class="clube-title">{{ $classificado->titulo }}</h1>
                    <div class="clube-subtitle mb-3">
                        <i class="bi bi-geo-alt"></i> {{ $classificado->cidade }}, {{ $classificado->estado }}
                    </div>
                    @if($classificado->categoria)
                        <div class="mb-3"><span class="clube-info-label">Segmento:</span> {{ ucfirst($classificado->categoria) }}</div>
                    @endif
                    <div class="mt-4 mb-3">
                        <h5 class="clube-section-title">Clube de Vantagens</h5>
                        <p class="text-muted">{{ $classificado->descricao }}</p>
                    </div>
                    @if($classificado->beneficio)
                        <div class="alert alert-success p-3 mb-4" style="border-radius: 14px; font-size:1.08rem; font-weight:500;">
                            <i class="fas fa-gift me-2"></i>
                            <span><strong>Benefício exclusivo para associados:</strong> {{ $classificado->beneficio }}</span>
                        </div>
                    @endif
                    @if($classificado->site || $classificado->instagram || $classificado->facebook)
                        <div class="mt-4 mb-2">
                            <h5 class="clube-section-title">Redes e Contato</h5>
                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                @if($classificado->site)
                                    <a href="{{ $classificado->site }}" target="_blank" class="btn btn-outline-primary" style="border-radius: 24px; font-weight:600;">
                                        <i class="fas fa-globe me-1"></i> Site
                                    </a>
                                @endif
                                @if($classificado->instagram)
                                    <a href="{{ $classificado->instagram }}" target="_blank" class="btn btn-outline-danger" style="border-radius: 24px; font-weight:600;">
                                        <i class="fab fa-instagram me-1"></i> Instagram
                                    </a>
                                @endif
                                @if($classificado->facebook)
                                    <a href="{{ $classificado->facebook }}" target="_blank" class="btn btn-outline-primary" style="border-radius: 24px; font-weight:600;">
                                        <i class="fab fa-facebook me-1"></i> Facebook
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="clube-sidebar-card text-center">
                <div class="mb-3">
                    @if($classificado->imagens->count() > 0)
                        <img src="{{ Storage::url($classificado->imagens[0]->caminho) }}" alt="Logo da empresa" style="width: 80px; height: 80px; object-fit: contain; border-radius: 16px; background: #faf9ff;">
                    @else
                        <div class="d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: #faf9ff; border-radius: 16px; margin: 0 auto;">
                            <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                        </div>
                    @endif
                </div>
                <h4 class="mb-1" style="color: #7c3aed; font-weight: 700;">{{ $classificado->titulo }}</h4>
                @if($classificado->categoria)
                    <div class="mb-2 text-muted">{{ ucfirst($classificado->categoria) }}</div>
                @endif
                @if($classificado->telefone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $classificado->telefone) }}" class="btn clube-contato-btn mb-2 w-100" target="_blank">
                        <i class="fab fa-whatsapp me-2"></i>Fale com a empresa
                    </a>
                @endif
                @if($classificado->site)
                    <a href="{{ $classificado->site }}" target="_blank" class="btn btn-outline-primary w-100 mb-2" style="border-radius: 24px; font-weight:600;"><i class="fas fa-globe me-1"></i> Site</a>
                @endif
                @if($classificado->instagram)
                    <a href="{{ $classificado->instagram }}" target="_blank" class="btn btn-outline-danger w-100 mb-2" style="border-radius: 24px; font-weight:600;"><i class="fab fa-instagram me-1"></i> Instagram</a>
                @endif
                @if($classificado->facebook)
                    <a href="{{ $classificado->facebook }}" target="_blank" class="btn btn-outline-primary w-100 mb-2" style="border-radius: 24px; font-weight:600;"><i class="fab fa-facebook me-1"></i> Facebook</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
