<?php

namespace App\Http\Controllers;

use App\Models\EscolaLideres;
use App\Models\Modulo;
use App\Models\Aula;
use Illuminate\Http\Request;

class EscolaLideresController extends Controller
{
    public function index()
    {
        $modulos = Modulo::with(['aulas', 'matriculas' => function ($query) {
            $query->where('user_id', auth()->id());
        }])->orderBy('ordem')->get();

        return view('escola-lideres.index', compact('modulos'));
    }

    public function matricular(Modulo $modulo)
    {
        if ($modulo->matriculas()->where('user_id', auth()->id())->exists()) {
            return redirect()->route('escola-lideres.modulo', $modulo)
                ->with('erro', 'Você já está matriculado neste módulo!');
        }

        $modulo->matriculas()->create([
            'user_id' => auth()->id(),
            'data_inicio' => now(),
            'status' => 'em_andamento'
        ]);

        return redirect()->route('escola-lideres.modulo', $modulo)
            ->with('sucesso', 'Matrícula realizada com sucesso!');
    }

    public function modulo(Modulo $modulo)
    {
        $matricula = $modulo->matriculas()->where('user_id', auth()->id())->first();
        $aulas = $modulo->aulas()->orderBy('ordem')->get();
        
        return view('escola-lideres.modulo', compact('modulo', 'matricula', 'aulas'));
    }

    public function aula(Aula $aula)
    {
        $matricula = $aula->modulo->matriculas()->where('user_id', auth()->id())->firstOrFail();
        
        return view('escola-lideres.aula', compact('aula', 'matricula'));
    }

    public function concluirAula(Aula $aula)
    {
        $matricula = $aula->modulo->matriculas()->where('user_id', auth()->id())->firstOrFail();
        
        $matricula->aulasAssistidas()->attach($aula->id, ['data_conclusao' => now()]);

        // Verifica se todas as aulas do módulo foram concluídas
        $totalAulas = $aula->modulo->aulas()->count();
        $aulasAssistidas = $matricula->aulasAssistidas()->count();

        if ($totalAulas === $aulasAssistidas) {
            $matricula->update([
                'status' => 'concluido',
                'data_conclusao' => now()
            ]);

            return redirect()->route('escola-lideres.modulo', $aula->modulo)
                ->with('sucesso', 'Parabéns! Você concluiu o módulo com sucesso!');
        }

        return redirect()->route('escola-lideres.modulo', $aula->modulo)
            ->with('sucesso', 'Aula marcada como concluída!');
    }

    public function avaliarAula(Request $request, Aula $aula)
    {
        $validados = $request->validate([
            'avaliacao' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500'
        ]);

        $matricula = $aula->modulo->matriculas()->where('user_id', auth()->id())->firstOrFail();
        
        $matricula->aulasAssistidas()->updateExistingPivot($aula->id, [
            'avaliacao' => $validados['avaliacao'],
            'comentario' => $validados['comentario']
        ]);

        return redirect()->route('escola-lideres.aula', $aula)
            ->with('sucesso', 'Avaliação registrada com sucesso!');
    }

    public function certificado(Modulo $modulo)
    {
        $matricula = $modulo->matriculas()
            ->where('user_id', auth()->id())
            ->where('status', 'concluido')
            ->firstOrFail();

        return view('escola-lideres.certificado', compact('modulo', 'matricula'));
    }

    public function progresso()
    {
        $matriculas = auth()->user()->matriculas()
            ->with(['modulo', 'aulasAssistidas'])
            ->get();

        return view('escola-lideres.progresso', compact('matriculas'));
    }
} 