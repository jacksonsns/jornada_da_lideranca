<?php

namespace App\Services;

use App\Models\User;
use App\Models\Desafio;
use App\Models\DesafioUser;
use App\Models\JornadaAspirante;
use App\Models\JornadaAspiranteUser;
use Illuminate\Support\Facades\DB;

class DesafioAutomaticoService
{
    public function verificarDesafios(User $user)
    {
        $this->verificarVisitasSistema($user);
        $this->verificarQuadroSonhos($user);
        $this->verificarPrimeiroDesafio($user);
        $this->verificarEscolaLideres($user);
        $this->verificarProjetoIndividual($user);
        $this->verificarAgenda($user);
        $this->verificarFinancas($user);
        $this->verificarConexoes($user);
        $this->verificarTodosDesafios($user);
    }

    private function concluirDesafio(User $user, string $descricao, int $pontos)
    {
        $desafio = Desafio::where('descricao', $descricao)->first();
        if ($desafio && !$user->desafios()->where('desafio_id', $desafio->id)->where('concluido', true)->exists()) {
            DB::transaction(function () use ($user, $desafio, $pontos) {
                $user->desafios()->updateOrCreate(
                    ['desafio_id' => $desafio->id],
                    [
                        'concluido' => true,
                        'concluido_em' => now()
                    ]
                );
                $user->increment('pontos', $pontos);
            });
        }
    }

    private function verificarVisitasSistema(User $user)
    {
        // Verifica se o usuário visitou todas as seções principais
        $secoes = ['quadro-dos-sonhos', 'desafios', 'escola-lideres', 'capacitacoes', 
                  'projeto-individual', 'agenda', 'area-financeira'];
        
        $visitasCompletas = $user->visitas()
            ->whereIn('secao', $secoes)
            ->distinct('secao')
            ->count() === count($secoes);

        if ($visitasCompletas) {
            $this->concluirDesafio($user, 'Visite todas as seções do sistema', 3);
        }
    }

    private function verificarQuadroSonhos(User $user)
    {
        if ($user->sonhos()->exists()) {
            $this->concluirDesafio($user, 'Adicione seu primeiro sonho no Quadro dos Sonhos', 5);
        }
    }

    private function verificarPrimeiroDesafio(User $user)
    {
        if ($user->desafios()->where('concluido', true)->exists()) {
            $this->concluirDesafio($user, 'Complete seu primeiro desafio', 4);
        }
    }

    private function verificarEscolaLideres(User $user)
    {
        if ($user->aulasAssistidas()->exists()) {
            $this->concluirDesafio($user, 'Assista sua primeira aula na Escola de Líderes', 3);
        }
    }

    private function verificarProjetoIndividual(User $user)
    {
        if ($user->projetos()->exists()) {
            $this->concluirDesafio($user, 'Crie seu primeiro projeto individual', 5);
        }
    }

    private function verificarAgenda(User $user)
    {
        if ($user->eventos()->exists()) {
            $this->concluirDesafio($user, 'Adicione seu primeiro evento na agenda', 2);
        }
    }

    private function verificarFinancas(User $user)
    {
        if ($user->transacoes()->exists()) {
            $this->concluirDesafio($user, 'Registre sua primeira transação financeira', 3);
        }
    }

    private function verificarConexoes(User $user)
    {
        if ($user->conexoes()->count() >= 5) {
            $this->concluirDesafio($user, 'Conecte-se com 5 outros usuários', 4);
        }
    }

    private function verificarTodosDesafios(User $user)
    {
        $totalDesafiosBasicos = Desafio::where('descricao', '!=', 'Complete todos os desafios básicos')->count();
        $desafiosConcluidos = $user->desafios()->where('concluido', true)->count();

        if ($desafiosConcluidos >= $totalDesafiosBasicos) {
            $this->concluirDesafio($user, 'Complete todos os desafios básicos', 10);
        }
    }

    public function adicionarDesafio(User $user)
    {
        $desafios = Desafio::all();
        if ($desafios) {
            foreach ($desafios as $desafio) {
                DesafioUser::create([
                        'user_id' => $user->id,
                        'desafio_id' => $desafio->id,
                        'concluido' => false,
                ]);
            }
        }
    }

    public function adicionarJornada(User $user)
    {
        $desafios = JornadaAspirante::all();
        if ($desafios) {
            foreach ($desafios as $desafio) {
                JornadaAspiranteUser::create([
                        'user_id' => $user->id,
                        'jornada_aspirante_id' => $desafio->id,
                        'concluido' => false,
                        'data_conclusao' => now()
                ]);
            }
        }
    }

    public function completarDesafio(User $user, string $descricao)
    {
        $desafio = Desafio::where('descricao', $descricao)->first();
        DesafioUser::where('user_id', $user->id)
            ->where('desafio_id', $desafio->id)
            ->update(['concluido' => true, 'concluido_em' => now()]);
    }
} 