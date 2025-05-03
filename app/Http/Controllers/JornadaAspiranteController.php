<?php

namespace App\Http\Controllers;

use App\Models\JornadaAspirante;
use App\Models\Conquista;
use App\Models\JornadaAspiranteUser;
use App\Models\DesafioUser;
use Illuminate\Http\Request;

class JornadaAspiranteController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $desafios = JornadaAspiranteUser::select('jornada_aspirante_user.*', 'jornada_aspirante.*') 
            ->leftJoin('jornada_aspirante', 'jornada_aspirante_user.jornada_aspirante_id', '=', 'jornada_aspirante.id')
            ->where('jornada_aspirante_user.user_id', $user->id)
            ->get();

        $totalDesafios = JornadaAspiranteUser::where('user_id', $user->id)->count();

        $desafiosConcluidos = JornadaAspiranteUser::where('user_id', $user->id)
            ->where('concluido', 1)
            ->count();
    
        $totalPontos = JornadaAspiranteUser::where('user_id', $user->id)
            ->where('concluido', 1)
            ->join('jornada_aspirante', 'jornada_aspirante.id', '=', 'jornada_aspirante_user.jornada_aspirante_id')
            ->sum('jornada_aspirante.pontos');

        $totalPontosDesafios = DesafioUser::where('user_id', $user->id)
            ->where('concluido', 1)
            ->join('desafios', 'desafios.id', '=', 'desafio_user.desafio_id')
            ->sum('desafios.pontos');
       
        $totalPontos = $totalPontos + $totalPontosDesafios;

        $progresso = $totalDesafios > 0 ? round(($desafiosConcluidos / $totalDesafios) * 100) : 0;

        $conquistas = $user->conquistas()
            ->withPivot('conquistado_em')
            ->get();
    
        return view('jornada-aspirante.index', compact('desafios', 'desafiosConcluidos', 'totalDesafios', 'progresso', 'conquistas', 'totalPontos'));
    }    

    public function iniciarJornada()
    {
        $user = auth()->user();
        
        // Verifica se o usuário já tem uma jornada
        if ($user->jornadaAspirante()->exists()) {
            return redirect()->route('jornada-aspirante.index')
                ->with('error', 'Você já iniciou sua jornada!');
        }

        // Cria as etapas padrão da jornada
        $etapas = [
            [
                'titulo' => 'Conhecendo a Empresa',
                'descricao' => 'Aprenda sobre a história, valores e cultura da empresa',
                'ordem' => 1,
                'obrigatorio' => true
            ],
            [
                'titulo' => 'Treinamento Inicial',
                'descricao' => 'Complete o treinamento básico para novos aspirantes',
                'ordem' => 2,
                'obrigatorio' => true
            ],
            [
                'titulo' => 'Primeiro Projeto',
                'descricao' => 'Desenvolva seu primeiro projeto prático',
                'ordem' => 3,
                'obrigatorio' => true
            ]
        ];

        // Cria as etapas e vincula ao usuário
        foreach ($etapas as $etapa) {
            $jornada = JornadaAspirante::create($etapa);
            $user->jornadaAspirante()->attach($jornada->id, [
                'concluido' => false,
                'data_conclusao' => null
            ]);
        }

        return redirect()->route('jornada-aspirante.index')
            ->with('success', 'Jornada iniciada com sucesso!');
    }


    public function atualizarProgresso(JornadaAspirante $etapa, Request $request)
    {
        $user = auth()->user();
        
        // Verifica se a etapa pertence ao usuário
        if (!$user->jornadaAspirante()->where('jornada_aspirante.id', $etapa->id)->exists()) {
            return redirect()->route('jornada-aspirante.index')
                ->with('error', 'Etapa não encontrada!');
        }

        $request->validate([
            'progresso' => 'required|integer|min:0|max:100'
        ]);

        // Atualiza o progresso da etapa
        $user->jornadaAspirante()->updateExistingPivot($etapa->id, [
            'progresso' => $request->progresso
        ]);

        return redirect()->route('jornada-aspirante.show', $etapa)
            ->with('success', 'Progresso atualizado com sucesso!');
    }

    public function relatorio()
    {
        $user = auth()->user();
        
        $etapas = $user->jornadaAspirante()
            ->orderBy('ordem')
            ->get();

        $totalEtapas = $etapas->count();
        $etapasConcluidas = $etapas->where('pivot.concluido', true)->count();
        $progressoGeral = $totalEtapas > 0 ? ($etapasConcluidas / $totalEtapas) * 100 : 0;

        return view('jornada-aspirante.relatorio', compact(
            'etapas',
            'totalEtapas',
            'etapasConcluidas',
            'progressoGeral'
        ));
    }

    public function verificarConquistas()
    {
        $user = auth()->user();
        $conquistas = Conquista::all();
        $novasConquistas = [];

        foreach ($conquistas as $conquista) {
            // Verifica se o usuário já possui a conquista
            if ($user->conquistas()->where('conquista_id', $conquista->id)->exists()) {
                continue;
            }

            // Verifica os critérios da conquista
            $criterios = json_decode($conquista->criterios, true);
            $atingiuCriterios = true;

            foreach ($criterios as $criterio => $valor) {
                switch ($criterio) {
                    case 'desafios_concluidos':
                        $desafiosConcluidos = $user->desafios()
                            ->wherePivot('concluido', true)
                            ->count();
                        if ($desafiosConcluidos < $valor) {
                            $atingiuCriterios = false;
                        }
                        break;
                    case 'etapas_concluidas':
                        $etapasConcluidas = $user->jornadaAspirante()
                            ->wherePivot('concluido', true)
                            ->count();
                        if ($etapasConcluidas < $valor) {
                            $atingiuCriterios = false;
                        }
                        break;
                    // Adicione outros critérios conforme necessário
                }

                if (!$atingiuCriterios) {
                    break;
                }
            }

            if ($atingiuCriterios) {
                // Atribui a conquista ao usuário
                $user->conquistas()->attach($conquista->id, [
                    'data_conquista' => now()
                ]);
                $novasConquistas[] = $conquista;
            }
        }

        if (count($novasConquistas) > 0) {
            return redirect()->route('jornada-aspirante.index')
                ->with('success', 'Parabéns! Você conquistou novas medalhas!');
        }

        return redirect()->route('jornada-aspirante.index');
    }

    public function minhasConquistas()
    {
        $user = auth()->user();
        $conquistas = $user->conquistas()
            ->withPivot('data_conquista')
            ->orderBy('pivot.data_conquista', 'desc')
            ->get();

        return view('jornada-aspirante.conquistas', compact('conquistas'));
    }

    public function concluir(JornadaAspirante $desafio)
    {
        $user = auth()->user();
        
        $jornadaAspiranteUser = JornadaAspiranteUser::where('user_id', $user->id)
            ->where('jornada_aspirante_id', $desafio->id)
            ->first();
    
        if (!$jornadaAspiranteUser) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Desafio não encontrado para este usuário.'
                ], 404);
            }
    
            return redirect()->back()
                ->with('erro', 'Desafio não encontrado.');
        }
    
        $jornadaAspiranteUser->update([
            'concluido' => true,
            'data_conclusao' => now()
        ]);
    
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Desafio concluído com sucesso!'
            ]);
        }
    
        return redirect()->back()
            ->with('sucesso', 'Desafio concluído com sucesso!');
    }
    
} 