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
        $capacitacoes = Capacitacao::with(['instrutor', 'participantes', 'materiais'])
            ->latest()
            ->paginate(10);

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
            'descricao' => 'required|string',
            'data' => 'required|date',
            'instrutor_id' => 'required|exists:users,id',
            'local' => 'required|string|max:255',
            'duracao' => 'required|integer|min:1',
            'vagas' => 'required|integer|min:1',
            'materiais.*' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:10240',
        ]);

        $capacitacao = Capacitacao::create($validated);

        if ($request->hasFile('materiais')) {
            foreach ($request->file('materiais') as $material) {
                $path = $material->store('materiais-capacitacao');
                $capacitacao->materiais()->create([
                    'nome' => $material->getClientOriginalName(),
                    'caminho' => $path,
                    'tamanho' => $material->getSize(),
                ]);
            }
        }

        return redirect()->route('capacitacoes.index')
            ->with('success', 'Capacitação criada com sucesso!');
    }

    public function show(Capacitacao $capacitacao)
    {
        $capacitacao->load(['instrutor', 'participantes', 'materiais']);
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
            'descricao' => 'required|string',
            'data' => 'required|date',
            'instrutor_id' => 'required|exists:users,id',
            'local' => 'required|string|max:255',
            'duracao' => 'required|integer|min:1',
            'vagas' => 'required|integer|min:1',
            'materiais.*' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:10240',
        ]);

        $capacitacao->update($validated);

        if ($request->hasFile('materiais')) {
            foreach ($request->file('materiais') as $material) {
                $path = $material->store('materiais-capacitacao');
                $capacitacao->materiais()->create([
                    'nome' => $material->getClientOriginalName(),
                    'caminho' => $path,
                    'tamanho' => $material->getSize(),
                ]);
            }
        }

        return redirect()->route('capacitacoes.index')
            ->with('success', 'Capacitação atualizada com sucesso!');
    }

    public function destroy(Capacitacao $capacitacao)
    {
        foreach ($capacitacao->materiais as $material) {
            Storage::delete($material->caminho);
        }
        
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