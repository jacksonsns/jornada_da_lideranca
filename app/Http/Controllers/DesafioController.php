<?php

namespace App\Http\Controllers;

use App\Models\Desafio;
use App\Models\DesafioUser;
use Illuminate\Http\Request;
use App\Services\DesafioAutomaticoService;
use App\Models\JornadaAspiranteUser;

class DesafioController extends Controller
{
    protected $desafioAutomaticoService;

    public function __construct(DesafioAutomaticoService $desafioAutomaticoService)
    {
        $this->desafioAutomaticoService = $desafioAutomaticoService;
    }

    public function index()
    {
        $user = auth()->user();
        
        $desafios = DesafioUser::where('user_id', $user->id)
            ->with('desafio')
            ->get();
    
        $quantidadeDesafiosConcluidos = DesafioUser::where('user_id', $user->id)
            ->where('concluido', 1)
            ->count();
        
        $totalPontos = DesafioUser::where('user_id', $user->id)
            ->where('concluido', 1)
            ->join('desafios', 'desafios.id', '=', 'desafio_user.desafio_id')
            ->sum('desafios.pontos');

        $totalPontosJornada = JornadaAspiranteUser::where('user_id', $user->id)
            ->where('concluido', 1)
            ->join('jornada_aspirante', 'jornada_aspirante.id', '=', 'jornada_aspirante_user.jornada_aspirante_id')
            ->sum('jornada_aspirante.pontos');

        $totalPontos = $totalPontos + $totalPontosJornada;

        $jornadaConcluida = DesafioUser::where('user_id', $user->id)->where('concluido', 1)->count();
        $totalJornada = DesafioUser::where('user_id', $user->id)->count();

        $progresso = $jornadaConcluida > 0 ? round(($jornadaConcluida * $totalJornada) / 100) : 0;
        
        return view('desafios.index', [
            'desafios' => $desafios,
            'progresso' => $progresso,
            'totalDesafios' => Desafio::count(),
            'conquistas' => $quantidadeDesafiosConcluidos,
            'totalPontos' => $totalPontos,
        ]);
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

    public function concluir(Request $request)
    {
        $desafio = DesafioUser::where('user_id', auth()->id())
            ->where('id', $request->input('desafio_id'))
            ->first();
     
        // Valida se o desafio existe
        if (!$desafio) {
            return redirect()->back()
                ->with('erro', 'Desafio não encontrado.');
        }
        
        // Atualiza a relação pivot
        $desafio->update([
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