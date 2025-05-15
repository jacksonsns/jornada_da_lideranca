@extends('layouts.app-admin')

@section('title', 'Detalhes da Transação')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Detalhes da Transação</h2>
                <div>
                    <a href="{{ route('area-financeira.edit', $transacao) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('area-financeira.destroy', $transacao) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta transação?')">
                            <i class="fas fa-trash"></i> Excluir
                        </button>
                    </form>
                    <a href="{{ route('area-financeira.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Informações Básicas</h5>
                    <table class="table">
                        <tr>
                            <th>Tipo:</th>
                            <td>
                                <span class="badge {{ $transacao->tipo === 'receita' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($transacao->tipo) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Valor:</th>
                            <td class="{{ $transacao->tipo === 'receita' ? 'text-success' : 'text-danger' }}">
                                R$ {{ number_format($transacao->valor, 2, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <th>Data:</th>
                            <td>{{ $transacao->data->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Categoria:</th>
                            <td>{{ ucfirst($transacao->categoria) }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <span class="badge bg-{{ $transacao->status === 'aprovado' ? 'success' : ($transacao->status === 'pendente' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($transacao->status) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>Detalhes Adicionais</h5>
                    <table class="table">
                        <tr>
                            <th>Descrição:</th>
                            <td>{{ $transacao->descricao }}</td>
                        </tr>
                        <tr>
                            <th>Observações:</th>
                            <td>{{ $transacao->observacoes ?? 'Nenhuma observação' }}</td>
                        </tr>
                        @if($transacao->comprovante)
                        <tr>
                            <th>Comprovante:</th>
                            <td>
                                <a href="{{ Storage::url($transacao->comprovante) }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-file"></i> Ver Comprovante
                                </a>
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 