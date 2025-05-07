<?php

namespace App\Http\Controllers;

use App\Models\ProjetoIndividual;
use App\Models\MetaProjeto;
use App\Models\AtualizacaoProjeto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjetoIndividualController extends Controller
{
    public function index()
    {
        $projetos = ProjetoIndividual::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('projetos-individuais.index', compact('projetos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after:data_inicio',
            'resultados' => 'nullable|string'
        ]);

        $projeto = ProjetoIndividual::create([
            'user_id' => auth()->id(),
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'resultados' => $request->resultados,
            'status' => 'em_andamento'
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Projeto individual criado com sucesso!'
            ]);
        }

        return redirect()->route('admin.projetos-individuais.index')
            ->with('success', 'Projeto individual criado com sucesso!');
    }

    public function update(Request $request, ProjetoIndividual $projeto)
    {
        $request->validate([
            'status' => 'required|in:em_andamento,concluido,cancelado'
        ]);

        $projeto->update([
            'status' => $request->status
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status do projeto atualizado com sucesso!'
            ]);
        }

        return redirect()->route('admin.projetos-individuais.index')
            ->with('success', 'Status do projeto atualizado com sucesso!');
    }

    public function destroy(ProjetoIndividual $projeto)
    {
        $projeto->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Projeto individual excluído com sucesso!'
            ]);
        }

        return redirect()->route('admin.projetos-individuais.index')
            ->with('success', 'Projeto individual excluído com sucesso!');
    }
}