<?php

namespace App\Http\Controllers;

use App\Models\Capacitacao;
use App\Models\Inscricao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CapacitacaoController extends Controller
{
    public function index()
    {
        $capacitacoes = Capacitacao::with(['inscricoes' => function ($query) {
            $query->where('user_id', auth()->id());
        }])->latest()->paginate(9);

        return view('capacitacoes.index', compact('capacitacoes'));
    }

    public function create()
    {
        return view('capacitacoes.create');
    }

    public function store(Request $request)
    {
        $validados = $request->validate([
            'titulo' => 'required|max:255',
            'descricao' => 'required',
            'data_inicio' => 'required|date|after:today',
            'data_fim' => 'required|date|after:data_inicio',
            'vagas' => 'required|integer|min:1',
            'local' => 'required|string',
            'imagem' => 'nullable|image|max:2048',
            'pre_requisitos' => 'nullable|string',
            'investimento' => 'nullable|numeric|min:0'
        ]);

        if ($request->hasFile('imagem')) {
            $validados['imagem'] = $request->file('imagem')->store('capacitacoes', 'public');
        }

        $validados['instrutor_id'] = auth()->id();
        $validados['status'] = 'agendada';

        Capacitacao::create($validados);

        return redirect()->route('capacitacoes.index')
            ->with('sucesso', 'Capacitação criada com sucesso!');
    }

    public function show(Capacitacao $capacitacao)
    {
        $inscrito = $capacitacao->inscricoes()->where('user_id', auth()->id())->exists();
        $vagasDisponiveis = $capacitacao->vagas - $capacitacao->inscricoes()->count();

        return view('capacitacoes.show', compact('capacitacao', 'inscrito', 'vagasDisponiveis'));
    }

    public function edit(Capacitacao $capacitacao)
    {
        if ($capacitacao->instrutor_id !== auth()->id()) {
            abort(403);
        }

        return view('capacitacoes.edit', compact('capacitacao'));
    }

    public function update(Request $request, Capacitacao $capacitacao)
    {
        if ($capacitacao->instrutor_id !== auth()->id()) {
            abort(403);
        }

        $validados = $request->validate([
            'titulo' => 'required|max:255',
            'descricao' => 'required',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio',
            'vagas' => 'required|integer|min:' . $capacitacao->inscricoes()->count(),
            'local' => 'required|string',
            'imagem' => 'nullable|image|max:2048',
            'pre_requisitos' => 'nullable|string',
            'investimento' => 'nullable|numeric|min:0',
            'status' => 'required|in:agendada,em_andamento,concluida,cancelada'
        ]);

        if ($request->hasFile('imagem')) {
            if ($capacitacao->imagem) {
                Storage::disk('public')->delete($capacitacao->imagem);
            }
            $validados['imagem'] = $request->file('imagem')->store('capacitacoes', 'public');
        }

        $capacitacao->update($validados);

        return redirect()->route('capacitacoes.show', $capacitacao)
            ->with('sucesso', 'Capacitação atualizada com sucesso!');
    }

    public function destroy(Capacitacao $capacitacao)
    {
        if ($capacitacao->instrutor_id !== auth()->id()) {
            abort(403);
        }

        if ($capacitacao->inscricoes()->exists()) {
            return redirect()->route('capacitacoes.show', $capacitacao)
                ->with('erro', 'Não é possível excluir uma capacitação com inscrições!');
        }

        if ($capacitacao->imagem) {
            Storage::disk('public')->delete($capacitacao->imagem);
        }

        $capacitacao->delete();

        return redirect()->route('capacitacoes.index')
            ->with('sucesso', 'Capacitação excluída com sucesso!');
    }

    public function inscrever(Capacitacao $capacitacao)
    {
        if ($capacitacao->inscricoes()->where('user_id', auth()->id())->exists()) {
            return redirect()->route('capacitacoes.show', $capacitacao)
                ->with('erro', 'Você já está inscrito nesta capacitação!');
        }

        if ($capacitacao->inscricoes()->count() >= $capacitacao->vagas) {
            return redirect()->route('capacitacoes.show', $capacitacao)
                ->with('erro', 'Não há mais vagas disponíveis!');
        }

        $capacitacao->inscricoes()->create([
            'user_id' => auth()->id(),
            'status' => 'confirmada'
        ]);

        return redirect()->route('capacitacoes.show', $capacitacao)
            ->with('sucesso', 'Inscrição realizada com sucesso!');
    }

    public function cancelarInscricao(Capacitacao $capacitacao)
    {
        $inscricao = $capacitacao->inscricoes()->where('user_id', auth()->id())->firstOrFail();
        $inscricao->delete();

        return redirect()->route('capacitacoes.show', $capacitacao)
            ->with('sucesso', 'Inscrição cancelada com sucesso!');
    }

    public function minhasInscricoes()
    {
        $inscricoes = auth()->user()->inscricoesCapacitacao()
            ->with('capacitacao')
            ->latest()
            ->paginate(10);

        return view('capacitacoes.minhas-inscricoes', compact('inscricoes'));
    }

    public function minhasCapacitacoes()
    {
        $capacitacoes = auth()->user()->capacitacoesMinistradas()
            ->withCount('inscricoes')
            ->latest()
            ->paginate(10);

        return view('capacitacoes.minhas-capacitacoes', compact('capacitacoes'));
    }
} 