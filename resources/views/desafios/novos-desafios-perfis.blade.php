@extends('layouts.app-admin')

@push('styles')
<style>
    .perfil-bg {
        background: #f4f7fb;
    }
    .perfil-title {
        font-weight: 700;
        color: #1b3150;
    }
    .perfil-subtitle {
        color: #718096;
        font-size: 0.95rem;
    }
    .perfil-card {
        border-radius: 22px;
        border: none;
        box-shadow: 0 14px 40px rgba(15, 35, 95, 0.06);
        padding-top: 26px;
        padding-bottom: 22px;
        cursor: pointer;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .perfil-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 50px rgba(15, 35, 95, 0.12);
    }
    .perfil-avatar-wrapper {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(145deg, #2563eb, #3b82f6);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 14px auto;
    }
    .perfil-avatar-wrapper img {
        width: 46px;
        height: 46px;
        object-fit: contain;
    }
    .perfil-nome {
        font-weight: 700;
        color: #1f2933;
        margin-bottom: 2px;
    }
    .perfil-cargo {
        font-size: 0.9rem;
        color: #7b8794;
    }
    .perfil-metricas {
        margin-top: 12px;
        font-size: 0.9rem;
    }
    .perfil-metricas strong {
        font-size: 1.1rem;
    }
    .perfil-metricas span {
        display: block;
        color: #9fb3c8;
        font-size: 0.8rem;
    }
    .perfil-selo {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 10px;
    }
    .selo-ouro {
        background: #fff7d6;
        color: #b7791f;
    }
    .selo-prata {
        background: #edf2f7;
        color: #4a5568;
    }
    .selo-bronze {
        background: #fde8df;
        color: #c05621;
    }
    .selo-diamante {
        background: #e6fffb;
        color: #0b8a89;
    }

    .btn-visao-admin {
        border-radius: 999px;
        padding: 10px 24px;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
    }
    .btn-visao-admin i {
        margin-right: 6px;
    }
</style>
@endpush

@section('content')
<div class="main_content_iner perfil-bg">
    <div class="container-fluid p-0 sm_padding_15px">
        <div class="row justify-content-center mb-4 mb-md-5">
            <div class="col-lg-8 text-center mt-3">
                <h3 class="perfil-title mb-2">Quem está acessando?</h3>
                <p class="perfil-subtitle">Escolha um perfil para ver suas entregas e tarefas</p>
            </div>
        </div>

        <div class="row justify-content-center g-3 g-md-4 mb-4">
            @foreach($usuarios as $usuario)
                @php
                    $pontos = $usuario->pontos;
                    if ($pontos >= 1000) {
                        $nivel = 'diamante';
                        $seloClasse = 'selo-diamante';
                    } elseif ($pontos >= 800) {
                        $nivel = 'ouro';
                        $seloClasse = 'selo-ouro';
                    } elseif ($pontos >= 500) {
                        $nivel = 'prata';
                        $seloClasse = 'selo-prata';
                    } else {
                        $nivel = 'bronze';
                        $seloClasse = 'selo-bronze';
                    }
                    $seloLabel = ucfirst($nivel);
                @endphp
                <div class="col-md-4 col-lg-3">
                    <a href="{{ route('visao-adm.usuario', $usuario->id) }}" class="text-decoration-none text-dark">
                    <div class="card perfil-card text-center">
                        <div class="perfil-avatar-wrapper">
                            <img src="{{ $usuario->avatar_url }}" alt="{{ $usuario->nome }}">
                        </div>
                        <div class="card-body pt-0">
                            <div class="perfil-nome">{{ $usuario->nome }}</div>
                            <div class="perfil-cargo">{{ $usuario->cargo }}</div>
                            <div class="row perfil-metricas mt-3">
                                <div class="col-6">
                                    <strong class="text-primary">{{ $usuario->pontos }}</strong>
                                    <span>Pontos</span>
                                </div>
                                <div class="col-6">
                                    <strong class="text-warning">{{ $usuario->projetos }}</strong>
                                    <span>Projetos</span>
                                </div>
                            </div>
                            <span class="perfil-selo {{ $seloClasse }}">{{ $seloLabel }}</span>
                        </div>
                    </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="row justify-content-center mt-2 mb-4">
            <div class="col-auto">
                {{ $usuarios->links() }}
            </div>
        </div>

        <div class="row justify-content-center mt-3 mb-4">
            <div class="col-auto">
                <a href="{{ route('visao-adm.index') }}" class="btn btn-light btn-visao-admin">
                    <i class="fas fa-user-shield"></i>
                    Ver Visão Administrativa
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
