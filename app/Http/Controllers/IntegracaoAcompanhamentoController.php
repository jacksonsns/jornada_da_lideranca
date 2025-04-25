<?php

namespace App\Http\Controllers;

use App\Models\IntegracaoAcompanhamento;
use App\Models\AvaliacaoDesempenho;
use App\Models\Feedback;
use Illuminate\Http\Request;

class IntegracaoAcompanhamentoController extends Controller
{
    public function index()
    {
        $integracao = IntegracaoAcompanhamento::with(['user', 'mentor', 'avaliacoes', 'feedbacks'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('integracao-acompanhamento.index', compact('integracao'));
    }

    public function create()
    {
        return view('integracao-acompanhamento.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mentor_id' => 'required|exists:users,id',
            'tipo' => 'required|in:mentoria,feedback,avaliacao',
            'data_agendada' => 'required|date',
            'duracao_minutos' => 'required|integer|min:15',
            'observacoes' => 'nullable|string',
            'metas_definidas' => 'nullable|string',
            'proximos_passos' => 'nullable|string',
            'status' => 'required|in:agendado,realizado,cancelado,remarcado',
            'metricas_desempenho' => 'nullable|string'
        ]);

        $integracao = IntegracaoAcompanhamento::create(array_merge($validated, [
            'user_id' => auth()->id()
        ]));

        return redirect()->route('integracao-acompanhamento.index')
            ->with('success', 'Sessão de integração/acompanhamento criada com sucesso!');
    }

    public function show(IntegracaoAcompanhamento $integracao)
    {
        $this->authorize('view', $integracao);
        
        $integracao->load(['user', 'mentor', 'avaliacoes', 'feedbacks']);
        return view('integracao-acompanhamento.show', compact('integracao'));
    }

    public function edit(IntegracaoAcompanhamento $integracao)
    {
        $this->authorize('update', $integracao);
        
        return view('integracao-acompanhamento.edit', compact('integracao'));
    }

    public function update(Request $request, IntegracaoAcompanhamento $integracao)
    {
        $this->authorize('update', $integracao);

        $validated = $request->validate([
            'mentor_id' => 'required|exists:users,id',
            'tipo' => 'required|in:mentoria,feedback,avaliacao',
            'data_agendada' => 'required|date',
            'duracao_minutos' => 'required|integer|min:15',
            'observacoes' => 'nullable|string',
            'metas_definidas' => 'nullable|string',
            'proximos_passos' => 'nullable|string',
            'status' => 'required|in:agendado,realizado,cancelado,remarcado',
            'metricas_desempenho' => 'nullable|string'
        ]);

        $integracao->update($validated);

        return redirect()->route('integracao-acompanhamento.index')
            ->with('success', 'Sessão de integração/acompanhamento atualizada com sucesso!');
    }

    public function destroy(IntegracaoAcompanhamento $integracao)
    {
        $this->authorize('delete', $integracao);
        
        $integracao->delete();

        return redirect()->route('integracao-acompanhamento.index')
            ->with('success', 'Sessão de integração/acompanhamento excluída com sucesso!');
    }

    public function adicionarAvaliacao(Request $request, IntegracaoAcompanhamento $integracao)
    {
        $this->authorize('update', $integracao);

        $validated = $request->validate([
            'lideranca' => 'required|integer|min:1|max:5',
            'comunicacao' => 'required|integer|min:1|max:5',
            'trabalho_equipe' => 'required|integer|min:1|max:5',
            'proatividade' => 'required|integer|min:1|max:5',
            'comprometimento' => 'required|integer|min:1|max:5',
            'pontos_fortes' => 'nullable|string',
            'areas_melhoria' => 'nullable|string',
            'recomendacoes' => 'nullable|string'
        ]);

        $integracao->avaliacoes()->create($validated);

        return redirect()->back()
            ->with('success', 'Avaliação de desempenho adicionada com sucesso!');
    }

    public function adicionarFeedback(Request $request, IntegracaoAcompanhamento $integracao)
    {
        $this->authorize('update', $integracao);

        $validated = $request->validate([
            'feedback' => 'required|string',
            'tipo' => 'required|in:positivo,construtivo,geral',
            'acoes_recomendadas' => 'nullable|string',
            'prazo_implementacao' => 'nullable|date'
        ]);

        $integracao->feedbacks()->create($validated);

        return redirect()->back()
            ->with('success', 'Feedback adicionado com sucesso!');
    }

    public function atualizarStatus(Request $request, IntegracaoAcompanhamento $integracao)
    {
        $this->authorize('update', $integracao);

        $validated = $request->validate([
            'status' => 'required|in:agendado,realizado,cancelado,remarcado'
        ]);

        $integracao->update($validated);

        return redirect()->back()
            ->with('success', 'Status atualizado com sucesso!');
    }
} 