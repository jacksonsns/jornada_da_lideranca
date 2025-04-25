@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Meus Projetos Individuais</h5>
                    <div>
                        <a href="{{ route('projetos-individuais.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Novo Projeto
                        </a>
                    </div>
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
                                    <th>Título</th>
                                    <th>Status</th>
                                    <th>Progresso</th>
                                    <th>Data Início</th>
                                    <th>Data Fim</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($projetos as $projeto)
                                    <tr>
                                        <td>{{ $projeto->titulo }}</td>
                                        <td>{!! $projeto->status_badge !!}</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $projeto->progresso }}%">
                                                    {{ $projeto->progresso }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $projeto->data_inicio->format('d/m/Y') }}</td>
                                        <td>{{ $projeto->data_fim->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('projetos-individuais.show', $projeto) }}" class="btn btn-sm btn-info" title="Ver detalhes">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @can('update', $projeto)
                                                <a href="{{ route('projetos-individuais.edit', $projeto) }}" class="btn btn-sm btn-primary" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('delete', $projeto)
                                                <form action="{{ route('projetos-individuais.destroy', $projeto) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este projeto?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Nenhum projeto encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $projetos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 