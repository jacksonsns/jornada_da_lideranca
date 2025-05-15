<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Capacitacao;
use Illuminate\Http\Request;

class CapacitacoesController extends Controller
{
    public function index()
    {
        $capacitacoes = Capacitacao::orderBy('data', 'desc')->get();
        return view('admin.capacitacoes.index', compact('capacitacoes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'data' => 'required|date',
            'titulo' => 'required|string|max:255',
            'insights' => 'required|string'
        ]);

        Capacitacao::create($request->all());

        return redirect()->route('admin.capacitacoes.index')
            ->with('success', 'Capacitação registrada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'data' => 'required|date',
            'titulo' => 'required|string|max:255',
            'insights' => 'required|string'
        ]);

        $capacitacao = Capacitacao::findOrFail($id);
        $capacitacao->update($request->all());

        return redirect()->route('admin.capacitacoes.index')
            ->with('success', 'Capacitação atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $capacitacao = Capacitacao::findOrFail($id);
        $capacitacao->delete();

        return redirect()->route('admin.capacitacoes.index')
            ->with('success', 'Capacitação excluída com sucesso!');
    }
} 