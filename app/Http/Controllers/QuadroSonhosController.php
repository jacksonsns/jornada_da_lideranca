<?php

namespace App\Http\Controllers;

use App\Models\QuadroSonhos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuadroSonhosController extends Controller
{
    public function index()
    {
        $sonhos = auth()->user()->sonhos()->latest()->get();
        return view('quadro-sonhos.index', compact('sonhos'));
    }

    public function create()
    {
        return view('quadro-sonhos.create');
    }

    public function store(Request $request)
    {
        $validados = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'imagem' => 'nullable|image|max:2048', // máximo 2MB
            'data_realizacao' => 'nullable|date'
        ]);

        if ($request->hasFile('imagem')) {
            $validados['imagem'] = $request->file('imagem')->store('sonhos', 'public');
        }

        $sonho = auth()->user()->sonhos()->create($validados);

        return redirect()->route('quadro-sonhos.index')
            ->with('sucesso', 'Sonho adicionado com sucesso!');
    }

    public function show(QuadroSonhos $sonho)
    {
        $this->authorize('view', $sonho);
        return view('quadro-sonhos.show', compact('sonho'));
    }

    public function edit(QuadroSonhos $sonho)
    {
        $this->authorize('update', $sonho);
        return view('quadro-sonhos.edit', compact('sonho'));
    }

    public function update(Request $request, QuadroSonhos $sonho)
    {
        $this->authorize('update', $sonho);

        $validados = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'imagem' => 'nullable|image|max:2048',
            'status' => 'required|in:pendente,em_progresso,realizado',
            'data_realizacao' => 'nullable|date'
        ]);

        if ($request->hasFile('imagem')) {
            if ($sonho->imagem) {
                Storage::disk('public')->delete($sonho->imagem);
            }
            $validados['imagem'] = $request->file('imagem')->store('sonhos', 'public');
        }

        $sonho->update($validados);

        return redirect()->route('quadro-sonhos.index')
            ->with('sucesso', 'Sonho atualizado com sucesso!');
    }

    public function destroy(QuadroSonhos $sonho)
    {
        $this->authorize('delete', $sonho);

        if ($sonho->imagem) {
            Storage::disk('public')->delete($sonho->imagem);
        }

        $sonho->delete();

        return redirect()->route('quadro-sonhos.index')
            ->with('sucesso', 'Sonho removido com sucesso!');
    }
} 