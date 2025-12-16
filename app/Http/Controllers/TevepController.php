<?php

namespace App\Http\Controllers;

use App\Models\Tevep;
use App\Models\TevepAcao;
use App\Models\User;
use App\Models\DesafioUser;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class TevepController extends Controller
{
    public function edit(User $user, DesafioUser $desafioUser)
    {
        $tevep = Tevep::firstOrNew([
            'user_id' => $user->id,
            'desafio_user_id' => $desafioUser->id,
        ])->loadMissing('acoes');

        return view('desafios.tevep-edit', [
            'usuario' => $user,
            'desafioUser' => $desafioUser,
            'tevep' => $tevep,
        ]);
    }

    public function createUser(User $user, DesafioUser $desafioUser)
    {
        $tevep = new Tevep();

        return view('desafios.tevep-create-user', [
            'usuario' => $user,
            'desafioUser' => $desafioUser,
            'tevep' => $tevep,
        ]);
    }

    public function editUser(User $user, DesafioUser $desafioUser)
    {
        $tevep = Tevep::firstOrNew([
            'user_id' => $user->id,
            'desafio_user_id' => $desafioUser->id,
        ])->loadMissing('acoes');

        return view('desafios.tevep-edit-user', [
            'usuario' => $user,
            'desafioUser' => $desafioUser,
            'tevep' => $tevep,
        ]);
    }

    public function update(Request $request, User $user, DesafioUser $desafioUser)
    {
        // Normaliza campo de custo em formato brasileiro (ex: "R$ 500.000,00" -> 500000.00)
        if ($request->filled('custo')) {
            $rawCusto = $request->input('custo');
            $sanitized = preg_replace('/[^0-9,.-]/', '', $rawCusto ?? '');
            $sanitized = str_replace('.', '', $sanitized);
            $sanitized = str_replace(',', '.', $sanitized);
            $request->merge(['custo' => $sanitized]);
        }

        $data = $request->validate([
            'area_estrategica' => 'nullable|string|max:255',
            'indicador' => 'nullable|string|max:255',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date',
            'nome_evento' => 'nullable|string|max:255',
            'espaco' => 'nullable|string|max:255',
            'pessoas_envolvidas' => 'nullable|string|max:255',
            'utilidade_objetivo' => 'nullable|string',
            'inerencias_planejamento' => 'nullable|string',
            'expectativas' => 'nullable|string',
            'custo' => 'nullable|numeric',
            'entrega' => 'nullable|string|max:255',
            'atendimento' => 'nullable|string|max:255',
            'qualidade' => 'nullable|string|max:255',
            'inovacao' => 'nullable|string',
            'logistica' => 'nullable|string',
        ], [
            'area_estrategica.string' => 'A área estratégica deve ser um texto válido.',
            'area_estrategica.max' => 'A área estratégica não pode ter mais que 255 caracteres.',

            'indicador.string' => 'O indicador deve ser um texto válido.',
            'indicador.max' => 'O indicador não pode ter mais que 255 caracteres.',

            'data_inicio.date' => 'A data de início deve ser uma data válida.',
            'data_fim.date' => 'A data de fim deve ser uma data válida.',

            'nome_evento.string' => 'O nome do evento deve ser um texto válido.',
            'nome_evento.max' => 'O nome do evento não pode ter mais que 255 caracteres.',

            'espaco.string' => 'O campo espaço deve ser um texto válido.',
            'espaco.max' => 'O campo espaço não pode ter mais que 255 caracteres.',

            'pessoas_envolvidas.string' => 'O campo pessoas envolvidas deve ser um texto válido.',
            'pessoas_envolvidas.max' => 'O campo pessoas envolvidas não pode ter mais que 255 caracteres.',

            'utilidade_objetivo.string' => 'O campo utilidade/objetivo deve ser um texto válido.',
            'inerencias_planejamento.string' => 'O campo inerências/planejamento deve ser um texto válido.',
            'expectativas.string' => 'O campo expectativas deve ser um texto válido.',

            'custo.numeric' => 'O campo custo deve ser um número (use apenas números, pontos e vírgulas).',

            'entrega.string' => 'O campo entrega deve ser um texto válido.',
            'entrega.max' => 'O campo entrega não pode ter mais que 255 caracteres.',

            'atendimento.string' => 'O campo atendimento deve ser um texto válido.',
            'atendimento.max' => 'O campo atendimento não pode ter mais que 255 caracteres.',

            'qualidade.string' => 'O campo qualidade deve ser um texto válido.',
            'qualidade.max' => 'O campo qualidade não pode ter mais que 255 caracteres.',

            'inovacao.string' => 'O campo inovação deve ser um texto válido.',
            'logistica.string' => 'O campo logística deve ser um texto válido.',
        ]);

        $data['user_id'] = $user->id;
        $data['desafio_user_id'] = $desafioUser->id;

        try {
            $tevep = Tevep::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'desafio_user_id' => $desafioUser->id,
                ],
                $data
            );

            // Atualiza planejamento de ações
            $tevep->acoes()->delete();

            $acoes = $request->input('acoes', []);
            foreach ($acoes as $acao) {
                // ignora linhas completamente vazias
                if (empty($acao['prazo']) && empty($acao['evento_acao']) && empty($acao['espaco']) && empty($acao['pessoas']) && empty($acao['piloto']) && empty($acao['recursos']) && empty($acao['status'])) {
                    continue;
                }

                $tevep->acoes()->create([
                    'prazo'       => $acao['prazo'] ?? null,
                    'evento_acao' => $acao['evento_acao'] ?? null,
                    'espaco'      => $acao['espaco'] ?? null,
                    'pessoas'     => $acao['pessoas'] ?? null,
                    'piloto'      => $acao['piloto'] ?? null,
                    'recursos'    => $acao['recursos'] ?? null,
                    'status'      => $acao['status'] ?? null,
                ]);
            }
        } catch (QueryException $e) {
            return back()
                ->withInput()
                ->with('erro', 'Erro ao salvar o TEVEP. Verifique os campos preenchidos e tente novamente. ');
        }

        return redirect()->route('tevep.user', $user->id)
            ->with('sucesso', 'TEVEP salvo com sucesso.');
    }
}
