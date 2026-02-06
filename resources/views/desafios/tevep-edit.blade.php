@extends('layouts.app-admin')

@push('styles')
<style>
    .tevep-bg {
        padding: 2.2rem 2rem 2rem;
        background:
            radial-gradient(circle at 0 0, rgba(59,130,246,0.40), transparent 55%),
            radial-gradient(circle at 100% 100%, rgba(56,189,248,0.32), transparent 55%),
            linear-gradient(135deg,#020617 0%,#020617 40%,#02061b 100%);
    }

    .tevep-header {
        border-radius: 22px;
        background: linear-gradient(135deg,#1b7aff,#33b3ff);
        color: #ffffff;
        padding: 18px 22px;
        box-shadow: 0 22px 60px rgba(15,23,42,0.9);
    }

    .tevep-title {
        font-size: 1.25rem;
        font-weight: 600;
    }

    .tevep-subtitle {
        font-size: 0.85rem;
        opacity: .9;
    }

    .tevep-progress {
        font-size: 0.9rem;
    }

    .section-card {
        border-radius: 22px;
        border: 1px solid rgba(148,163,184,0.30);
        background: radial-gradient(circle at 0 0, rgba(59,130,246,0.22), transparent 55%),
                    radial-gradient(circle at 100% 100%, rgba(129,140,248,0.18), transparent 55%),
                    rgba(15,23,42,0.98);
        box-shadow: 0 22px 60px rgba(15,23,42,0.9);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        margin-bottom: 18px;
    }

    .section-title {
        font-weight: 600;
        font-size: 0.95rem;
        color: #e5e7eb;
    }

    .section-card .card-body {
        padding: 1.3rem 1.4rem 1.4rem;
    }

    .section-card label,
    .section-card p,
    .section-card span,
    .section-card th,
    .section-card td {
        color: #e5e7eb;
    }

    .section-card input,
    .section-card textarea,
    .section-card select {
        background-color: rgba(15,23,42,0.9);
        border-color: rgba(55,65,81,0.9);
        color: #e5e7eb;
    }

    .section-card input::placeholder,
    .section-card textarea::placeholder {
        color: #6b7280;
    }

    .section-card .text-danger {
        color: #fecaca !important;
    }

    .alert-success {
        border-radius: 999px;
        border: 1px solid rgba(34,197,94,0.6);
        background: linear-gradient(135deg, rgba(22,163,74,0.22), rgba(21,128,61,0.4));
        color: #bbf7d0;
        box-shadow: 0 16px 40px rgba(6,95,70,0.65);
    }

    .alert-danger {
        border-radius: 16px;
        border: 1px solid rgba(248,113,113,0.8);
        background: linear-gradient(135deg, rgba(220,38,38,0.20), rgba(127,29,29,0.65));
        color: #fecaca;
        box-shadow: 0 16px 40px rgba(127,29,29,0.65);
    }

    @media (max-width: 767.98px) {
        .tevep-bg {
            padding: 1.6rem 1.1rem 1.6rem;
        }
    }
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
                        <div class="section-title mb-0">Régua Única do Tempo - RUT</div>
                        <button type="button" class="btn btn-sm btn-primary" disabled>+ Nova Ação</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Prazo</th>
                                    <th>Evento/Ação</th>
                                    <th>Espaço</th>
                                    <th>Pessoas</th>
                                    <th>Piloto</th>
                                    <th>Recursos (EMG)</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Nenhuma ação adicionada. Clique em "Nova Ação" para começar.</td>
                                </tr>
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
    });
</script>
@endpush
