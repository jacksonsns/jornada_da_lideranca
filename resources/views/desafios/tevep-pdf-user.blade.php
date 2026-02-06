<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TEVEP</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111827; }
        .header { margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #e5e7eb; }
        .header h1 { font-size: 18px; margin: 0 0 4px 0; }
        .header .meta { font-size: 11px; color: #374151; }
        .section { margin-top: 14px; }
        .section h2 { font-size: 13px; margin: 0 0 8px 0; padding: 6px 8px; background: #f3f4f6; border: 1px solid #e5e7eb; }
        .grid { width: 100%; border-collapse: collapse; }
        .grid td { vertical-align: top; padding: 6px 8px; border: 1px solid #e5e7eb; }
        .label { width: 180px; font-weight: 600; color: #111827; }
        .value { color: #111827; }
        table.actions { width: 100%; border-collapse: collapse; }
        table.actions th, table.actions td { border: 1px solid #e5e7eb; padding: 6px 6px; font-size: 11px; }
        table.actions th { background: #f3f4f6; text-align: left; }
        .muted { color: #6b7280; }
        .nowrap { white-space: nowrap; }
    </style>
</head>
<body>
    <div class="header">
        <h1>TEVEP - Projeto em Uma Folha</h1>
        <div class="meta">
            <div><strong>Usuário:</strong> {{ $usuario->name }} (ID {{ $usuario->id }})</div>
            <div><strong>Desafio:</strong> {{ $desafioUser->desafio->titulo ?? $desafioUser->desafio->descricao ?? '—' }} (ID {{ $desafioUser->id }})</div>
        </div>
    </div>

    <div class="section">
        <h2>Informações Gerais</h2>
        <table class="grid">
            <tr>
                <td class="label">Área Estratégica</td>
                <td class="value">{{ $tevep->area_estrategica ?: '—' }}</td>
            </tr>
            <tr>
                <td class="label">Indicador</td>
                <td class="value">{{ $tevep->indicador ?: '—' }}</td>
            </tr>
            <tr>
                <td class="label">Data Início</td>
                <td class="value">{{ optional($tevep->data_inicio)->format('d/m/Y') ?: '—' }}</td>
            </tr>
            <tr>
                <td class="label">Data Fim</td>
                <td class="value">{{ optional($tevep->data_fim)->format('d/m/Y') ?: '—' }}</td>
            </tr>
            <tr>
                <td class="label">Nome do Evento</td>
                <td class="value">{{ $tevep->nome_evento ?: '—' }}</td>
            </tr>
            <tr>
                <td class="label">Espaço</td>
                <td class="value">{{ $tevep->espaco ?: '—' }}</td>
            </tr>
            <tr>
                <td class="label">Pessoas Envolvidas</td>
                <td class="value">{{ $tevep->pessoas_envolvidas ?: '—' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Detalhamento do Projeto</h2>
        <table class="grid">
            <tr>
                <td class="label">Utilidade (Objetivo)</td>
                <td class="value">{!! nl2br(e($tevep->utilidade_objetivo ?: '—')) !!}</td>
            </tr>
            <tr>
                <td class="label">Inerências (Planejamento)</td>
                <td class="value">{!! nl2br(e($tevep->inerencias_planejamento ?: '—')) !!}</td>
            </tr>
            <tr>
                <td class="label">Expectativas</td>
                <td class="value">{!! nl2br(e($tevep->expectativas ?: '—')) !!}</td>
            </tr>
            <tr>
                <td class="label">Custo</td>
                <td class="value">
                    @if(!is_null($tevep->custo) && $tevep->custo !== '')
                        R$ {{ number_format((float) $tevep->custo, 2, ',', '.') }}
                    @else
                        —
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Entrega</td>
                <td class="value">{{ $tevep->entrega ?: '—' }}</td>
            </tr>
            <tr>
                <td class="label">Atendimento</td>
                <td class="value">{{ $tevep->atendimento ?: '—' }}</td>
            </tr>
            <tr>
                <td class="label">Qualidade</td>
                <td class="value">{{ $tevep->qualidade ?: '—' }}</td>
            </tr>
            <tr>
                <td class="label">Inovação</td>
                <td class="value">{!! nl2br(e($tevep->inovacao ?: '—')) !!}</td>
            </tr>
            <tr>
                <td class="label">Logística</td>
                <td class="value">{!! nl2br(e($tevep->logistica ?: '—')) !!}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Régua Única do Tempo - RUT</h2>

        @php
            $acoes = $tevep->acoes ?? collect();
        @endphp

        @if($acoes->count() === 0)
            <div class="muted">Nenhuma ação cadastrada.</div>
        @else
            <table class="actions">
                <thead>
                    <tr>
                        <th class="nowrap">Prazo</th>
                        <th>Evento/Ação</th>
                        <th>Espaço</th>
                        <th>Pessoas</th>
                        <th>Piloto</th>
                        <th>Recursos (EMG)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($acoes as $acao)
                        <tr>
                            <td class="nowrap">{{ optional($acao->prazo)->format('d/m/Y') ?: '—' }}</td>
                            <td>{{ $acao->evento_acao ?: '—' }}</td>
                            <td>{{ $acao->espaco ?: '—' }}</td>
                            <td>{{ $acao->pessoas ?: '—' }}</td>
                            <td>{{ $acao->piloto ?: '—' }}</td>
                            <td>{{ $acao->recursos ?: '—' }}</td>
                            <td>{{ $acao->status ?: '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
