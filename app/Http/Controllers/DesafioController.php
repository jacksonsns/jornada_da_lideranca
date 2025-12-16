<?php

namespace App\Http\Controllers;

use App\Models\Desafio;
use App\Models\DesafioUser;
use App\Models\Tevep;
use Illuminate\Http\Request;
use App\Services\DesafioAutomaticoService;
use App\Models\JornadaAspiranteUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

    public function novosDesafios()
    {
        // Usuários e métricas globais para a visão administrativa baseadas apenas em TEVEP
        $usuarios = User::orderBy('name')->get();

        // Métricas de TEVEP por usuário: quantidade de TEVEPs e soma de custo
        $tevepMetricasPorUsuario = Tevep::selectRaw('user_id, COUNT(*) as total_teveps, COALESCE(SUM(custo), 0) as total_custo')
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        $usuariosComMetricas = $usuarios->map(function (User $user) use ($tevepMetricasPorUsuario) {
            $metricas = $tevepMetricasPorUsuario->get($user->id);

            return (object) [
                'id' => $user->id,
                'nome' => $user->name,
                'cargo' => $user->cargo ?? 'Membro',
                'pontos' => $metricas->total_custo ?? 0,  // aqui "pontos" = soma de custo dos TEVEPs
                'projetos' => $metricas->total_teveps ?? 0,
            ];
        });

        $totalPontos = $usuariosComMetricas->sum('pontos');

        // Taxa de entrega: percentual de usuários que possuem pelo menos um TEVEP
        $totalUsuarios = max(User::count(), 1);
        $usuariosComTevep = $tevepMetricasPorUsuario->count();
        $taxaEntrega = round(($usuariosComTevep / $totalUsuarios) * 100, 1);

        // Engajamento: mesma lógica da taxa de entrega, mantendo semântica da tela
        $engajamento = $taxaEntrega;

        // Inovação: percentual de usuários com mais de um TEVEP
        $usuariosComMaisDeUmTevep = $tevepMetricasPorUsuario->filter(function ($m) {
            return ($m->total_teveps ?? 0) > 1;
        })->count();

        $inovacao = round(($usuariosComMaisDeUmTevep / $totalUsuarios) * 100, 1);

        // Top 4 para o ranking mensal
        $ranking = $usuariosComMetricas
            ->sortByDesc('pontos')
            ->take(4)
            ->values();

        // Diretorias dinamicamente a partir do cargo dos usuários
        $diretoriasConfig = [
            [
                'nome' => 'Marketing',
                'keyword' => 'marketing',
            ],
            [
                'nome' => 'Eventos',
                'keyword' => 'evento',
            ],
            [
                'nome' => 'Financeiro',
                'keyword' => 'finance',
            ],
            [
                'nome' => 'RH',
                'keyword' => 'rh',
            ],
        ];

        $diretorias = [];

        foreach ($diretoriasConfig as $config) {
            $usuariosDiretoria = $usuariosComMetricas->filter(function ($u) use ($config) {
                $cargoLower = mb_strtolower($u->cargo ?? '');
                return str_contains($cargoLower, $config['keyword']);
            });

            $ids = $usuariosDiretoria->pluck('id');

            if ($ids->isEmpty()) {
                continue;
            }

            // Projetos e pontos da diretoria baseados em TEVEP
            $totalProjetos = 0;
            $pontosDiretoria = 0;

            foreach ($ids as $idUsuario) {
                $metricas = $tevepMetricasPorUsuario->get($idUsuario);
                if ($metricas) {
                    $totalProjetos += $metricas->total_teveps;
                    $pontosDiretoria += $metricas->total_custo;
                }
            }

            // Sem status de conclusão em TEVEP, consideramos 100% se há projetos, 0 caso contrário
            $progressoDiretoria = $totalProjetos > 0 ? 100 : 0;

            if ($progressoDiretoria >= 90) {
                $status = 'Excelente';
                $statusClasse = 'success';
            } elseif ($progressoDiretoria < 60) {
                $status = 'Atenção';
                $statusClasse = 'warning';
            } else {
                $status = 'Em dia';
                $statusClasse = 'success';
            }

            $diretorias[] = (object) [
                'nome' => $config['nome'],
                'responsavel' => $usuariosDiretoria->first()->nome,
                'pontos' => $pontosDiretoria,
                'projetosTotal' => $totalProjetos,
                'projetosConcluidos' => $totalProjetos, // sem status separado de conclusão em TEVEP
                'progresso' => $progressoDiretoria,
                'status' => $status,
                'statusClasse' => $statusClasse,
            ];
        }

        // Conquistas recentes reais (últimas 3 do sistema)
        $conquistasRecentes = DB::table('conquista_user')
            ->join('conquistas', 'conquistas.id', '=', 'conquista_user.conquista_id')
            ->join('users', 'users.id', '=', 'conquista_user.user_id')
            ->orderByDesc('conquista_user.conquistado_em')
            ->limit(3)
            ->get([
                'conquistas.nome as titulo',
                'users.name as usuario_nome',
                'conquista_user.conquistado_em as conquistado_em',
            ]);

        return view('desafios.novos-desafios', [
            'totalPontos' => $totalPontos,
            'ranking' => $ranking,
            'taxaEntrega' => $taxaEntrega,
            'engajamento' => $engajamento,
            'inovacao' => $inovacao,
            'diretorias' => $diretorias,
            'conquistasRecentes' => $conquistasRecentes,
        ]);
    }

    public function selecionarPerfilNovosDesafios()
    {
        // Busca usuários paginados (10 por página)
        $usuariosPaginados = User::orderBy('name')->paginate(10);
        $usuarios = $usuariosPaginados->getCollection();

        // Métricas de TEVEP por usuário: total de TEVEPs e soma de custo
        $tevepMetricas = Tevep::selectRaw('user_id, COUNT(*) as total_teveps, COALESCE(SUM(custo), 0) as total_custo')
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        // Avatares padrão de animais (desenhos) para quem não tem avatar próprio
        $animalAvatars = [
            'https://cdn-icons-png.flaticon.com/512/1998/1998610.png', // cachorro
            'https://cdn-icons-png.flaticon.com/512/1864/1864514.png', // gato
            'https://cdn-icons-png.flaticon.com/512/1998/1998671.png', // leão
            'https://cdn-icons-png.flaticon.com/512/1998/1998695.png', // urso
            'https://cdn-icons-png.flaticon.com/512/616/616408.png',   // coruja
            'https://cdn-icons-png.flaticon.com/512/616/616408.png',   // coruja (repetido p/ fallback)
        ];

        // Monta um array de dados agregados por usuário, usando apenas TEVEP
        $usuariosComMetricas = $usuarios->map(function (User $user) use ($tevepMetricas, $animalAvatars) {
            $metricas = $tevepMetricas->get($user->id);
            $projetos = $metricas->total_teveps ?? 0;
            $pontos = $metricas->total_custo ?? 0; // aqui "pontos" representa o custo total dos TEVEPs

            if ($user->avatar) {
                $avatarUrl = asset('storage/avatars/' . $user->avatar);
            } else {
                $index = $user->id % count($animalAvatars);
                $avatarUrl = $animalAvatars[$index];
            }

            // Resume o cargo para não ficar muito grande no card
            $cargoCompleto = $user->cargo ?? 'Membro';
            $cargo = mb_strlen($cargoCompleto) > 30
                ? mb_substr($cargoCompleto, 0, 27) . '...'
                : $cargoCompleto;

            return (object) [
                'id' => $user->id,
                'nome' => $user->name,
                'cargo' => $cargo,
                'pontos' => $pontos,
                'projetos' => $projetos,
                'avatar_url' => $avatarUrl,
            ];
        });

        // Substitui a coleção interna do paginador pelos dados com métricas
        $usuariosPaginados->setCollection($usuariosComMetricas);

        return view('desafios.novos-desafios-perfis', [
            'usuarios' => $usuariosPaginados,
        ]);
    }

    public function visaoUsuario(User $user)
    {
        // Carrega diretamente os TEVEPs do usuário com seus desafios relacionados
        $teveps = Tevep::where('user_id', $user->id)
            ->with(['desafioUser.desafio'])
            ->get();

        // Métricas derivadas apenas dos TEVEPs
        $projetosAtivos = $teveps->count();
        $projetosConcluidos = 0; // não há campo de concluído no TEVEP; ajuste se adicionar essa informação
        $tarefasPendentes = $projetosAtivos;
        $pontosTotais = 0; // TEVEP não possui pontuação própria; mantenho 0 por enquanto

        return view('desafios.usuario', [
            'usuario' => $user,
            'teveps' => $teveps,
            'pontosTotais' => $pontosTotais,
            'projetosAtivos' => $projetosAtivos,
            'projetosConcluidos' => $projetosConcluidos,
            'tarefasPendentes' => $tarefasPendentes,
        ]);
    }

        public function visaoUsuarioUser(User $user)
    {
        // Carrega diretamente os TEVEPs do usuário com seus desafios relacionados
        $teveps = \App\Models\Tevep::where('user_id', $user->id)
            ->with(['desafioUser.desafio', 'acoes'])
            ->get();

        // Descobre um projeto (DesafioUser) do usuário que ainda não possui TEVEP
        $desafioParaNovoTevep = DesafioUser::where('user_id', $user->id)
            ->whereNotIn('id', function ($query) {
                $query->select('desafio_user_id')->from('teveps');
            })
            ->orderBy('id')
            ->first();

        // Agrupa todas as ações dos TEVEPs para a aba de tarefas
        $todasAcoes = $teveps->flatMap(function ($tevep) {
            return $tevep->acoes->map(function ($acao) use ($tevep) {
                $acao->tevep = $tevep; // referencia para uso na view
                return $acao;
            });
        })->sortBy('prazo')->values();

        // Métricas derivadas apenas dos TEVEPs
        $projetosAtivos = $teveps->count();
        $projetosConcluidos = 0; // não há campo de concluído no TEVEP; ajuste se adicionar essa informação
        $tarefasPendentes = $projetosAtivos; // aqui tratado como "projetos em andamento"; ajuste se houver status
        $pontosTotais = 0; // TEVEP não possui pontuação própria; mantenho 0 por enquanto

        // Conquistas reais do usuário, usando as tabelas já existentes
        $conquistas = DB::table('conquista_user')
            ->join('conquistas', 'conquistas.id', '=', 'conquista_user.conquista_id')
            ->where('conquista_user.user_id', $user->id)
            ->orderByDesc('conquista_user.conquistado_em')
            ->get([
                'conquistas.nome as titulo',
                'conquistas.descricao as descricao',
                'conquista_user.conquistado_em as conquistado_em',
            ]);

        return view('desafios.tevep', [
            'usuario' => $user,
            'teveps' => $teveps,
            'desafioParaNovoTevep' => $desafioParaNovoTevep,
            'pontosTotais' => $pontosTotais,
            'projetosAtivos' => $projetosAtivos,
            'projetosConcluidos' => $projetosConcluidos,
            'tarefasPendentes' => $tarefasPendentes,
            'acoes' => $todasAcoes,
            'conquistas' => $conquistas,
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