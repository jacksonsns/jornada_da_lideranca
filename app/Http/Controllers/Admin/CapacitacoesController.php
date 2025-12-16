<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Capacitacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CapacitacoesController extends Controller
{
    public function index()
    {
        $capacitacoes = Capacitacao::orderBy('data', 'desc')->get();
        return view('admin.capacitacoes.index', compact('capacitacoes'));
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'data' => 'required|date',
            'titulo' => 'required|string|max:255',
            'insights' => 'required|string'
        ]);

        $data = $request->except('material');

        if ($request->hasFile('material')) {
            $file = $request->file('material');
            $path = $file->store('capacitacoes/materiais', 'public');
            $data['material_url'] = $path;
        }

        Capacitacao::create($data);

        return redirect()->route('admin.capacitacoes.index')
            ->with('success', 'Capacitação registrada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $validator = $request->validate([
            'data' => 'required|date',
            'titulo' => 'required|string|max:255',
            'insights' => 'required|string',
            'material' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar|max:10240'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $capacitacao = Capacitacao::findOrFail($id);
        $data = $request->except('material');

        if ($request->hasFile('material')) {
            // Delete old file if exists
            if ($capacitacao->material_url) {
                Storage::disk('public')->delete($capacitacao->material_url);
            }

            $file = $request->file('material');
            $path = $file->store('capacitacoes/materiais', 'public');
            $data['material_url'] = $path;
        }

        $capacitacao->update($data);

        return redirect()->route('admin.capacitacoes.index')
            ->with('success', 'Capacitação atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $capacitacao = Capacitacao::findOrFail($id);
        
        // Delete material file if exists
        if ($capacitacao->material_url) {
            Storage::disk('public')->delete($capacitacao->material_url);
        }
        
        $capacitacao->delete();

        return redirect()->route('admin.capacitacoes.index')
            ->with('success', 'Capacitação excluída com sucesso!');
    }
}