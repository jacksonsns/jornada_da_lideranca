@extends('layouts.app')

@push('styles')
<style>
    .usuario-bg {
        background: transparent;
        padding-bottom: 1.5rem;
    }
    .top-strip {
        border-radius: 22px;
        background: transparent;
        box-shadow: none;
        padding: 4px 4px 2px;
    }
    .metric-card {
        position: relative;
        overflow: hidden;
        border-radius: 18px;
        background: radial-gradient(circle at 0 0, rgba(255, 255, 255, 0.08), transparent 60%),
                    linear-gradient(145deg, rgba(12, 33, 72, 0.97), rgba(6, 24, 60, 0.99));
        border: none;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 18px 45px rgba(0, 0, 0, 0.7);
        color: #e5eeff;
    }
    .metric-card.primary {
        background: linear-gradient(135deg,#1b7aff,#33b3ff);
        color:#ffffff;
    }
    .metric-card.primary .label { color:#e0e7ff; }
    .metric-card.primary .value { color:#ffffff; }
    .metric-card .label {
        font-size:0.75rem;
        font-weight:600;
        text-transform:uppercase;
        color:rgba(223,234,255,0.85);
        letter-spacing:0.04em;
    }
    .metric-card .value {
        font-size:1.4rem;
        font-weight:700;
        color:#ffffff;
    }
    .metric-icon {
        width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center;
        background:rgba(255,255,255,0.22); color:#ffffff; font-size:18px;
    }

    .section-card {
        border-radius:22px;
        border:none;
        background: radial-gradient(circle at 0 0, rgba(255,255,255,0.96), rgba(233,239,255,0.98));
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.55);
    }
    .tab-pill { border-radius:999px; padding:6px 16px; font-size:0.85rem; cursor:pointer; font-weight:500; }
    .tab-pill-active { background:#2563eb; color:#fff; }
    .tab-pill-inactive { background:#e5e7eb; color:#4b5563; }

    .projeto-card {
        border-radius:20px;
        border:none;
        background: radial-gradient(circle at 0 0, rgba(255,255,255,0.96), rgba(235,242,255,0.99));
        box-shadow: 0 18px 45px rgba(0, 0, 0, 0.55);
        margin-bottom:18px;
    }
    .projeto-header small { font-size:0.8rem; }
    .progresso-label { font-size:0.85rem; }

    .etapas-wrapper { margin-top:10px; }
    .etapa-card {
        border-radius:14px;
        border:1px solid rgba(148, 163, 184, 0.45);
        background: radial-gradient(circle at 0 0, rgba(248,250,252,0.98), rgba(226,232,240,0.95));
        padding:8px 10px;
        text-align:center;
        font-size:0.8rem;
        box-shadow: 0 10px 25px rgba(15,35,95,0.35);
    }
    .etapa-card strong { display:block; font-size:0.9rem; color:#2563eb; }

    .tevep-usuario-header-text {
        max-width: 260px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endpush

@section('content')
<div class="p-5 usuario-bg">
    <div class="container-fluid p-0 sm_padding_15px">
        <div class="row mb-2">
            <div class="col-6 d-flex align-items-center">
                @isset($desafioParaNovoTevep)
                    <a href="{{ route('tevep.create-user', ['user' => $usuario->id, 'desafioUser' => $desafioParaNovoTevep->id]) }}" class="btn btn-sm btn-primary">
                        + Adicionar TEVEP
                    </a>
                @endisset
            </div>
            <div class="col-6 text-end d-flex justify-content-end align-items-center gap-2">
                <div class="me-2 text-end tevep-usuario-header-text">
                    <div class="fw-semibold">{{ $usuario->name }}</div>
                    <small class="text-muted">{{ $usuario->cargo ?? 'Membro' }}</small>
                </div>
                <div class="perfil-avatar-wrapper" style="width:48px;height:48px;">
                    <img src="{{ $usuario->avatar ? asset('storage/avatars/' . $usuario->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($usuario->name) }}" alt="{{ $usuario->name }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
                </div>
            </div>
        </div>

        <div class="row mb-3 mb-md-4">
            <div class="col-12">
                <div class="top-strip">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="metric-card primary h-100">
                                <div>
                                    <div class="label">Pontos Totais</div>
                                    <div class="value">{{ $pontosTotais }}</div>
                                </div>
                                <div class="metric-icon"><i class="fas fa-trophy"></i></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-card h-100">
                                <div>
                                    <div class="label">Projetos Ativos</div>
                                    <div class="value">{{ $projetosAtivos }}</div>
                                </div>
                                <div class="metric-icon" style="background:#e0f2fe;color:#2563eb;"><i class="fas fa-bullseye"></i></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-card h-100">
                                <div>
                                    <div class="label">Concluídos</div>
                                    <div class="value">{{ $projetosConcluidos }}</div>
                                </div>
                                <div class="metric-icon" style="background:#dcfce7;color:#15803d;"><i class="fas fa-check-circle"></i></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-card h-100">
                                <div>
                                    <div class="label">Tarefas Pendentes</div>
                                    <div class="value">{{ $tarefasPendentes }}</div>
                                </div>
                                <div class="metric-icon" style="background:#fff7ed;color:#ea580c;"><i class="fas fa-clock"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <div class="card section-card">
                    <div class="card-body">
                        <div class="d-flex gap-2 mb-3">
                            <span class="tab-pill tab-pill-active" data-tab="projetos">Projetos</span>
                            <span class="tab-pill tab-pill-inactive" data-tab="tarefas">Tarefas</span>
                            <span class="tab-pill tab-pill-inactive" data-tab="conquistas">Conquistas</span>
                        </div>

                        {{-- Aba PROJETOS --}}
                        <div class="tab-content" id="tab-projetos">
                        @forelse($teveps as $tevep)
                            @php
                                $desafioUser = $tevep->desafioUser;
                                $desafio = optional($desafioUser)->desafio;
                                $concluido = $desafioUser ? (bool) $desafioUser->concluido : false;
                                $progressoProjeto = $concluido ? 100 : 50;
                            @endphp
                            <div class="card projeto-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center projeto-header mb-1">
                                        <div>
                                            <h6 class="mb-0">{{ $desafio->titulo ?? $desafio->descricao ?? 'Projeto sem título' }}</h6>
                                            <div class="d-flex align-items-center gap-2 mt-1">
                                                <small class="badge bg-{{ $concluido ? 'success' : 'primary' }}">
                                                    {{ $concluido ? 'Concluído' : 'Em andamento' }}
                                                </small>
                                                <small class="text-muted">
                                                    <i class="far fa-calendar-alt me-1"></i>Sem data definida
                                                </small>
                                            </div>
                                        </div>
                                        <div>
                                            @if($desafioUser)
                                                <div class="d-flex gap-2 justify-content-end">
                                                    <a href="{{ route('tevep.edit-user', ['user' => $usuario->id, 'desafioUser' => $desafioUser->id]) }}" class="btn btn-sm btn-outline-primary">
                                                    Editar TEVEP
                                                    </a>
                                                    <a href="{{ route('tevep.pdf-user', ['user' => $usuario->id, 'desafioUser' => $desafioUser->id]) }}" class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener noreferrer">
                                                    Gerar PDF
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="progress mb-3" style="height:8px;">
                                        <div class="progress-bar bg-primary" style="width: {{ $progressoProjeto }}%"></div>
                                    </div>

                                    <div class="mt-2">
                                        <small class="text-muted d-block mb-2">Resumo do TEVEP</small>
                                        <div class="row g-2 etapas-wrapper">
                                            <div class="col-6 col-md-3 col-lg-2">
                                                <div class="etapa-card">
                                                    <strong>Tempo</strong>
                                                    <span>
                                                        {{ optional($tevep->data_inicio)->format('d/m/Y') }}
                                                        @if($tevep->data_fim)
                                                            – {{ optional($tevep->data_fim)->format('d/m/Y') }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3 col-lg-2">
                                                <div class="etapa-card">
                                                    <strong>Espaço</strong>
                                                    <span>{{ $tevep->espaco ?: '-' }}</span>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3 col-lg-2">
                                                <div class="etapa-card">
                                                    <strong>Valor</strong>
                                                    <span>
                                                        @if(!is_null($tevep->custo))
                                                            R$ {{ number_format($tevep->custo, 2, ',', '.') }}
                                                        @else
                                                            -
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6 col-lg-3">
                                                <div class="etapa-card">
                                                    <strong>Expectativa</strong>
                                                    <span>{{ $tevep->expectativas ? \Illuminate\Support\Str::limit($tevep->expectativas, 40) : '-' }}</span>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6 col-lg-3">
                                                <div class="etapa-card">
                                                    <strong>Pessoas</strong>
                                                    <span>{{ $tevep->pessoas_envolvidas ? \Illuminate\Support\Str::limit($tevep->pessoas_envolvidas, 40) : '-' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted mb-0">Nenhum TEVEP criado para este usuário ainda.</p>
                        @endforelse
                        </div>

                        {{-- Aba TAREFAS --}}
                        <div class="tab-content d-none" id="tab-tarefas">
                            <h6 class="mb-3">Minhas Tarefas</h6>

                            @forelse($acoes as $acao)
                                <div class="card mb-2">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" disabled>
                                                <label class="form-check-label fw-semibold">
                                                    {{ $acao->evento_acao ?? 'Ação sem descrição' }}
                                                </label>
                                            </div>
                                            <small class="text-muted">
                                                @if($acao->prazo)
                                                    {{ $acao->prazo->format('d/m/Y') }}
                                                @else
                                                    Sem prazo definido
                                                @endif
                                                @if($acao->tevep && $acao->tevep->nome_evento)
                                                    • {{ $acao->tevep->nome_evento }}
                                                @endif
                                            </small>
                                        </div>

                                        @php
                                            $status = strtoupper($acao->status ?? '');
                                            if ($status === 'ALTA') {
                                                $badgeClass = 'bg-danger';
                                                $label = 'Alta';
                                            } elseif ($status === 'MEDIA' || $status === 'MÉDIA') {
                                                $badgeClass = 'bg-warning text-dark';
                                                $label = 'Média';
                                            } else {
                                                $badgeClass = 'bg-secondary';
                                                $label = $acao->status ?: 'Normal';
                                            }
                                        @endphp

                                        <span class="badge {{ $badgeClass }}">{{ $label }}</span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted mb-0">Nenhuma tarefa cadastrada nos seus TEVEPs ainda.</p>
                            @endforelse
                        </div>

                        {{-- Aba CONQUISTAS --}}
                        <div class="tab-content d-none" id="tab-conquistas">
                            <h6 class="mb-3">Minhas Conquistas</h6>

                            @if($conquistas->isEmpty())
                                <p class="text-muted mb-0">Você ainda não possui conquistas registradas.</p>
                            @else
                                <div class="d-flex gap-3 flex-wrap">
                                    @foreach($conquistas as $conquista)
                                        <div class="card flex-shrink-0"
                                             style="min-width:220px; border-radius:18px; background:linear-gradient(135deg,#2563eb,#3b82f6); color:#fff;">
                                            <div class="card-body d-flex flex-column justify-content-between" style="min-height:120px;">
                                                <div>
                                                    <div style="font-size:2rem;">🎉</div>
                                                    <div class="fw-semibold mt-2">{{ $conquista->titulo }}</div>
                                                </div>
                                                <div class="mt-2">
                                                    <small>
                                                        {{ $conquista->descricao ?? 'Conquista desbloqueada.' }}<br>
                                                        @if($conquista->conquistado_em)
                                                            <span class="d-block mt-1">Conquistado em {{ \Carbon\Carbon::parse($conquista->conquistado_em)->format('d/m/Y') }}</span>
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabPills = document.querySelectorAll('.tab-pill');
        const tabContents = {
            'projetos': document.getElementById('tab-projetos'),
            'tarefas': document.getElementById('tab-tarefas'),
            'conquistas': document.getElementById('tab-conquistas'),
        };

        tabPills.forEach(function (pill) {
            pill.addEventListener('click', function () {
                const target = this.getAttribute('data-tab');
                if (!target || !tabContents[target]) return;

                // atualiza aparência das abas
                tabPills.forEach(function (p) {
                    p.classList.remove('tab-pill-active');
                    p.classList.add('tab-pill-inactive');
                });
                this.classList.remove('tab-pill-inactive');
                this.classList.add('tab-pill-active');

                // mostra/esconde conteúdos
                Object.keys(tabContents).forEach(function (key) {
                    if (key === target) {
                        tabContents[key].classList.remove('d-none');
                    } else {
                        tabContents[key].classList.add('d-none');
                    }
                });
            });
        });
    });
</script>
@endpush
