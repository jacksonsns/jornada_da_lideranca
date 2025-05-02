<?php

namespace App\Http\Controllers;

use App\Models\QuadroDosSonhos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuadroDosSonhosController extends Controller
{
    public function index()
    {
        $sonhos = QuadroDosSonhos::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);
 
        return view('quadro-dos-sonhos.index', compact('sonhos'));
    }

    public function create()
    {
        return view('quadro-dos-sonhos.create');
    }

    public function store(Request $request)
    {
        $validados = $request->validate([
            'titulo' => 'required|max:255',
            'descricao' => 'required',
            'categoria' => 'required|in:pessoal,profissional,financeiro,saude,relacionamentos,outros',
            'imagem' => 'nullable|image|max:2048'
        ]);
    
        if ($request->hasFile('imagem')) {
            $path = $request->file('imagem')->store('sonhos', 'public');
            logger('Imagem salva em: ' . $path);
            $validados['imagem'] = $path;
        }

        $validados['user_id'] = auth()->id();

        QuadroDosSonhos::create($validados);

        return redirect()->route('quadro-dos-sonhos.index')
            ->with('sucesso', 'Sonho adicionado com sucesso!');
    }

    public function show(QuadroDosSonhos $sonho)
    {
        return view('quadro-dos-sonhos.show', compact('sonho'));
    }

    public function edit(QuadroDosSonhos $sonho)
    {
        return view('quadro-dos-sonhos.edit', compact('sonho'));
    }

    public function update(Request $request, QuadroDosSonhos $sonho)
    {
        $validados = $request->validate([
            'titulo' => 'required|max:255',
            'descricao' => 'required',
            'categoria' => 'required|in:pessoal,profissional,financeiro,saude,relacionamentos,outros',
            'data_realizacao' => 'nullable|date',
            'status' => 'required|in:pendente,em_andamento,realizado',
            'imagem' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('imagem')) {
            if ($sonho->imagem) {
                Storage::disk('public')->delete($sonho->imagem);
            }
            $validados['imagem'] = $request->file('imagem')->store('sonhos', 'public');
        }

        $sonho->update($validados);

        return redirect()->route('quadro-dos-sonhos.show', $sonho)
            ->with('sucesso', 'Sonho atualizado com sucesso!');
    }

    public function destroy(QuadroDosSonhos $sonho)
    {
        if ($sonho->imagem) {
            Storage::disk('public')->delete($sonho->imagem);
        }

        $sonho->delete();

        return redirect()->route('quadro-dos-sonhos.index')
            ->with('sucesso', 'Sonho excluído com sucesso!');
    }

    public function realizar(QuadroDosSonhos $sonho)
    {
        $sonho->update(['status' => 'realizado']);

        return redirect()->route('quadro-dos-sonhos.show', $sonho)
            ->with('sucesso', 'Parabéns! Seu sonho foi marcado como realizado!');
    }
} 