<?php

namespace App\Http\Controllers;

use App\Models\ProjetoIndividual;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjetoIndividualController extends Controller
{
    public function index()
    {
        $projetos = ProjetoIndividual::where('user_id', auth()->id())
            ->withCount(['tarefas', 'tarefasConcluidas'])
            ->latest()
            ->paginate(10);

        return view('projetos.index', compact('projetos'));
    }

    public function create()
    {
        return view('projetos.create');
    }

    public function store(Request $request)
    {
        $validados = $request->validate([
            'titulo' => 'required|max:255',
            'descricao' => 'required',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio',
            'objetivo' => 'required|string',
            'area' => 'required|in:pessoal,profissional,academico,social,outro',
            'prioridade' => 'required|in:baixa,media,alta',
            'anexos.*' => 'nullable|file|max:5120'
        ]);

        $validados['user_id'] = auth()->id();
        $validados['status'] = 'em_andamento';

        if ($request->hasFile('anexos')) {
            $anexos = [];
            foreach ($request->file('anexos') as $anexo) {
                $anexos[] = $anexo->store('projetos/anexos', 'public');
            }
            $validados['anexos'] = $anexos;
        }

        $projeto = ProjetoIndividual::create($validados);

        return redirect()->route('projetos.show', $projeto)
            ->with('sucesso', 'Projeto criado com sucesso!');
    }

    public function show(ProjetoIndividual $projeto)
    {
        if ($projeto->user_id !== auth()->id()) {
            abort(403);
        }

        $projeto->load(['tarefas' => function ($query) {
            $query->orderBy('ordem');
        }]);

        return view('projetos.show', compact('projeto'));
    }

    public function edit(ProjetoIndividual $projeto)
    {
        if ($projeto->user_id !== auth()->id()) {
            abort(403);
        }

        return view('projetos.edit', compact('projeto'));
    }

    public function update(Request $request, ProjetoIndividual $projeto)
    {
        if ($projeto->user_id !== auth()->id()) {
            abort(403);
        }

        $validados = $request->validate([
            'titulo' => 'required|max:255',
            'descricao' => 'required',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio',
            'objetivo' => 'required|string',
            'area' => 'required|in:pessoal,profissional,academico,social,outro',
            'prioridade' => 'required|in:baixa,media,alta',
            'status' => 'required|in:em_andamento,concluido,cancelado,pausado',
            'anexos.*' => 'nullable|file|max:5120'
        ]);

        if ($request->hasFile('anexos')) {
            $anexos = $projeto->anexos ?? [];
            foreach ($request->file('anexos') as $anexo) {
                $anexos[] = $anexo->store('projetos/anexos', 'public');
            }
            $validados['anexos'] = $anexos;
        }

        $projeto->update($validados);

        return redirect()->route('projetos.show', $projeto)
            ->with('sucesso', 'Projeto atualizado com sucesso!');
    }

    public function destroy(ProjetoIndividual $projeto)
    {
        if ($projeto->user_id !== auth()->id()) {
            abort(403);
        }

        if ($projeto->anexos) {
            foreach ($projeto->anexos as $anexo) {
                Storage::disk('public')->delete($anexo);
            }
        }

        $projeto->delete();

        return redirect()->route('projetos.index')
            ->with('sucesso', 'Projeto excluído com sucesso!');
    }

    public function adicionarTarefa(Request $request, ProjetoIndividual $projeto)
    {
        if ($projeto->user_id !== auth()->id()) {
            abort(403);
        }

        $validados = $request->validate([
            'descricao' => 'required|string',
            'data_limite' => 'nullable|date',
            'prioridade' => 'required|in:baixa,media,alta'
        ]);

        $validados['ordem'] = $projeto->tarefas()->max('ordem') + 1;
        
        $projeto->tarefas()->create($validados);

        return redirect()->route('projetos.show', $projeto)
            ->with('sucesso', 'Tarefa adicionada com sucesso!');
    }

    public function concluirTarefa(Tarefa $tarefa)
    {
        if ($tarefa->projeto->user_id !== auth()->id()) {
            abort(403);
        }

        $tarefa->update([
            'concluida' => true,
            'data_conclusao' => now()
        ]);

        // Verifica se todas as tarefas foram concluídas
        if (!$tarefa->projeto->tarefas()->where('concluida', false)->exists()) {
            $tarefa->projeto->update(['status' => 'concluido']);
        }

        return redirect()->route('projetos.show', $tarefa->projeto)
            ->with('sucesso', 'Tarefa concluída com sucesso!');
    }

    public function reordenarTarefas(Request $request, ProjetoIndividual $projeto)
    {
        if ($projeto->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'tarefas' => 'required|array',
            'tarefas.*' => 'exists:tarefas,id'
        ]);

        foreach ($request->tarefas as $ordem => $tarefaId) {
            Tarefa::where('id', $tarefaId)->update(['ordem' => $ordem + 1]);
        }

        return response()->json(['message' => 'Tarefas reordenadas com sucesso']);
    }

    public function relatorio(ProjetoIndividual $projeto)
    {
        if ($projeto->user_id !== auth()->id()) {
            abort(403);
        }

        $projeto->load(['tarefas' => function ($query) {
            $query->orderBy('created_at');
        }]);

        return view('projetos.relatorio', compact('projeto'));
    }
} 