@extends('layouts.app-admin')

@section('content')
<div class="main_content_iner">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="QA_section">
                    <div class="white_box_tittle list_header d-flex justify-content-between align-items-center">
                        <h4>Gerenciar Usuário</h4>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">← Voltar</a>
                    </div>

                    <div class="QA_table mb_30">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="w-100 mb-5">
                            <div class="card shadow-lg">
                                <div class="card-header bg-dark text-white text-center">
                                    <h4 class="text-light">Pontuação do Usuário</h4>
                                </div>
                                <div class="card-body text-center">
                                    <i class="fas fa-medal fa-3x text-warning"></i>
                                    <h3>{{ $totalPontos }} Pontos</h3>
                                </div>
                            </div>
                        </div>

                        {{-- Desafio Junior --}}
                        <div class="card shadow-lg mb-5">
                            <div class="card-header bg-primary text-white text-center">
                                <h4 class="text-light">🔥 Desafio Junior</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-primary text-center">
                                            <tr>
                                                <th>Título</th>
                                                <th>Pontuação</th>
                                                <th>Status</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($desafios as $desafioUser)
                                                <tr class="align-middle text-center">
                                                    <td class="text-start">{{ $desafioUser->descricao }}</td>
                                                    <td>
                                                        <span class="badge badge bg-{{ $desafioUser->pontos < 0 ? 'danger' : 'success' }}">
                                                        {{ $desafioUser->pontos > 0 ? '+' . $desafioUser->pontos : $desafioUser->pontos }} pts
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($desafioUser->concluido)
                                                            <span class="text-success">✅ Concluído</span>
                                                        @else
                                                            <span class="text-danger">⏳ Pendente</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($desafioUser->concluido)
                                                            <form action="{{ route('remover-pontuacao-desafio-junior') }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <input type="hidden" name="desafio_id" value="{{ $desafioUser->desafio_user_id }}">
                                                                <button type="submit" class="btn btn-sm btn-outline-danger">Remover pontuação</button>
                                                            </form>
                                                        @else
                                                            <form action="{{ route('add-pontuacao-desafio-junior') }}" method="POST" class="inline">
                                                                @csrf
                                                                <input type="text" value="{{ $desafioUser->desafio_user_id }}" name="desafio_id" hidden>
                                                                <button type="submit" class="btn btn-sm btn-outline-success">Marcar como concluído</button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">Nenhum desafio encontrado.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- Jornada Aspirantes --}}
                        <div class="card shadow-lg mb-5">
                            <div class="card-header bg-primary text-white text-center">
                                <h4 class="text-light">🔥 Desafios Jornada Aspirantes</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-primary text-center">
                                            <tr>
                                                <th>Título</th>
                                                <th>Pontuação</th>
                                                <th>Status</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($desafiosJornada as $desafio)
                                                <tr class="align-middle text-center">
                                                    <td class="text-start">{{ $desafio->descricao }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $desafio->pontos < 0 ? 'danger' : 'success' }}">
                                                            {{ $desafio->pontos > 0 ? '+' . $desafio->pontos : $desafio->pontos }} pts
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($desafio->concluido)
                                                            <span class="text-success">✅ Concluído</span>
                                                        @else
                                                            <span class="text-danger">⏳ Pendente</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($desafio->concluido)
                                                            <form action="{{ route('remover-pontuacao-jornada') }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <input type="hidden" name="desafio_id" value="{{ $desafio->desafio_user_id }}">
                                                                <button type="submit" class="btn btn-sm btn-outline-danger">Remover pontuação</button>
                                                            </form>
                                                        @else
                                                            <form action="{{ route('add-pontuacao-jornada') }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <input type="hidden" name="desafio_id" value="{{ $desafio->desafio_user_id }}">
                                                                <button type="submit" class="btn btn-sm btn-outline-success">Marcar como concluído</button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">Nenhum desafio encontrado.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div> <!-- QA_table -->
                </div> <!-- QA_section -->
            </div>
        </div>
    </div>
</div>
@endsection
