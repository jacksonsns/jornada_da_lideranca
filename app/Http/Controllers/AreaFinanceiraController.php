<?php

namespace App\Http\Controllers;

use App\Models\AreaFinanceira;
use App\Models\Transacao;
use App\Models\Meta;
use App\Models\ProjetoIndividual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AreaFinanceiraController extends Controller
{
    public function index(Request $request)
    {
        $query = Transacao::where('user_id', Auth::id());

        // Aplicar filtros
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('data', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('data', '<=', $request->data_fim);
        }

        // Calcular totais
        $receitas = Transacao::where('user_id', Auth::id())
            ->where('tipo', 'receita')
            ->where('status', 'aprovado')
            ->sum('valor');

        $despesas = Transacao::where('user_id', Auth::id())
            ->where('tipo', 'despesa')
            ->where('status', 'aprovado')
            ->sum('valor');

        $saldo = $receitas - $despesas;

        $transacoesPendentes = Transacao::where('user_id', Auth::id())
            ->where('status', 'pendente')
            ->count();

        // Paginar resultados
        $transacoes = $query->orderBy('data', 'desc')->paginate(10);

        return view('area-financeira.index', compact(
            'transacoes',
            'receitas',
            'despesas',
            'saldo',
            'transacoesPendentes'
        ));
    }

    public function create()
    {
        $projetos = auth()->user()->projetos;
        $categorias = [
            'Material',
            'Serviço',
            'Alimentação',
            'Transporte',
            'Hospedagem',
            'Marketing',
            'Outros'
        ];

        return view('area-financeira.create', compact('projetos', 'categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:receita,despesa',
            'valor' => 'required|numeric|min:0',
            'descricao' => 'required|string|max:255',
            'data' => 'required|date',
            'categoria' => 'required|string|max:100',
            'comprovante' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'observacoes' => 'nullable|string'
        ]);

        $transacao = new Transacao($request->all());
        $transacao->user_id = Auth::id();
        $transacao->status = 'pendente';

        if ($request->hasFile('comprovante')) {
            $path = $request->file('comprovante')->store('comprovantes', 'public');
            $transacao->comprovante = $path;
        }

        $transacao->save();

        return redirect()->route('area-financeira.index')
            ->with('success', 'Transação cadastrada com sucesso!');
    }

    public function show(Transacao $transacao)
    {
        $this->authorize('view', $transacao);
        return view('area-financeira.show', compact('transacao'));
    }

    public function edit(Transacao $transacao)
    {
        $this->authorize('update', $transacao);
        return view('area-financeira.edit', compact('transacao'));
    }

    public function update(Request $request, Transacao $transacao)
    {
        $this->authorize('update', $transacao);

        $request->validate([
            'tipo' => 'required|in:receita,despesa',
            'valor' => 'required|numeric|min:0',
            'descricao' => 'required|string|max:255',
            'data' => 'required|date',
            'categoria' => 'required|string|max:100',
            'comprovante' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'observacoes' => 'nullable|string'
        ]);

        $transacao->fill($request->all());

        if ($request->hasFile('comprovante')) {
            $path = $request->file('comprovante')->store('comprovantes', 'public');
            $transacao->comprovante = $path;
        }

        $transacao->save();

        return redirect()->route('area-financeira.index')
            ->with('success', 'Transação atualizada com sucesso!');
    }

    public function destroy(Transacao $transacao)
    {
        $this->authorize('delete', $transacao);
        $transacao->delete();

        return redirect()->route('area-financeira.index')
            ->with('success', 'Transação excluída com sucesso!');
    }

    public function relatorio(Request $request)
    {
        $user = auth()->user();
        $projeto = null;
        $dataInicio = $request->get('data_inicio');
        $dataFim = $request->get('data_fim');

        $query = $user->transacoes();

        if ($request->filled('projeto_id')) {
            $projeto = ProjetoIndividual::findOrFail($request->projeto_id);
            $query->where('projeto_id', $projeto->id);
        }

        if ($dataInicio) {
            $query->whereDate('data_lancamento', '>=', $dataInicio);
        }

        if ($dataFim) {
            $query->whereDate('data_lancamento', '<=', $dataFim);
        }

        $lancamentos = $query->get();
        $totalReceitas = $lancamentos->where('tipo', 'receita')->sum('valor');
        $totalDespesas = $lancamentos->where('tipo', 'despesa')->sum('valor');
        $saldo = $totalReceitas - $totalDespesas;

        $categorias = $lancamentos->groupBy('categoria')
            ->map(function ($items) {
                return [
                    'receitas' => $items->where('tipo', 'receita')->sum('valor'),
                    'despesas' => $items->where('tipo', 'despesa')->sum('valor')
                ];
            });

        return view('area-financeira.relatorio', compact(
            'lancamentos',
            'projeto',
            'dataInicio',
            'dataFim',
            'totalReceitas',
            'totalDespesas',
            'saldo',
            'categorias'
        ));
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