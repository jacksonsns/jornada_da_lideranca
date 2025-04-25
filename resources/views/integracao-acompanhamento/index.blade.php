@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Sessões de Integração e Acompanhamento</h5>
                    @can('create', App\Models\IntegracaoAcompanhamento::class)
                        <a href="{{ route('integracao-acompanhamento.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Nova Sessão
                        </a>
                    @endcan
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Mentor</th>
                                    <th>Tipo</th>
                                    <th>Status</th>
                                    <th>Duração</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sessoes as $sessao)
                                    <tr>
                                        <td>{{ $sessao->data_agendada->format('d/m/Y H:i') }}</td>
                                        <td>{{ $sessao->mentor->name }}</td>
                                        <td>
                                            @switch($sessao->tipo)
                                                @case('mentoria')
                                                    <span class="badge bg-primary">Mentoria</span>
                                                    @break
                                                @case('feedback')
                                                    <span class="badge bg-info">Feedback</span>
                                                    @break
                                                @case('avaliacao')
                                                    <span class="badge bg-warning">Avaliação</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            @switch($sessao->status)
                                                @case('agendado')
                                                    <span class="badge bg-secondary">Agendado</span>
                                                    @break
                                                @case('realizado')
                                                    <span class="badge bg-success">Realizado</span>
                                                    @break
                                                @case('cancelado')
                                                    <span class="badge bg-danger">Cancelado</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>{{ $sessao->duracao_minutos }} min</td>
                                        <td>
                                            <a href="{{ route('integracao-acompanhamento.show', $sessao) }}" class="btn btn-sm btn-info" title="Ver detalhes">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @can('update', $sessao)
                                                <a href="{{ route('integracao-acompanhamento.edit', $sessao) }}" class="btn btn-sm btn-primary" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('delete', $sessao)
                                                <form action="{{ route('integracao-acompanhamento.destroy', $sessao) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir esta sessão?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Nenhuma sessão encontrada.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $sessoes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 