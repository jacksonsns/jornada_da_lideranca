@extends('layouts.app')

@section('title', 'Capacitações')

@push('styles')
<style>
    .caps-page-wrapper {
        padding: 2.5rem 2.5rem 1.5rem;
    }
    .caps-main-card {
        border-radius: 26px;
        border: none;
        background: radial-gradient(circle at 0 0, rgba(255,255,255,0.96), rgba(233,239,255,0.98));
        box-shadow: 0 22px 55px rgba(0,0,0,0.65);
        padding: 1.75rem 1.75rem 1.5rem;
    }
    .caps-main-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #102347;
        margin-bottom: 1.25rem;
    }
    .caps-card {
        position: relative;
        overflow: hidden;
        border-radius: 18px;
        border: none;
        background: radial-gradient(circle at 0 0, rgba(255,255,255,0.9), rgba(229,235,255,0.96));
        box-shadow: 0 16px 40px rgba(0,0,0,0.45);
    }
    .caps-card .card-title {
        font-weight: 600;
        color: #0d2348;
    }
    .caps-card .card-text {
        font-size: 0.95rem;
        color: #4b5563;
    }
    .caps-badge-date {
        background: linear-gradient(135deg,#1b7aff,#33b3ff);
        color: #fff;
        border-radius: 999px;
        padding-inline: 0.9rem;
    }
</style>
@endpush

@section('content')
<div class="caps-page-wrapper">
    <div class="container-fluid p-0 sm_padding_15px">
        <div class="caps-main-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="caps-main-title mb-0">Capacitações</h3>
            </div>
            <div class="row">
                @forelse($capacitacoes as $capacitacao)
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 caps-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title">
                                        <i class="fas fa-book"></i> {{ $capacitacao->titulo }}
                                    </h5>
                                    <span class="badge caps-badge-date">
                                        {{ $capacitacao->data->format('d/m/Y') }}
                                    </span>
                                </div>
                                <p class="card-text">
                                    {{ Str::limit(strip_tags($capacitacao->insights), 150) }}
                                </p>
                                @if($capacitacao->material_url)
                                    <div class="mt-2">
                                        <a href="{{ Storage::url($capacitacao->material_url) }}" 
                                           class="btn btn-outline-primary btn-sm"
                                           target="_blank">
                                            <i class="fas fa-download me-1"></i> Material de Apoio
                                        </a>
                                    </div>
                                @endif
                                <a href="{{ route('capacitacoes.show', $capacitacao->id) }}" class="btn btn-primary btn-sm mt-2">
                                    Ler mais
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            Nenhuma capacitação disponível no momento.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection