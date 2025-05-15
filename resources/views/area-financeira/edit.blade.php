@extends('layouts.app-admin')

@section('title', 'Editar Transação')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Editar Transação</h2>
                <a href="{{ route('area-financeira.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('area-financeira.update', $transacao) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                            <option value="receita" {{ $transacao->tipo == 'receita' ? 'selected' : '' }}>Receita</option>
                            <option value="despesa" {{ $transacao->tipo == 'despesa' ? 'selected' : '' }}>Despesa</option>
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
                                   id="valor" name="valor" step="0.01" min="0" 
                                   value="{{ old('valor', $transacao->valor) }}" required>
                        </div>
                        @error('valor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <input type="text" class="form-control @error('descricao') is-invalid @enderror" 
                               id="descricao" name="descricao" 
                               value="{{ old('descricao', $transacao->descricao) }}" required>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="data" class="form-label">Data</label>
                        <input type="date" class="form-control @error('data') is-invalid @enderror" 
                               id="data" name="data" 
                               value="{{ old('data', $transacao->data->format('Y-m-d')) }}" required>
                        @error('data')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="categoria" class="form-label">Categoria</label>
                        <select class="form-select @error('categoria') is-invalid @enderror" id="categoria" name="categoria" required>
                            <option value="">Selecione a categoria</option>
                            <option value="salario" {{ $transacao->categoria == 'salario' ? 'selected' : '' }}>Salário</option>
                            <option value="bonus" {{ $transacao->categoria == 'bonus' ? 'selected' : '' }}>Bônus</option>
                            <option value="investimento" {{ $transacao->categoria == 'investimento' ? 'selected' : '' }}>Investimento</option>
                            <option value="alimentacao" {{ $transacao->categoria == 'alimentacao' ? 'selected' : '' }}>Alimentação</option>
                            <option value="transporte" {{ $transacao->categoria == 'transporte' ? 'selected' : '' }}>Transporte</option>
                            <option value="moradia" {{ $transacao->categoria == 'moradia' ? 'selected' : '' }}>Moradia</option>
                            <option value="outros" {{ $transacao->categoria == 'outros' ? 'selected' : '' }}>Outros</option>
                        </select>
                        @error('categoria')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="comprovante" class="form-label">Novo Comprovante</label>
                        <input type="file" class="form-control @error('comprovante') is-invalid @enderror" 
                               id="comprovante" name="comprovante" accept="image/*,.pdf">
                        @error('comprovante')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($transacao->comprovante)
                            <div class="mt-2">
                                <a href="{{ Storage::url($transacao->comprovante) }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-file"></i> Ver Comprovante Atual
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea class="form-control @error('observacoes') is-invalid @enderror" 
                                  id="observacoes" name="observacoes" rows="3">{{ old('observacoes', $transacao->observacoes) }}</textarea>
                        @error('observacoes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 