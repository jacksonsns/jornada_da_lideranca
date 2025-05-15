@extends('layouts.app')

@section('title', 'Capacitações')

@section('content')
<div class="container">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">Capacitações</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="row">
                @forelse($capacitacoes as $capacitacao)
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title text-success">
                                        <i class="fas fa-book"></i> {{ $capacitacao->titulo }}
                                    </h5>
                                    <span class="badge bg-primary">
                                        {{ $capacitacao->data->format('d/m/Y') }}
                                    </span>
                                </div>
                                <p class="card-text">
                                    {{ Str::limit(strip_tags($capacitacao->insights), 150) }}
                                </p>
                                <a href="{{ route('capacitacoes.show', $capacitacao->id) }}" class="btn btn-outline-success btn-sm">
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