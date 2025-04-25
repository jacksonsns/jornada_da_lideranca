<?php

namespace App\Http\Controllers;

use App\Models\Desafio;
use Illuminate\Http\Request;

class DesafioController extends Controller
{
    public function index()
    {
        $desafios = Desafio::latest()->paginate(10);
        return view('desafios.index', compact('desafios'));
    }

    public function create()
    {
        return view('desafios.create');
    }

    public function store(Request $request)
    {
        $validados = $request->validate([
            'titulo' => 'required|max:255',
            'descricao' => 'required',
            'data_limite' => 'nullable|date'
        ]);

        $validados['status'] = 'pendente';
        $validados['user_id'] = auth()->id();

        Desafio::create($validados);

        return redirect()->route('desafios.index')
            ->with('sucesso', 'Desafio criado com sucesso!');
    }

    public function show(Desafio $desafio)
    {
        return view('desafios.show', compact('desafio'));
    }

    public function edit(Desafio $desafio)
    {
        return view('desafios.edit', compact('desafio'));
    }

    public function update(Request $request, Desafio $desafio)
    {
        $validados = $request->validate([
            'titulo' => 'required|max:255',
            'descricao' => 'required',
            'data_limite' => 'nullable|date'
        ]);

        $desafio->update($validados);

        return redirect()->route('desafios.show', $desafio)
            ->with('sucesso', 'Desafio atualizado com sucesso!');
    }

    public function destroy(Desafio $desafio)
    {
        $desafio->delete();

        return redirect()->route('desafios.index')
            ->with('sucesso', 'Desafio excluído com sucesso!');
    }

    public function concluir(Desafio $desafio)
    {
        $user = auth()->user();
        
        // Atualiza a relação pivot
        $user->desafios()->updateExistingPivot($desafio->id, [
            'concluido' => true,
            'concluido_em' => now()
        ]);

        // Retorna uma resposta JSON para requisições AJAX
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Desafio concluído com sucesso!'
            ]);
        }

        // Redireciona com mensagem de sucesso para requisições normais
        return redirect()->back()
            ->with('sucesso', 'Desafio concluído com sucesso!');
    }
} 