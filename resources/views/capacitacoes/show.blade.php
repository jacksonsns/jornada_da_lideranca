@extends('layouts.app')

@section('title', $capacitacao->titulo . ' - Capacitações')

@push('styles')
<style>
    .caps-show-wrapper {
        padding: 2.5rem 2.5rem 1.5rem;
    }
    .caps-article-card {
        border-radius: 26px;
        border: none;
        background: radial-gradient(circle at 0 0, rgba(255,255,255,0.97), rgba(233,239,255,0.99));
        box-shadow: 0 22px 55px rgba(0,0,0,0.65);
        padding: 2rem 2rem 1.8rem;
    }
    .article-meta {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    .article-content {
        font-size: 1.05rem;
        line-height: 1.8;
        color: #343a40;
    }
    .article-content p { margin-bottom: 1.5rem; }
    .article-content img {
        max-width: 100%;
        height: auto;
        margin: 2rem 0;
    }
    .article-content h2,
    .article-content h3,
    .article-content h4 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: #1f2933;
    }
    .article-content ul,
    .article-content ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }
</style>
@endpush

@section('content')
<div class="caps-show-wrapper">
    <div class="container-fluid p-0 sm_padding_15px">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-9">
                <div class="mb-3">
                    <a href="{{ route('capacitacoes.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Voltar para Capacitações
                    </a>
                </div>
                <div class="caps-article-card">
                    <h1 class="display-5 mb-3">{{ $capacitacao->titulo }}</h1>
                    <div class="article-meta">
                        <i class="fas fa-calendar-alt"></i>
                        {{ $capacitacao->data->format('d/m/Y') }}
                    </div>
                    <article class="article-content">
                        {!! html_entity_decode($capacitacao->insights) !!}
                    </article>

                    @if($capacitacao->material_url)
                        <div class="mt-4 pt-3 border-top">
                            <h4 class="mb-3">Material de Apoio</h4>
                            <a href="{{ Storage::url($capacitacao->material_url) }}" 
                               class="btn btn-primary"
                               target="_blank">
                                <i class="fas fa-download me-2"></i>
                                Baixar Material
                            </a>
                        </div>
                    @endif

                    <div class="mt-5 pt-4 border-top">
                        <a href="{{ route('capacitacoes.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar para Capacitações
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection