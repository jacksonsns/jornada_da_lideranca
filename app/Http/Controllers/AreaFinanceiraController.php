<?php

namespace App\Http\Controllers;

use App\Models\AreaFinanceira;
use App\Models\Transacao;
use App\Models\Meta;
use Illuminate\Http\Request;

class AreaFinanceiraController extends Controller
{
    public function index()
    {
        $transacoes = Transacao::where('user_id', auth()->id())
            ->whereMonth('data', now()->month)
            ->whereYear('data', now()->year)
            ->orderBy('data', 'desc')
            ->get();

        $metas = Meta::where('user_id', auth()->id())
            ->where('status', 'ativa')
            ->get();

        $saldo = $transacoes->where('tipo', 'receita')->sum('valor') - 
                $transacoes->where('tipo', 'despesa')->sum('valor');

        $resumo = [
            'receitas' => $transacoes->where('tipo', 'receita')->sum('valor'),
            'despesas' => $transacoes->where('tipo', 'despesa')->sum('valor'),
            'saldo' => $saldo
        ];

        return view('financeiro.index', compact('transacoes', 'metas', 'resumo'));
    }

    public function registrarTransacao(Request $request)
    {
        $validados = $request->validate([
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0.01',
            'tipo' => 'required|in:receita,despesa',
            'categoria' => 'required|string',
            'data' => 'required|date',
            'recorrente' => 'boolean',
            'frequencia' => 'required_if:recorrente,true|in:mensal,anual',
            'observacoes' => 'nullable|string'
        ]);

        $validados['user_id'] = auth()->id();

        Transacao::create($validados);

        return redirect()->route('financeiro.index')
            ->with('sucesso', 'Transação registrada com sucesso!');
    }

    public function criarMeta(Request $request)
    {
        $validados = $request->validate([
            'titulo' => 'required|string|max:255',
            'valor_alvo' => 'required|numeric|min:0.01',
            'data_limite' => 'required|date|after:today',
            'categoria' => 'required|string',
            'descricao' => 'nullable|string',
            'prioridade' => 'required|in:baixa,media,alta'
        ]);

        $validados['user_id'] = auth()->id();
        $validados['valor_atual'] = 0;
        $validados['status'] = 'ativa';

        Meta::create($validados);

        return redirect()->route('financeiro.metas')
            ->with('sucesso', 'Meta financeira criada com sucesso!');
    }

    public function atualizarMeta(Request $request, Meta $meta)
    {
        if ($meta->user_id !== auth()->id()) {
            abort(403);
        }

        $validados = $request->validate([
            'valor_atual' => 'required|numeric|min:0',
            'status' => 'required|in:ativa,concluida,cancelada'
        ]);

        $meta->update($validados);

        if ($validados['valor_atual'] >= $meta->valor_alvo) {
            $meta->update(['status' => 'concluida']);
        }

        return redirect()->route('financeiro.metas')
            ->with('sucesso', 'Meta atualizada com sucesso!');
    }

    public function relatorioMensal(Request $request)
    {
        $mes = $request->get('mes', now()->month);
        $ano = $request->get('ano', now()->year);

        $transacoes = Transacao::where('user_id', auth()->id())
            ->whereMonth('data', $mes)
            ->whereYear('data', $ano)
            ->get();

        $categorias = $transacoes->groupBy('categoria')
            ->map(function ($grupo) {
                return [
                    'receitas' => $grupo->where('tipo', 'receita')->sum('valor'),
                    'despesas' => $grupo->where('tipo', 'despesa')->sum('valor')
                ];
            });

        $totais = [
            'receitas' => $transacoes->where('tipo', 'receita')->sum('valor'),
            'despesas' => $transacoes->where('tipo', 'despesa')->sum('valor'),
            'saldo' => $transacoes->where('tipo', 'receita')->sum('valor') - 
                      $transacoes->where('tipo', 'despesa')->sum('valor')
        ];

        return view('financeiro.relatorio-mensal', compact('transacoes', 'categorias', 'totais', 'mes', 'ano'));
    }

    public function relatorioAnual(Request $request)
    {
        $ano = $request->get('ano', now()->year);

        $transacoesPorMes = Transacao::where('user_id', auth()->id())
            ->whereYear('data', $ano)
            ->get()
            ->groupBy(function ($transacao) {
                return $transacao->data->format('m');
            });

        $resumoAnual = collect(range(1, 12))->mapWithKeys(function ($mes) use ($transacoesPorMes) {
            $transacoes = $transacoesPorMes->get(str_pad($mes, 2, '0', STR_PAD_LEFT), collect());
            
            return [$mes => [
                'receitas' => $transacoes->where('tipo', 'receita')->sum('valor'),
                'despesas' => $transacoes->where('tipo', 'despesa')->sum('valor'),
                'saldo' => $transacoes->where('tipo', 'receita')->sum('valor') - 
                          $transacoes->where('tipo', 'despesa')->sum('valor')
            ]];
        });

        return view('financeiro.relatorio-anual', compact('resumoAnual', 'ano'));
    }

    public function metas()
    {
        $metas = Meta::where('user_id', auth()->id())
            ->orderBy('status')
            ->orderBy('data_limite')
            ->get();

        return view('financeiro.metas', compact('metas'));
    }

    public function exportarTransacoes(Request $request)
    {
        $transacoes = Transacao::where('user_id', auth()->id())
            ->whereMonth('data', $request->get('mes', now()->month))
            ->whereYear('data', $request->get('ano', now()->year))
            ->orderBy('data')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="transacoes.csv"',
        ];

        $colunas = ['Data', 'Descrição', 'Categoria', 'Tipo', 'Valor', 'Observações'];

        $callback = function () use ($transacoes, $colunas) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $colunas);

            foreach ($transacoes as $transacao) {
                fputcsv($file, [
                    $transacao->data->format('d/m/Y'),
                    $transacao->descricao,
                    $transacao->categoria,
                    $transacao->tipo,
                    number_format($transacao->valor, 2, ',', '.'),
                    $transacao->observacoes
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
} 