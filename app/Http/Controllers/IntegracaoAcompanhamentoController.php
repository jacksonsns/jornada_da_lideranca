<?php

namespace App\Http\Controllers;

use App\Models\IntegracaoAcompanhamento;
use App\Models\Mentor;
use App\Models\Reuniao;
use App\Models\Feedback;
use Illuminate\Http\Request;

class IntegracaoAcompanhamentoController extends Controller
{
    public function index()
    {
        $mentor = auth()->user()->mentor;
        $mentorados = auth()->user()->mentorados;
        $proximasReunioes = Reuniao::where(function ($query) {
            $query->where('mentor_id', auth()->id())
                  ->orWhere('mentorado_id', auth()->id());
        })->whereDate('data', '>=', now())
          ->orderBy('data')
          ->take(5)
          ->get();

        return view('integracao.index', compact('mentor', 'mentorados', 'proximasReunioes'));
    }

    public function solicitarMentoria(Request $request)
    {
        $validados = $request->validate([
            'mentor_id' => 'required|exists:users,id',
            'mensagem' => 'required|string|max:500',
            'areas_interesse' => 'required|array',
            'areas_interesse.*' => 'string'
        ]);

        $solicitacao = IntegracaoAcompanhamento::create([
            'mentor_id' => $validados['mentor_id'],
            'mentorado_id' => auth()->id(),
            'mensagem' => $validados['mensagem'],
            'areas_interesse' => $validados['areas_interesse'],
            'status' => 'pendente'
        ]);

        return redirect()->route('integracao.index')
            ->with('sucesso', 'Solicitação de mentoria enviada com sucesso!');
    }

    public function responderSolicitacao(Request $request, IntegracaoAcompanhamento $solicitacao)
    {
        if ($solicitacao->mentor_id !== auth()->id()) {
            abort(403);
        }

        $validados = $request->validate([
            'status' => 'required|in:aceita,recusada',
            'observacoes' => 'nullable|string|max:500'
        ]);

        $solicitacao->update($validados);

        if ($validados['status'] === 'aceita') {
            Mentor::create([
                'mentor_id' => auth()->id(),
                'mentorado_id' => $solicitacao->mentorado_id,
                'data_inicio' => now()
            ]);
        }

        return redirect()->route('integracao.solicitacoes')
            ->with('sucesso', 'Solicitação ' . ($validados['status'] === 'aceita' ? 'aceita' : 'recusada') . ' com sucesso!');
    }

    public function agendarReuniao(Request $request)
    {
        $validados = $request->validate([
            'mentorado_id' => 'required|exists:users,id',
            'data' => 'required|date|after:today',
            'hora' => 'required|date_format:H:i',
            'duracao' => 'required|integer|min:15|max:180',
            'tipo' => 'required|in:presencial,online',
            'local' => 'required_if:tipo,presencial|nullable|string',
            'link' => 'required_if:tipo,online|nullable|url',
            'pauta' => 'required|string'
        ]);

        $validados['mentor_id'] = auth()->id();
        $validados['data'] = date('Y-m-d H:i:s', strtotime("{$validados['data']} {$validados['hora']}"));
        unset($validados['hora']);

        $reuniao = Reuniao::create($validados);

        return redirect()->route('integracao.reunioes')
            ->with('sucesso', 'Reunião agendada com sucesso!');
    }

    public function registrarFeedback(Request $request, Reuniao $reuniao)
    {
        if ($reuniao->mentor_id !== auth()->id()) {
            abort(403);
        }

        $validados = $request->validate([
            'pontos_fortes' => 'required|string',
            'pontos_melhoria' => 'required|string',
            'recomendacoes' => 'required|string',
            'avaliacao' => 'required|integer|min:1|max:5',
            'proximos_passos' => 'required|string'
        ]);

        $feedback = $reuniao->feedback()->create($validados);

        return redirect()->route('integracao.reunioes')
            ->with('sucesso', 'Feedback registrado com sucesso!');
    }

    public function minhasReunioes()
    {
        $reunioes = Reuniao::where('mentor_id', auth()->id())
            ->orWhere('mentorado_id', auth()->id())
            ->with(['mentor', 'mentorado', 'feedback'])
            ->orderBy('data', 'desc')
            ->paginate(10);

        return view('integracao.reunioes', compact('reunioes'));
    }

    public function meusFeedbacks()
    {
        $feedbacksRecebidos = Feedback::whereHas('reuniao', function ($query) {
            $query->where('mentorado_id', auth()->id());
        })->with(['reuniao.mentor'])->latest()->get();

        $feedbacksEnviados = Feedback::whereHas('reuniao', function ($query) {
            $query->where('mentor_id', auth()->id());
        })->with(['reuniao.mentorado'])->latest()->get();

        return view('integracao.feedbacks', compact('feedbacksRecebidos', 'feedbacksEnviados'));
    }

    public function relatorioProgresso(Request $request)
    {
        $mentorado = $request->user_id ? User::findOrFail($request->user_id) : auth()->user();
        
        if ($mentorado->id !== auth()->id() && !$mentorado->mentores->contains(auth()->id())) {
            abort(403);
        }

        $reunioes = Reuniao::where('mentorado_id', $mentorado->id)
            ->with(['feedback'])
            ->orderBy('data')
            ->get();

        $feedbacks = $reunioes->pluck('feedback')->filter();
        
        $avaliacoes = $feedbacks->pluck('avaliacao');
        $mediaAvaliacoes = $avaliacoes->average();
        $evolucao = $avaliacoes->count() > 1 ? 
            ($avaliacoes->last() - $avaliacoes->first()) / $avaliacoes->first() * 100 : 0;

        return view('integracao.relatorio-progresso', compact(
            'mentorado',
            'reunioes',
            'feedbacks',
            'mediaAvaliacoes',
            'evolucao'
        ));
    }
} 