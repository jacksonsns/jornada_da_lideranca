@extends('layouts.app')

@push('styles')
<style>
    .tevep-bg { background:#f4f7fb; }
    .tevep-header { border-radius:18px; background:linear-gradient(135deg,#2563eb,#3b82f6); color:#fff; padding:18px 22px; box-shadow:0 12px 40px rgba(15,35,95,0.2); }
    .tevep-title { font-size:1.25rem; font-weight:600; }
    .tevep-subtitle { font-size:0.85rem; opacity:.9; }
    .tevep-progress { font-size:0.9rem; }
    .section-card { border-radius:18px; border:none; box-shadow:0 10px 30px rgba(15,35,95,0.05); margin-bottom:18px; }
    .section-title { font-weight:600; font-size:0.95rem; }
</style>
@endpush

@section('content')
<div class="main_content_iner tevep-bg">
    <div class="container-fluid p-0 sm_padding_15px">
        <div class="row mb-2">
            <div class="col-6 text-end d-flex justify-content-end align-items-center gap-2">
                <div class="text-end">
                    <div class="fw-semibold">{{ $desafioUser->desafio->titulo ?? $desafioUser->desafio->descricao }}</div>
                </div>
            </div>
        </div>

        @if(session('sucesso'))
            <div class="alert alert-success">{{ session('sucesso') }}</div>
        @endif

        @if(session('erro'))
            <div class="alert alert-danger">{{ session('erro') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row mb-3">
            <div class="col-12">
                <div class="tevep-header d-flex justify-content-between align-items-center">
                    <div>
                        <div class="tevep-title">TEVEP - Projeto em Uma Folha</div>
                        <div class="tevep-subtitle">Tempo • Espaço • Valor • Expectativa • Pessoas</div>
                    </div>
                    <div class="text-end tevep-progress">
                        <div class="fw-bold">0%</div>
                        <small>0 ações</small>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('tevep.update', ['user' => $usuario->id, 'desafioUser' => $desafioUser->id]) }}">
            @csrf
            @method('PUT')

            <div class="card section-card">
                <div class="card-body">
                    <div class="section-title mb-3"><i class="fas fa-info-circle me-2"></i>Informações Gerais</div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Área Estratégica</label>
                            <input type="text" name="area_estrategica" class="form-control" placeholder="Ex: XP Marketing" value="{{ old('area_estrategica', $tevep->area_estrategica) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Indicador</label>
                            <input type="text" name="indicador" class="form-control" placeholder="Objetivo principal" value="{{ old('indicador', $tevep->indicador) }}">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Data Início</label>
                            <input type="date" name="data_inicio" class="form-control" value="{{ old('data_inicio', optional($tevep->data_inicio)->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Data Fim</label>
                            <input type="date" name="data_fim" class="form-control" value="{{ old('data_fim', optional($tevep->data_fim)->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Nome do Evento</label>
                            <input type="text" name="nome_evento" class="form-control" value="{{ old('nome_evento', $tevep->nome_evento) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Espaço</label>
                            <input type="text" name="espaco" class="form-control" placeholder="Local de realização" value="{{ old('espaco', $tevep->espaco) }}">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Pessoas Envolvidas</label>
                            <input type="text" name="pessoas_envolvidas" class="form-control" placeholder="Membros, Senadores, Aspirantes..." value="{{ old('pessoas_envolvidas', $tevep->pessoas_envolvidas) }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card section-card">
                <div class="card-body">
                    <div class="section-title mb-3">Detalhamento do Projeto</div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Utilidade (Objetivo)</label>
                            <textarea name="utilidade_objetivo" rows="3" class="form-control" placeholder="Descreva o objetivo e o propósito do projeto">{{ old('utilidade_objetivo', $tevep->utilidade_objetivo) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Inerências (Planejamento)</label>
                            <textarea name="inerencias_planejamento" rows="3" class="form-control" placeholder="Planejamento das ações, organização das atividades...">{{ old('inerencias_planejamento', $tevep->inerencias_planejamento) }}</textarea>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Expectativas</label>
                            <textarea name="expectativas" rows="3" class="form-control" placeholder="Resultados esperados, participação, impacto...">{{ old('expectativas', $tevep->expectativas) }}</textarea>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Custo</label>
                            <input type="text" name="custo" class="form-control mask-currency" placeholder="Orçamento estimado" value="{{ old('custo', $tevep->custo) }}">
                            @error('custo')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Entrega</label>
                            <input type="text" name="entrega" class="form-control" placeholder="Tipo de entrega" value="{{ old('entrega', $tevep->entrega) }}">
                            @error('entrega')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Atendimento</label>
                            <input type="text" name="atendimento" class="form-control" placeholder="Ex: Telefonia, e-mail, WhatsApp" value="{{ old('atendimento', $tevep->atendimento) }}">
                            @error('atendimento')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Qualidade</label>
                            <input type="text" name="qualidade" class="form-control" placeholder="Critérios de qualidade" value="{{ old('qualidade', $tevep->qualidade) }}">
                            @error('qualidade')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Inovação</label>
                            <textarea name="inovacao" rows="2" class="form-control" placeholder="Ações diferenciadas, novidades...">{{ old('inovacao', $tevep->inovacao) }}</textarea>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Logística</label>
                            <textarea name="logistica" rows="2" class="form-control" placeholder="Contatos, fornecedores, parcerias...">{{ old('logistica', $tevep->logistica) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card section-card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="section-title mb-0">Planejamento de Ações</div>
                        <button type="button" class="btn btn-sm btn-primary" id="btn-add-acao">+ Nova Ação</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle" id="tabela-acoes">
                            <thead>
                                <tr>
                                    <th>Prazo</th>
                                    <th>Evento/Ação</th>
                                    <th>Espaço</th>
                                    <th>Pessoas</th>
                                    <th>Piloto</th>
                                    <th>Recursos (EMG)</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="acoes-body">
                                @forelse($tevep->acoes ?? [] as $index => $acao)
                                    <tr>
                                        <td>
                                            <input type="date" name="acoes[{{ $index }}][prazo]" class="form-control" value="{{ optional($acao->prazo)->format('Y-m-d') }}">
                                        </td>
                                        <td>
                                            <input type="text" name="acoes[{{ $index }}][evento_acao]" class="form-control" placeholder="Descrição da ação" value="{{ $acao->evento_acao }}">
                                        </td>
                                        <td>
                                            <input type="text" name="acoes[{{ $index }}][espaco]" class="form-control" placeholder="Físico/Virtual" value="{{ $acao->espaco }}">
                                        </td>
                                        <td>
                                            <input type="text" name="acoes[{{ $index }}][pessoas]" class="form-control" placeholder="Responsáveis" value="{{ $acao->pessoas }}">
                                        </td>
                                        <td>
                                            <input type="text" name="acoes[{{ $index }}][piloto]" class="form-control" placeholder="Nome" value="{{ $acao->piloto }}">
                                        </td>
                                        <td>
                                            <input type="text" name="acoes[{{ $index }}][recursos]" class="form-control" placeholder="Máquina, Material, MO..." value="{{ $acao->recursos }}">
                                        </td>
                                        <td>
                                            <input type="text" name="acoes[{{ $index }}][status]" class="form-control" placeholder="RA/CM" value="{{ $acao->status }}">
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-remove-acao">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="acao-empty-row">
                                        <td colspan="8" class="text-center text-muted">Nenhuma ação adicionada. Clique em "Nova Ação" para começar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mb-4">
                <button type="submit" class="btn btn-primary">Salvar TEVEP</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.mask-currency').forEach(function (input) {
            input.addEventListener('input', function (e) {
                let value = e.target.value || '';
                value = value.replace(/[^0-9]/g, '');

                if (!value) {
                    e.target.value = '';
                    return;
                }

                let intValue = parseInt(value, 10);
                intValue = isNaN(intValue) ? 0 : intValue;

                let formatted = (intValue / 100).toFixed(2).toString();
                formatted = formatted.replace('.', ',');
                formatted = formatted.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                e.target.value = 'R$ ' + formatted;
            });
        });

        // Planejamento de Ações dinâmico
        const tabelaBody = document.getElementById('acoes-body');
        const btnAddAcao = document.getElementById('btn-add-acao');
        let acaoIndex = tabelaBody ? tabelaBody.querySelectorAll('tr').length : 0;

        function criarLinhaAcao(index) {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td><input type="date" name="acoes[${index}][prazo]" class="form-control"></td>
                <td><input type="text" name="acoes[${index}][evento_acao]" class="form-control" placeholder="Descrição da ação"></td>
                <td><input type="text" name="acoes[${index}][espaco]" class="form-control" placeholder="Físico/Virtual"></td>
                <td><input type="text" name="acoes[${index}][pessoas]" class="form-control" placeholder="Responsáveis"></td>
                <td><input type="text" name="acoes[${index}][piloto]" class="form-control" placeholder="Nome"></td>
                <td><input type="text" name="acoes[${index}][recursos]" class="form-control" placeholder="Máquina, Material, MO..."></td>
                <td><input type="text" name="acoes[${index}][status]" class="form-control" placeholder="RA/CM"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-acao">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            return tr;
        }

        if (btnAddAcao && tabelaBody) {
            btnAddAcao.addEventListener('click', function () {
                const emptyRow = tabelaBody.querySelector('.acao-empty-row');
                if (emptyRow) {
                    emptyRow.remove();
                }

                const novaLinha = criarLinhaAcao(acaoIndex++);
                tabelaBody.appendChild(novaLinha);
            });

            tabelaBody.addEventListener('click', function (e) {
                if (e.target.closest('.btn-remove-acao')) {
                    const row = e.target.closest('tr');
                    row.remove();

                    if (!tabelaBody.querySelector('tr')) {
                        const empty = document.createElement('tr');
                        empty.classList.add('acao-empty-row');
                        empty.innerHTML = '<td colspan="8" class="text-center text-muted">Nenhuma ação adicionada. Clique em "Nova Ação" para começar.</td>';
                        tabelaBody.appendChild(empty);
                    }
                }
            });
        }
    });
</script>
@endpush
