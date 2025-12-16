@extends('layouts.app-admin')

@push('styles')
<style>
    .desafios-bg {
        background: #f4f7fb;
    }
    .metric-card {
        border-radius: 18px;
        border: none;
        box-shadow: 0 10px 30px rgba(15, 35, 95, 0.05);
        background: #ffffff;
    }
    .metric-card .label {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        color: #8b9bb7;
        letter-spacing: 0.04em;
    }
    .metric-card .value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1b3150;
    }
    .metric-card .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(47, 128, 237, 0.08);
        color: #2f80ed;
        font-size: 18px;
    }

    .jornada-card {
        border-radius: 18px;
        border: none;
        box-shadow: 0 12px 40px rgba(15, 35, 95, 0.08);
        background: linear-gradient(135deg, #ffffff 0%, #f7fbff 40%, #eef4ff 100%);
        position: relative;
        overflow: hidden;
    }
    .jornada-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 14px;
        border-radius: 999px;
        background: #eef5ff;
        color: #2f80ed;
        font-weight: 600;
        font-size: 0.8rem;
    }
    .jornada-progress-line {
        height: 8px;
        border-radius: 999px;
        background: #e4ecf7;
        overflow: hidden;
    }
    .jornada-progress-fill {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, #2f80ed 0%, #56ccf2 50%, #27ae60 100%);
    }
    .jornada-meter-labels span {
        font-size: 0.75rem;
        color: #9aa6c0;
    }

    .diretoria-card {
        border-radius: 18px;
        border: none;
        box-shadow: 0 8px 24px rgba(15, 35, 95, 0.05);
    }
    .diretoria-header-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #a0aec0;
    }
    .diretoria-progress {
        height: 7px;
        border-radius: 999px;
    }
    .diretoria-meta-badge {
        border-radius: 999px;
        font-size: 0.7rem;
        padding: 4px 10px;
    }

    .ranking-card,
    .conquistas-card,
    .cta-card {
        border-radius: 18px;
        border: none;
        box-shadow: 0 8px 24px rgba(15, 35, 95, 0.05);
    }
    .ranking-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px dashed #e2e8f0;
    }
    .ranking-item:last-child {
        border-bottom: none;
    }
    .medal-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: #fff;
    }
    .medal-gold { background: linear-gradient(135deg, #f6d365, #fda085); }
    .medal-silver { background: linear-gradient(135deg, #d3dfe8, #a6b1c2); }
    .medal-bronze { background: linear-gradient(135deg, #f5b78a, #e07a5f); }

    .conquista-pill {
        border-radius: 12px;
        padding: 10px 12px;
        font-size: 0.85rem;
        margin-bottom: 8px;
    }
    .conquista-pill small {
        color: #718096;
    }

    .cta-card {
        background: linear-gradient(135deg, #4f46e5, #3b82f6);
        color: #ffffff;
        text-align: center;
    }
    .cta-card p {
        margin-bottom: 0;
        font-size: 0.9rem;
    }
    .cta-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        border: 2px solid rgba(255,255,255,0.6);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 10px;
    }

    @media (max-width: 991.98px) {
        .jornada-card {
            margin-top: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="main_content_iner desafios-bg">
    <div class="container-fluid p-0 sm_padding_15px">
        <div class="row mb-2">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <a href="{{ route('novos-desafios.perfis') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Voltar
                </a>
            </div>
        </div>

        <div class="row mb-3 mb-md-4">
            <div class="col-md-3 mb-3 mb-md-0">
                <div class="card metric-card h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="label">Taxa de Entrega</div>
                            <div class="value">{{ number_format($taxaEntrega, 1, ',', '.') }}%</div>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3 mb-md-0">
                <div class="card metric-card h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="label">Engajamento</div>
                            <div class="value">{{ number_format($engajamento, 1, ',', '.') }}%</div>
                        </div>
                        <div class="icon-circle" style="background: rgba(16, 185, 129, 0.08); color:#10b981;">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3 mb-md-0">
                <div class="card metric-card h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="label">Inovação</div>
                            <div class="value">{{ number_format($inovacao, 1, ',', '.') }}%</div>
                        </div>
                        <div class="icon-circle" style="background: rgba(245, 158, 11, 0.08); color:#f59e0b;">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card metric-card h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="label">Total de Pontos</div>
                            <div class="value">{{ number_format($totalPontos, 0, ',', '.') }}</div>
                        </div>
                        <div class="icon-circle" style="background: rgba(245, 158, 11, 0.08); color:#f97316;">
                            <i class="fas fa-trophy"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card jornada-card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <div class="jornada-badge mb-2">
                                    <i class="fas fa-gem me-2"></i> Jornada Coletiva para o Baú da Excelência
                                </div>
                                <p class="mb-1 text-muted" style="max-width: 540px; font-size:0.9rem;">
                                    Jornada coletiva rumo à excelência! Cada ponto nos aproxima do tesouro final.
                                </p>
                            </div>
                            <div class="text-end">
                                <div class="text-uppercase text-muted" style="font-size:0.75rem;">Meta Final</div>
                                <div class="fw-bold" style="font-size:1.3rem; color:#16a34a;">10.000</div>
                                <span class="badge bg-warning text-dark mt-1">Baú da Excelência</span>
                            </div>
                        </div>

                        <div class="row align-items-center mt-3">
                            <div class="col-md-9">
                                <div class="jornada-progress-line mb-1">
                                    @php
                                        $metaFinal = 10000;
                                        $progressoJornada = min(100, $metaFinal > 0 ? ($totalPontos / $metaFinal) * 100 : 0);
                                    @endphp
                                    <div class="jornada-progress-fill" style="width: {{ number_format($progressoJornada, 2, '.', '') }}%;"></div>
                                </div>
                                <div class="d-flex justify-content-between jornada-meter-labels">
                                    <span>Início</span>
                                    <span>25%</span>
                                    <span>50%</span>
                                    <span>75%</span>
                                    <span>100%</span>
                                </div>
                            </div>
                            <div class="col-md-3 mt-3 mt-md-0 text-md-end">
                                <div class="small text-muted">Pontos conquistados</div>
                                <div class="fw-bold" style="font-size:1.1rem;">{{ number_format($totalPontos, 0, ',', '.') }}</div>
                                <small class="text-success d-block mt-1"><i class="fas fa-check-circle me-1"></i>Ótimo progresso! Estamos no caminho certo!</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="mb-0">Diretorias</h5>
                    <a href="{{ route('novos-desafios.perfis') }}" class="btn btn-sm btn-outline-primary">Ver todas</a>
                </div>

                <div class="diretorias-wrapper">
                    @foreach($diretorias as $diretoria)
                        <div class="card diretoria-card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div>
                                        <div class="diretoria-header-label">Diretoria</div>
                                        <h6 class="mb-0">{{ $diretoria->nome }}</h6>
                                        <small class="text-muted">Responsável: {{ $diretoria->responsavel }}</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-{{ $diretoria->statusClasse }} diretoria-meta-badge">{{ $diretoria->status }}</span>
                                        <div class="fw-bold mt-1" style="color:#1b3150;">{{ $diretoria->pontos }} pontos</div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="text-muted">Progresso Geral</small>
                                        <small class="text-muted">{{ $diretoria->progresso }}%</small>
                                    </div>
                                    <div class="progress diretoria-progress">
                                        <div class="progress-bar bg-success" style="width: {{ $diretoria->progresso }}%"></div>
                                    </div>
                                </div>
                                <div class="d-flex gap-3 small text-muted mt-1">
                                    <span><strong>{{ $diretoria->projetosTotal }}</strong> Projetos</span>
                                    <span><strong>{{ $diretoria->projetosConcluidos }}</strong> Concluídos</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card ranking-card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">Ranking Mensal</h6>
                        </div>

                        @foreach($ranking as $index => $item)
                            @php
                                $posicao = $index + 1;
                                if ($posicao === 1) {
                                    $medalClasse = 'medal-gold';
                                } elseif ($posicao === 2) {
                                    $medalClasse = 'medal-silver';
                                } elseif ($posicao === 3) {
                                    $medalClasse = 'medal-bronze';
                                } else {
                                    $medalClasse = '';
                                }
                            @endphp
                            <a href="{{ route('visao-adm.usuario', $item->id) }}" class="text-decoration-none text-dark">
                                <div class="ranking-item">
                                    <div class="d-flex align-items-center gap-2">
                                        @if($medalClasse)
                                            <div class="medal-icon {{ $medalClasse }}">
                                                <i class="fas fa-medal"></i>
                                            </div>
                                        @else
                                            <div class="medal-icon" style="background:#e5e7eb; color:#4b5563;">
                                                <span>{{ $posicao }}º</span>
                                            </div>
                                        @endif
                                        <div>
                                            <div>{{ $item->nome }}</div>
                                            <small class="text-muted">{{ $item->cargo }}</small>
                                        </div>
                                    </div>
                                    <div class="fw-bold">{{ $item->pontos }} pts</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="card conquistas-card mb-3">
                    <div class="card-body">
                        <h6 class="mb-3">Conquistas Recentes</h6>
                        @forelse($conquistasRecentes as $conquista)
                            <div class="conquista-pill bg-light mb-2">
                                <div class="fw-semibold">{{ $conquista->titulo }}</div>
                                <small>
                                    {{ $conquista->usuario_nome }} •
                                    {{ \Carbon\Carbon::parse($conquista->conquistado_em)->diffForHumans() }}
                                </small>
                            </div>
                        @empty
                            <small class="text-muted">Nenhuma conquista recente ainda.</small>
                        @endforelse
                    </div>
                </div>

                <div class="card cta-card">
                    <div class="card-body">
                        <div class="cta-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h6 class="mb-1">Continue assim!</h6>
                        <p>A equipe está alcançando ótimos resultados este mês!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
