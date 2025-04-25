@extends('layouts.app')

@section('content')
<div class="main_content_iner">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="white_card card_height_100 mb_30">
                    <div class="white_card_header">
                        <div class="box_header m-0">
                            <div class="main-title">
                                <h3 class="m-0">Detalhes do Desafio</h3>
                            </div>
                            <div class="float-right">
                                <a href="{{ route('desafios.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left"></i> Voltar para lista
                                </a>
                                <a href="{{ route('desafios.edit', $desafio) }}" class="btn btn-outline-info">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="white_card_body">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">{{ $desafio->titulo }}</h4>
                                <div class="mb-4">
                                    <span class="badge badge-{{ $desafio->status === 'concluído' ? 'success' : 'warning' }}">
                                        {{ ucfirst($desafio->status) }}
                                    </span>
                                    @if($desafio->data_limite)
                                        <span class="text-muted ml-3">
                                            Data Limite: {{ $desafio->data_limite->format('d/m/Y') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="card-text mb-4">
                                    {{ $desafio->descricao }}
                                </div>

                                @if($desafio->status !== 'concluído')
                                    <div class="mt-4 border-top pt-4">
                                        <form action="{{ route('desafios.concluir', $desafio) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-check"></i> Marcar como Concluído
                                            </button>
                                        </form>
                                    </div>
                                @endif

                                @if($desafio->created_at)
                                    <div class="mt-4 text-muted">
                                        <small>
                                            Criado em: {{ $desafio->created_at->format('d/m/Y H:i') }}
                                            @if($desafio->updated_at && $desafio->updated_at->ne($desafio->created_at))
                                                <br>
                                                Última atualização: {{ $desafio->updated_at->format('d/m/Y H:i') }}
                                            @endif
                                        </small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 