<?php

namespace App\Http\Controllers;

use App\Models\Capacitacao;
use App\Models\CapacitacaoParticipante;
use App\Models\CapacitacaoMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CapacitacaoController extends Controller
{
    public function index()
    {
        $capacitacoes = Capacitacao::orderBy('data', 'desc')->paginate(10);
        return view('capacitacoes.index', compact('capacitacoes'));
    }

    public function create()
    {
        return view('capacitacoes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'data' => 'required|date',
            'insights' => 'required|string'
        ]);

        Capacitacao::create($validated);

        return redirect()->route('capacitacoes.index')
            ->with('success', 'Capacitação criada com sucesso!');
    }

    public function show(Capacitacao $capacitacao)
    {
        return view('capacitacoes.show', compact('capacitacao'));
    }

    public function edit(Capacitacao $capacitacao)
    {
        return view('capacitacoes.edit', compact('capacitacao'));
    }

    public function update(Request $request, Capacitacao $capacitacao)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'data' => 'required|date',
            'insights' => 'required|string'
        ]);

        $capacitacao->update($validated);

        return redirect()->route('capacitacoes.index')
            ->with('success', 'Capacitação atualizada com sucesso!');
    }

    public function destroy(Capacitacao $capacitacao)
    {
        $capacitacao->delete();

        return redirect()->route('capacitacoes.index')
            ->with('success', 'Capacitação excluída com sucesso!');
    }

    public function inscrever(Capacitacao $capacitacao)
    {
        if ($capacitacao->vagas_disponiveis > 0) {
            $capacitacao->participantes()->create([
                'user_id' => auth()->id(),
                'status' => 'confirmado'
            ]);

            return redirect()->back()
                ->with('success', 'Inscrição realizada com sucesso!');
        }

        return redirect()->back()
            ->with('error', 'Não há vagas disponíveis para esta capacitação.');
    }

    public function cancelarInscricao(Capacitacao $capacitacao)
    {
        $capacitacao->participantes()
            ->where('user_id', auth()->id())
            ->delete();

        return redirect()->back()
            ->with('success', 'Inscrição cancelada com sucesso!');
    }

    public function downloadMaterial(CapacitacaoMaterial $material)
    {
        return Storage::download($material->caminho, $material->nome);
    }
} 