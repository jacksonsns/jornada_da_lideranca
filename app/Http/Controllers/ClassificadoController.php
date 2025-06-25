<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classificado;
use App\Services\EstadosService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ClassificadoController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Classificado::query();

        // Filtros
        if ($request->filled('categoria')) {
            $query->porCategoria($request->categoria);
        }

        if ($request->filled('preco_min')) {
            $query->where('preco', '>=', $request->preco_min);
        }

        if ($request->filled('preco_max')) {
            $query->where('preco', '<=', $request->preco_max);
        }

        if ($request->filled('estado')) {
            $query->porLocalizacao($request->estado, $request->cidade);
        }

        // Busca por texto
        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('titulo', 'like', "%{$busca}%")
                    ->orWhere('descricao', 'like', "%{$busca}%")
                    ->orWhere('cidade', 'like', "%{$busca}%")
                    ->orWhere('bairro', 'like', "%{$busca}%");
            });
        }

        // Anúncios em destaque
        $destaques = Classificado::destaques()
            ->latest()
            ->take(8)
            ->get();

        // Lista paginada
        $classificados = $query->with('imagens')->latest()->paginate(12);

        // Estados para o filtro
        $estados = EstadosService::getEstados();

        return view('painel-parceiros.index', compact('classificados', 'destaques', 'estados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $estados = EstadosService::getEstados();
        return view('painel-parceiros.create', compact('estados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'estado' => 'required|string|size:2',
            'cidade' => 'required|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'categoria' => 'nullable|string|max:255',
            'beneficio' => 'nullable|string|max:255',
            'site' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'imagens.*' => 'nullable|image|max:2048',
        ]);

        $classificado = auth()->user()->classificados()->create($validated);

        if ($request->hasFile('imagens')) {
            foreach ($request->file('imagens') as $imagem) {
                $caminho = $imagem->store('classificados', 'public');
                $classificado->imagens()->create(['caminho' => $caminho]);
            }
        }

        return redirect()->route('painel-parceiros.show', $classificado)
            ->with('success', 'Anúncio criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classificado $classificado)
    {
        $classificado->increment('visualizacoes');
        $classificado->load('user');

        $relacionados = Classificado::where('categoria', $classificado->categoria)
            ->where('id', '!=', $classificado->id)
            ->latest()
            ->take(4)
            ->get();
   
        return view('painel-parceiros.show', compact('classificado', 'relacionados'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classificado $classificado)
    {
        $this->authorize('update', $classificado);
        $estados = EstadosService::getEstados();
        return view('painel-parceiros.edit', compact('classificado', 'estados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classificado $classificado)
    {
        $this->authorize('update', $classificado);

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'estado' => 'required|string|size:2',
            'cidade' => 'required|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'categoria' => 'nullable|string|max:255',
            'beneficio' => 'nullable|string|max:255',
            'site' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'imagens.*' => 'nullable|image|max:2048',
            'destaque' => 'boolean',
        ]);

        // Atualiza os dados básicos
        $classificado->update($validated);

        // Processa as novas imagens
        if ($request->hasFile('imagens')) {
            foreach ($request->file('imagens') as $imagem) {
                $caminho = $imagem->store('classificados', 'public');
                $classificado->imagens()->create(['caminho' => $caminho]);
            }
        }

        return redirect()->route('painel-parceiros.show', $classificado)
            ->with('success', 'Anúncio atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classificado $classificado)
    {
        $this->authorize('delete', $classificado);

        // Remove todas as imagens do storage
        foreach ($classificado->imagens as $imagem) {
            Storage::disk('public')->delete($imagem->caminho);
        }

        $classificado->delete();

        return redirect()->route('painel-parceiros.index')
            ->with('success', 'Anúncio excluído com sucesso!');
    }
}
