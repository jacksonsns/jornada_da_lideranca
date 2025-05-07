<?php

namespace App\Http\Controllers;

use App\Models\ModuloEscolaLideres;
use App\Models\Aula;
use App\Models\MatriculaEscolaLideres;
use App\Models\AvaliacaoAula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EscolaLideresController extends Controller
{
    public function index()
    {
        $modulos = ModuloEscolaLideres::with(['aulas', 'matriculas' => function($query) {
            $query->where('user_id', Auth::id());
        }])->orderBy('ordem')->get();

        return view('escola-lideres.index', compact('modulos'));
    }

    public function modulo(ModuloEscolaLideres $modulo)
    {
        $matricula = $modulo->matriculas()
            ->where('user_id', Auth::id())
            ->first();

        $aulas = $modulo->aulas()->orderBy('ordem')->get();

        return view('escola-lideres.modulo', compact('modulo', 'matricula', 'aulas'));
    }

    public function matricular(Request $request, ModuloEscolaLideres $modulo)
    {
        MatriculaEscolaLideres::create([
            'user_id' => Auth::id(),
            'modulo_escola_lideres_id' => $modulo->id,
            'data_inicio' => now(),
            'status' => 'em_andamento'
        ]);

        return redirect()->route('escola-lideres.modulo', $modulo)
            ->with('success', 'Matrícula realizada com sucesso!');
    }

    public function aula(Aula $aula)
    {
        $matricula = $aula->modulo->matriculas()
            ->where('user_id', Auth::id())
            ->first();

        if (!$matricula) {
            return redirect()->route('escola-lideres.modulo', $aula->modulo)
                ->with('error', 'Você precisa estar matriculado para acessar esta aula.');
        }

        return view('escola-lideres.aula', compact('aula', 'matricula'));
    }

    public function concluirAula(Request $request, Aula $aula)
    {
        $matricula = $aula->modulo->matriculas()
            ->where('user_id', Auth::id())
            ->first();

        if (!$matricula) {
            return redirect()->back()->with('error', 'Você precisa estar matriculado para concluir esta aula.');
        }

        $matricula->aulasAssistidas()->syncWithoutDetaching([$aula->id]);

        $totalAulas = $aula->modulo->aulas()->count();
        $aulasConcluidas = $matricula->aulasAssistidas()->count();

        if ($totalAulas === $aulasConcluidas) {
            $matricula->update([
                'data_conclusao' => now(),
                'status' => 'concluido'
            ]);
        }

        return redirect()->back()->with('success', 'Aula concluída com sucesso!');
    }

    public function avaliarAula(Request $request, Aula $aula)
    {
        $request->validate([
            'avaliacao' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000'
        ]);

        $matricula = $aula->modulo->matriculas()
            ->where('user_id', Auth::id())
            ->first();

        if (!$matricula) {
            return redirect()->back()->with('error', 'Você precisa estar matriculado para avaliar esta aula.');
        }

        AvaliacaoAula::updateOrCreate(
            [
                'aula_id' => $aula->id,
                'user_id' => Auth::id()
            ],
            [
                'avaliacao' => $request->avaliacao,
                'comentario' => $request->comentario
            ]
        );

        return redirect()->back()->with('success', 'Avaliação registrada com sucesso!');
    }

    public function certificado(ModuloEscolaLideres $ModuloEscolaLideres)
    {
        $matricula = $ModuloEscolaLideres->matriculas()
            ->where('user_id', auth()->id())
            ->where('status', 'concluido')
            ->firstOrFail();

        return view('escola-lideres.certificado', compact('ModuloEscolaLideres', 'matricula'));
    }

    public function progresso()
    {
        $matriculas = auth()->user()->matriculas()
            ->with(['ModuloEscolaLideres', 'aulasAssistidas'])
            ->get();

        return view('escola-lideres.progresso', compact('matriculas'));
    }
}
