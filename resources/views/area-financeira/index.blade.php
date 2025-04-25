@extends('layouts.app')

@section('title', 'Área Financeira')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Área Financeira</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#novaTransacaoModal">
                    <i class="fas fa-plus"></i> Nova Transação
                </button>
            </div>
        </div>
    </div>

    <!-- Resumo Financeiro -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Receitas</h5>
                    <h3 class="card-text">R$ {{ number_format($receitas, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Despesas</h5>
                    <h3 class="card-text">R$ {{ number_format($despesas, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Saldo</h5>
                    <h3 class="card-text">R$ {{ number_format($saldo, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Transações -->
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Descrição</th>
                            <th>Categoria</th>
                            <th>Tipo</th>
                            <th>Valor</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transacoes as $transacao)
                        <tr>
                            <td>{{ $transacao->data->format('d/m/Y') }}</td>
                            <td>{{ $transacao->descricao }}</td>
                            <td>{{ ucfirst($transacao->categoria) }}</td>
                            <td>{!! $transacao->tipo_badge !!}</td>
                            <td class="{{ $transacao->tipo === 'receita' ? 'text-success' : 'text-danger' }}">
                                R$ {{ number_format($transacao->valor, 2, ',', '.') }}
                            </td>
                            <td>
                                <a href="{{ route('area-financeira.show', $transacao) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('area-financeira.edit', $transacao) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('area-financeira.destroy', $transacao) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta transação?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nova Transação -->
<div class="modal fade" id="novaTransacaoModal" tabindex="-1" aria-labelledby="novaTransacaoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="novaTransacaoModalLabel">Nova Transação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('area-financeira.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                                <option value="">Selecione o tipo</option>
                                <option value="receita" {{ old('tipo') == 'receita' ? 'selected' : '' }}>Receita</option>
                                <option value="despesa" {{ old('tipo') == 'despesa' ? 'selected' : '' }}>Despesa</option>
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="valor" class="form-label">Valor</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="number" class="form-control @error('valor') is-invalid @enderror" 
                                       id="valor" name="valor" step="0.01" min="0" value="{{ old('valor') }}" required>
                            </div>
                            @error('valor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <input type="text" class="form-control @error('descricao') is-invalid @enderror" 
                                   id="descricao" name="descricao" value="{{ old('descricao') }}" required>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="data" class="form-label">Data</label>
                            <input type="date" class="form-control @error('data') is-invalid @enderror" 
                                   id="data" name="data" value="{{ old('data', date('Y-m-d')) }}" required>
                            @error('data')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="categoria" class="form-label">Categoria</label>
                            <select class="form-select @error('categoria') is-invalid @enderror" id="categoria" name="categoria" required>
                                <option value="">Selecione a categoria</option>
                                <option value="salario" {{ old('categoria') == 'salario' ? 'selected' : '' }}>Salário</option>
                                <option value="bonus" {{ old('categoria') == 'bonus' ? 'selected' : '' }}>Bônus</option>
                                <option value="investimento" {{ old('categoria') == 'investimento' ? 'selected' : '' }}>Investimento</option>
                                <option value="alimentacao" {{ old('categoria') == 'alimentacao' ? 'selected' : '' }}>Alimentação</option>
                                <option value="transporte" {{ old('categoria') == 'transporte' ? 'selected' : '' }}>Transporte</option>
                                <option value="moradia" {{ old('categoria') == 'moradia' ? 'selected' : '' }}>Moradia</option>
                                <option value="outros" {{ old('categoria') == 'outros' ? 'selected' : '' }}>Outros</option>
                            </select>
                            @error('categoria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="comprovante" class="form-label">Comprovante</label>
                            <input type="file" class="form-control @error('comprovante') is-invalid @enderror" 
                                   id="comprovante" name="comprovante" accept="image/*,.pdf">
                            @error('comprovante')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="observacoes" class="form-label">Observações</label>
                            <textarea class="form-control @error('observacoes') is-invalid @enderror" 
                                      id="observacoes" name="observacoes" rows="3">{{ old('observacoes') }}</textarea>
                            @error('observacoes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Reset form quando o modal é fechado
    document.getElementById('novaTransacaoModal').addEventListener('hidden.bs.modal', function () {
        this.querySelector('form').reset();
    });
</script>
@endpush 