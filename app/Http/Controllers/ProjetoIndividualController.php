<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use App\Models\MetaProjeto;
use App\Models\AtualizacaoProjeto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjetoIndividualController extends Controller
{
    public function index()
    {
        $projetos = Projeto::where('user_id', Auth::id())
            ->with(['metas', 'atualizacoes'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('projetos-individuais.index', compact('projetos'));
    }

    public function create()
    {
        return view('projetos-individuais.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'objetivo' => 'required|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio',
            'metas_5_anos' => 'required|string',
            'indicadores_sucesso' => 'required|string',
            'recursos_necessarios' => 'required|string'
        ]);

        $projeto = new Projeto($request->all());
        $projeto->user_id = Auth::id();
        $projeto->status = 'planejamento';
        $projeto->progresso = 0;
        $projeto->save();

        return redirect()->route('projetos-individuais.index')
            ->with('success', 'Projeto criado com sucesso!');
    }

    public function show(Projeto $projeto)
    {
        $this->authorize('view', $projeto);
        
        $projeto->load(['metas', 'atualizacoes', 'mentores']);
        
        return view('projetos-individuais.show', compact('projeto'));
    }

    public function edit(Projeto $projeto)
    {
        $this->authorize('update', $projeto);
        return view('projetos-individuais.edit', compact('projeto'));
    }

    public function update(Request $request, Projeto $projeto)
    {
        $this->authorize('update', $projeto);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'objetivo' => 'required|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio',
            'metas_5_anos' => 'required|string',
            'indicadores_sucesso' => 'required|string',
            'recursos_necessarios' => 'required|string'
        ]);

        $projeto->update($request->all());

        return redirect()->route('projetos-individuais.show', $projeto)
            ->with('success', 'Projeto atualizado com sucesso!');
    }

    public function destroy(Projeto $projeto)
    {
        $this->authorize('delete', $projeto);
        $projeto->delete();

        return redirect()->route('projetos-individuais.index')
            ->with('success', 'Projeto excluído com sucesso!');
    }

    public function concluir(Projeto $projeto)
    {
        $this->authorize('update', $projeto);
        
        $projeto->update([
            'status' => 'concluido',
            'progresso' => 100
        ]);

        return redirect()->route('projetos-individuais.show', $projeto)
            ->with('success', 'Projeto concluído com sucesso!');
    }

    public function atualizarProgresso(Request $request, Projeto $projeto)
    {
        $this->authorize('update', $projeto);

        $request->validate([
            'progresso' => 'required|integer|min:0|max:100',
            'descricao' => 'required|string',
            'dificuldades' => 'nullable|string',
            'solucoes' => 'nullable|string'
        ]);

        $projeto->update(['progresso' => $request->progresso]);

        AtualizacaoProjeto::create([
            'projeto_id' => $projeto->id,
            'descricao' => $request->descricao,
            'progresso' => $request->progresso,
            'dificuldades' => $request->dificuldades,
            'solucoes' => $request->solucoes
        ]);

        return redirect()->route('projetos-individuais.show', $projeto)
            ->with('success', 'Progresso atualizado com sucesso!');
    }
} 