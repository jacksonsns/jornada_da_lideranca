@extends('layouts.app-admin')

@section('title', 'Área Financeira')

@push('styles')
<style>
    .finance-shell {
        min-height: 100vh;
        padding: 32px 16px;
        background: radial-gradient(circle at top left, rgba(88, 101, 242, 0.22), transparent 55%),
                    radial-gradient(circle at bottom right, rgba(56, 189, 248, 0.18), transparent 55%),
                    linear-gradient(135deg, #020617 0%, #020617 40%, #020617 100%);
        display: flex;
        align-items: stretch;
    }

    .finance-shell-inner {
        width: 100%;
        max-width: 1240px;
        margin: 0 auto;
    }

    .finance-header-row {
        margin-bottom: 1.5rem;
    }

    .finance-header-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #e5f0ff;
        letter-spacing: 0.01em;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .finance-header-title i {
        color: #bfdbfe;
    }

    .finance-header-subtitle {
        font-size: 0.86rem;
        color: rgba(226, 232, 240, 0.85);
        margin: 0.15rem 0 0;
    }

    .finance-cta {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 18px;
        border-radius: 999px;
        border: 1px solid rgba(226, 232, 240, 0.5);
        background: radial-gradient(circle at top left, rgba(248, 250, 252, 0.28), transparent 55%),
                    linear-gradient(135deg, #0ea5e9, #2563eb);
        color: #f9fafb;
        font-weight: 600;
        font-size: 0.88rem;
        box-shadow: 0 14px 40px rgba(37, 99, 235, 0.6);
        transition: all 0.18s ease-out;
    }

    .finance-cta:hover {
        transform: translateY(-1px) scale(1.01);
        box-shadow: 0 18px 55px rgba(37, 99, 235, 0.85);
        color: #ffffff;
    }

    .finance-cta i {
        font-size: 0.9rem;
    }

    .finance-summary-row {
        margin-bottom: 1.5rem;
    }

    .finance-summary-card {
        border-radius: 22px;
        padding: 14px 18px;
        border: 1px solid rgba(148, 163, 184, 0.5);
        background:
            radial-gradient(circle at top left, rgba(56, 189, 248, 0.16), transparent 60%),
            linear-gradient(135deg, rgba(15, 23, 42, 0.94), rgba(15, 23, 42, 0.98));
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        box-shadow: 0 18px 55px rgba(15, 23, 42, 0.9);
        color: #e5e7eb;
    }

    .finance-summary-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        color: rgba(148, 163, 184, 0.92);
        margin-bottom: 0.1rem;
    }

    .finance-summary-value {
        font-size: 1.35rem;
        font-weight: 700;
        margin: 0;
    }

    .finance-summary-receitas .finance-summary-value {
        color: #bbf7d0;
    }

    .finance-summary-despesas .finance-summary-value {
        color: #fecaca;
    }

    .finance-summary-saldo .finance-summary-value {
        color: #e0f2fe;
    }

    .finance-summary-tag {
        font-size: 0.72rem;
        border-radius: 999px;
        padding: 3px 9px;
        border: 1px solid rgba(148, 163, 184, 0.7);
        color: rgba(209, 213, 219, 0.9);
    }

    .finance-card-transacoes {
        border-radius: 26px;
        border: 1px solid rgba(148, 163, 184, 0.45);
        background:
            radial-gradient(circle at top left, rgba(56, 189, 248, 0.22), transparent 60%),
            radial-gradient(circle at bottom right, rgba(59, 130, 246, 0.25), transparent 60%),
            linear-gradient(135deg, rgba(15, 23, 42, 0.92), rgba(15, 23, 42, 0.97));
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        box-shadow: 0 24px 80px rgba(15, 23, 42, 0.9);
        overflow: hidden;
    }

    .finance-card-transacoes-body {
        padding: 18px 22px 22px;
    }

    .finance-table-wrapper {
        border-radius: 18px;
        border: 1px solid rgba(148, 163, 184, 0.35);
        overflow: hidden;
        background:
            radial-gradient(circle at top left, rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.98));
    }

    .finance-table {
        color: #e5e7eb;
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
        background-color: transparent;
    }

    .finance-table thead {
        background:
            linear-gradient(120deg, rgba(15, 23, 42, 0.96), rgba(30, 64, 175, 0.98));
    }

    .finance-table thead th {
        border-bottom: 1px solid rgba(148, 163, 184, 0.6);
        border-top: none;
        padding: 10px 14px;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: rgba(148, 163, 184, 0.96);
        font-weight: 600;
        white-space: nowrap;
    }

    .finance-table tbody tr {
        transition: all 0.14s ease-out;
        background: rgba(15, 23, 42, 0.9);
    }

    .finance-table tbody tr:nth-child(even) {
        background: rgba(15, 23, 42, 0.96);
    }

    .finance-table tbody tr:hover {
        background: linear-gradient(90deg, rgba(30, 64, 175, 0.72), rgba(15, 23, 42, 0.98));
        transform: translateY(-1px);
    }

    .finance-table tbody td {
        border-top: 1px solid rgba(30, 64, 175, 0.5);
        padding: 9px 14px;
        font-size: 0.88rem;
        vertical-align: middle;
    }

    .finance-valor-receita {
        color: #bbf7d0 !important;
        font-weight: 600;
    }

    .finance-valor-despesa {
        color: #fecaca !important;
        font-weight: 600;
    }

    .finance-table-actions .btn {
        min-width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: 0;
        border: 1px solid transparent;
        font-size: 0.82rem;
        transition: all 0.16s ease-out;
    }

    .finance-btn-view {
        background: linear-gradient(135deg, #22c55e, #0ea5e9);
        border-color: rgba(187, 247, 208, 0.85);
        color: #ecfdf5;
        box-shadow: 0 10px 26px rgba(34, 197, 94, 0.6);
    }

    .finance-btn-edit {
        background: linear-gradient(135deg, #fbbf24, #f97316);
        border-color: rgba(254, 243, 199, 0.9);
        color: #1f2937;
        box-shadow: 0 10px 26px rgba(251, 191, 36, 0.7);
    }

    .finance-btn-delete {
        background: linear-gradient(135deg, #f97316, #dc2626);
        border-color: rgba(254, 202, 202, 0.9);
        color: #fef2f2;
        box-shadow: 0 10px 26px rgba(220, 38, 38, 0.6);
    }

    .finance-btn-view:hover,
    .finance-btn-edit:hover,
    .finance-btn-delete:hover {
        transform: translateY(-1px) scale(1.03);
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.85);
        color: #ffffff;
    }

    /* Modal Nova Transação */
    .finance-modal-content {
        background:
            radial-gradient(circle at top left, rgba(56, 189, 248, 0.22), transparent 55%),
            radial-gradient(circle at bottom right, rgba(59, 130, 246, 0.22), transparent 55%),
            linear-gradient(135deg, rgba(15, 23, 42, 0.96), rgba(15, 23, 42, 0.98));
        border-radius: 22px;
        border: 1px solid rgba(148, 163, 184, 0.65);
        box-shadow: 0 26px 80px rgba(15, 23, 42, 0.95);
        overflow: hidden;
        color: #e5e7eb;
    }

    .finance-modal-header {
        background: linear-gradient(120deg, rgba(37, 99, 235, 0.98), rgba(79, 70, 229, 0.98));
        border-bottom: 1px solid rgba(148, 163, 184, 0.7);
        padding: 14px 18px;
        color: #eff6ff;
    }

    .finance-modal-body {
        padding: 18px 20px 16px;
    }

    .finance-modal-footer {
        border-top: 1px solid rgba(148, 163, 184, 0.6);
        padding: 12px 18px 14px;
        background: rgba(15, 23, 42, 0.92);
    }

    .finance-input,
    .finance-select {
        background: rgba(15, 23, 42, 0.9);
        border-radius: 999px;
        border: 1px solid rgba(148, 163, 184, 0.7);
        color: #e5e7eb;
        font-size: 0.9rem;
        padding: 8px 14px;
    }

    .finance-input:focus,
    .finance-select:focus {
        background: rgba(15, 23, 42, 0.98);
        border-color: rgba(59, 130, 246, 0.9);
        box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.9);
        color: #f9fafb;
    }

    textarea.finance-input {
        border-radius: 18px;
        min-height: 90px;
        resize: vertical;
    }

    .finance-input-group-text {
        background: rgba(15, 23, 42, 0.9);
        border-radius: 999px 0 0 999px;
        border: 1px solid rgba(148, 163, 184, 0.7);
        border-right: none;
        color: rgba(209, 213, 219, 0.9);
    }

    .finance-btn-modal-secondary {
        border-radius: 999px;
        padding: 7px 16px;
        font-size: 0.86rem;
        font-weight: 500;
        border: 1px solid rgba(148, 163, 184, 0.7);
        background: rgba(15, 23, 42, 0.8);
        color: rgba(209, 213, 219, 0.9);
        transition: all 0.16s ease-out;
    }

    .finance-btn-modal-secondary:hover {
        background: rgba(15, 23, 42, 0.95);
        color: #e5e7eb;
    }

    .finance-btn-modal-primary {
        border-radius: 999px;
        padding: 7px 18px;
        font-size: 0.88rem;
        font-weight: 600;
        border: 1px solid rgba(191, 219, 254, 0.8);
        background: linear-gradient(135deg, #0ea5e9, #22c55e);
        color: #f9fafb;
        box-shadow: 0 12px 30px rgba(34, 197, 94, 0.7);
        transition: all 0.16s ease-out;
    }

    .finance-btn-modal-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 16px 40px rgba(34, 197, 94, 0.9);
        color: #ffffff;
    }

    @media (max-width: 991.98px) {
        .finance-shell {
            padding: 18px 10px 24px;
        }

        .finance-card-transacoes {
            border-radius: 22px;
        }
    }

    @media (max-width: 575.98px) {
        .finance-shell {
            padding-top: 16px;
        }

        .finance-card-transacoes-body {
            padding: 14px 12px 16px;
        }

        .finance-table thead th,
        .finance-table tbody td {
            padding: 8px 8px;
        }
    }
</style>
@endpush

@section('content')
<div class="finance-shell">
    <div class="finance-shell-inner">
        <div class="row finance-header-row">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h2 class="finance-header-title mb-0">
                            <i class="fas fa-wallet"></i>
                            Área Financeira
                        </h2>
                        <p class="finance-header-subtitle">Visualize rapidamente receitas, despesas, saldo e gerencie suas transações.</p>
                    </div>
                    <button type="button" class="btn finance-cta" data-bs-toggle="modal" data-bs-target="#novaTransacaoModal">
                        <i class="fas fa-plus"></i>
                        Nova Transação
                    </button>
                </div>
            </div>
        </div>

        <!-- Resumo Financeiro -->
        <div class="row finance-summary-row g-3">
            <div class="col-md-4">
                <div class="finance-summary-card finance-summary-receitas d-flex justify-content-between align-items-center">
                    <div>
                        <div class="finance-summary-label">Receitas</div>
                        <p class="finance-summary-value">R$ {{ number_format($receitas, 2, ',', '.') }}</p>
                    </div>
                    <span class="finance-summary-tag">Entradas</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="finance-summary-card finance-summary-despesas d-flex justify-content-between align-items-center">
                    <div>
                        <div class="finance-summary-label">Despesas</div>
                        <p class="finance-summary-value">R$ {{ number_format($despesas, 2, ',', '.') }}</p>
                    </div>
                    <span class="finance-summary-tag">Saídas</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="finance-summary-card finance-summary-saldo d-flex justify-content-between align-items-center">
                    <div>
                        <div class="finance-summary-label">Saldo</div>
                        <p class="finance-summary-value">R$ {{ number_format($saldo, 2, ',', '.') }}</p>
                    </div>
                    <span class="finance-summary-tag">Atual</span>
                </div>
            </div>
        </div>

        <!-- Lista de Transações -->
        <div class="card finance-card-transacoes">
            <div class="finance-card-transacoes-body">
                <div class="table-responsive finance-table-wrapper">
                    <table class="table table-hover mb-0 finance-table">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Descrição</th>
                                <th>Categoria</th>
                                <th>Tipo</th>
                                <th>Valor</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transacoes as $transacao)
                            <tr>
                                <td>{{ $transacao->data->format('d/m/Y') }}</td>
                                <td>{{ $transacao->descricao }}</td>
                                <td>{{ ucfirst($transacao->categoria) }}</td>
                                <td>{!! $transacao->tipo_badge !!}</td>
                                <td class="{{ $transacao->tipo === 'receita' ? 'finance-valor-receita' : 'finance-valor-despesa' }}">
                                    R$ {{ number_format($transacao->valor, 2, ',', '.') }}
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2 finance-table-actions">
                                        <a href="{{ route('area-financeira.show', $transacao) }}" class="btn btn-sm finance-btn-view">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('area-financeira.edit', $transacao) }}" class="btn btn-sm finance-btn-edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('area-financeira.destroy', $transacao) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm finance-btn-delete" onclick="return confirm('Tem certeza que deseja excluir esta transação?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nova Transação -->
<div class="modal fade" id="novaTransacaoModal" tabindex="-1" aria-labelledby="novaTransacaoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content finance-modal-content">
            <div class="modal-header finance-modal-header">
                <h5 class="modal-title text-light d-flex align-items-center gap-2" id="novaTransacaoModalLabel">
                    <i class="fas fa-plus-circle"></i>
                    Nova Transação
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('area-financeira.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body finance-modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select class="form-select finance-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
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
                                <span class="input-group-text finance-input-group-text">R$</span>
                                <input type="number" class="form-control finance-input @error('valor') is-invalid @enderror" 
                                       id="valor" name="valor" step="0.01" min="0" value="{{ old('valor') }}" required>
                            </div>
                            @error('valor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <input type="text" class="form-control finance-input @error('descricao') is-invalid @enderror" 
                                   id="descricao" name="descricao" value="{{ old('descricao') }}" required>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="data" class="form-label">Data</label>
                            <input type="date" class="form-control finance-input @error('data') is-invalid @enderror" 
                                   id="data" name="data" value="{{ old('data', date('Y-m-d')) }}" required>
                            @error('data')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="categoria" class="form-label">Categoria</label>
                            <select class="form-select finance-select @error('categoria') is-invalid @enderror" id="categoria" name="categoria" required>
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
                            <input type="file" class="form-control finance-input @error('comprovante') is-invalid @enderror" 
                                   id="comprovante" name="comprovante" accept="image/*,.pdf">
                            @error('comprovante')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="observacoes" class="form-label">Observações</label>
                            <textarea class="form-control finance-input @error('observacoes') is-invalid @enderror" 
                                      id="observacoes" name="observacoes" rows="3">{{ old('observacoes') }}</textarea>
                            @error('observacoes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer finance-modal-footer">
                    <button type="button" class="btn finance-btn-modal-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn finance-btn-modal-primary">Salvar</button>
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