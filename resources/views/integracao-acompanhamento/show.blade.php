@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detalhes da Sessão</h5>
                    <div>
                        @can('update', $sessao)
                            <a href="{{ route('integracao-acompanhamento.edit', $sessao) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                        @endcan
                        @can('delete', $sessao)
                            <form action="{{ route('integracao-acompanhamento.destroy', $sessao) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta sessão?')">
                                    <i class="fas fa-trash"></i> Excluir
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Mentor</h6>
                            <p>{{ $sessao->mentor->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Tipo de Sessão</h6>
                            <span class="badge bg-{{ $sessao->tipo == 'mentoria' ? 'primary' : ($sessao->tipo == 'feedback' ? 'info' : 'success') }}">
                                {{ ucfirst($sessao->tipo) }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Data e Hora</h6>
                            <p>{{ $sessao->data_agendada->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Duração</h6>
                            <p>{{ $sessao->duracao_minutos }} minutos</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-muted">Status</h6>
                            <span class="badge bg-{{ $sessao->status == 'agendado' ? 'warning' : ($sessao->status == 'realizado' ? 'success' : 'danger') }}">
                                {{ ucfirst($sessao->status) }}
                            </span>
                        </div>
                    </div>

                    @if($sessao->observacoes)
                        <div class="mb-4">
                            <h6 class="text-muted">Observações</h6>
                            <p class="text-break">{{ $sessao->observacoes }}</p>
                        </div>
                    @endif

                    @if($sessao->metas_definidas)
                        <div class="mb-4">
                            <h6 class="text-muted">Metas Definidas</h6>
                            <p class="text-break">{{ $sessao->metas_definidas }}</p>
                        </div>
                    @endif

                    @if($sessao->proximos_passos)
                        <div class="mb-4">
                            <h6 class="text-muted">Próximos Passos</h6>
                            <p class="text-break">{{ $sessao->proximos_passos }}</p>
                        </div>
                    @endif

                    @if($sessao->avaliacao)
                        <div class="mb-4">
                            <h6 class="text-muted">Avaliação de Desempenho</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Critério</th>
                                            <th>Avaliação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Liderança</td>
                                            <td>{{ $sessao->avaliacao->lideranca }}/5</td>
                                        </tr>
                                        <tr>
                                            <td>Comunicação</td>
                                            <td>{{ $sessao->avaliacao->comunicacao }}/5</td>
                                        </tr>
                                        <tr>
                                            <td>Trabalho em Equipe</td>
                                            <td>{{ $sessao->avaliacao->trabalho_equipe }}/5</td>
                                        </tr>
                                        <tr>
                                            <td>Proatividade</td>
                                            <td>{{ $sessao->avaliacao->proatividade }}/5</td>
                                        </tr>
                                        <tr>
                                            <td>Comprometimento</td>
                                            <td>{{ $sessao->avaliacao->comprometimento }}/5</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            @if($sessao->avaliacao->pontos_fortes)
                                <h6 class="text-muted mt-3">Pontos Fortes</h6>
                                <p class="text-break">{{ $sessao->avaliacao->pontos_fortes }}</p>
                            @endif

                            @if($sessao->avaliacao->areas_melhoria)
                                <h6 class="text-muted mt-3">Áreas para Melhoria</h6>
                                <p class="text-break">{{ $sessao->avaliacao->areas_melhoria }}</p>
                            @endif

                            @if($sessao->avaliacao->recomendacoes)
                                <h6 class="text-muted mt-3">Recomendações</h6>
                                <p class="text-break">{{ $sessao->avaliacao->recomendacoes }}</p>
                            @endif
                        </div>
                    @endif

                    @if($sessao->feedback)
                        <div class="mb-4">
                            <h6 class="text-muted">Feedback</h6>
                            <span class="badge bg-{{ $sessao->feedback->tipo == 'positivo' ? 'success' : ($sessao->feedback->tipo == 'construtivo' ? 'warning' : 'info') }}">
                                {{ ucfirst($sessao->feedback->tipo) }}
                            </span>
                            <p class="text-break mt-2">{{ $sessao->feedback->texto }}</p>

                            @if($sessao->feedback->acoes_recomendadas)
                                <h6 class="text-muted mt-3">Ações Recomendadas</h6>
                                <p class="text-break">{{ $sessao->feedback->acoes_recomendadas }}</p>
                            @endif

                            @if($sessao->feedback->prazo_implementacao)
                                <h6 class="text-muted mt-3">Prazo para Implementação</h6>
                                <p>{{ $sessao->feedback->prazo_implementacao->format('d/m/Y') }}</p>
                            @endif
                        </div>
                    @endif

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('integracao-acompanhamento.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 