<?php

namespace Database\Seeders;

use App\Models\ModuloEscolaLideres;
use App\Models\Aula;
use App\Models\User;
use Illuminate\Database\Seeder;

class ModuloEscolaLideresSeeder extends Seeder
{
    public function run()
    {
        // Criação de módulos de exemplo
        $modulo1 = ModuloEscolaLideres::create([
            'escola_id' => 1, // Você pode substituir por um ID válido de Escola
            'titulo' => 'Trilha de Liderança: Introdução',
            'descricao' => 'Aprenda os primeiros passos para se tornar um líder eficaz. Aprofunde-se nas técnicas de liderança moderna.',
            'ordem' => 1,
            'duracao_minutos' => 180,
            'material_url' => 'https://exemplo.com/material1.pdf',
            'video_url' => 'https://exemplo.com/video1.mp4',
            'questionario' => json_encode(['questao1' => 'Qual seu maior desafio de liderança?']),
        ]);

        $modulo2 = ModuloEscolaLideres::create([
            'escola_id' => 1, // Substitua pelo ID correto da escola
            'titulo' => 'Gestão de Equipes',
            'descricao' => 'Como gerenciar equipes de forma eficiente e alcançar resultados consistentes.',
            'ordem' => 2,
            'duracao_minutos' => 150,
            'material_url' => 'https://exemplo.com/material2.pdf',
            'video_url' => 'https://exemplo.com/video2.mp4',
            'questionario' => json_encode(['questao1' => 'Quais são suas estratégias para gerenciar equipes?']),
        ]);

        // Criando aulas para o módulo 1
        Aula::create([
            'modulo_id' => $modulo1->id,
            'titulo' => 'Aula 1: Fundamentos da Liderança',
            'descricao' => 'Entenda os conceitos básicos de liderança e como aplicá-los no dia a dia.',
            'ordem' => 1,
        ]);

        Aula::create([
            'modulo_id' => $modulo1->id,
            'titulo' => 'Aula 2: Desenvolvendo Habilidades de Comunicação',
            'descricao' => 'Aprenda a comunicar-se de forma eficaz com sua equipe.',
            'ordem' => 2,
        ]);

        // Criando aulas para o módulo 2
        Aula::create([
            'modulo_id' => $modulo2->id,
            'titulo' => 'Aula 1: Como Delegar Tarefas',
            'descricao' => 'Técnicas de delegação eficaz para otimizar a produtividade.',
            'ordem' => 1,
        ]);

        Aula::create([
            'modulo_id' => $modulo2->id,
            'titulo' => 'Aula 2: Feedback e Avaliação de Desempenho',
            'descricao' => 'Aprenda a fornecer feedbacks construtivos e avaliar o desempenho de sua equipe.',
            'ordem' => 2,
        ]);

        // Criando matrículas de teste para um usuário fictício
        $user = User::first(); // Supondo que você tenha ao menos um usuário cadastrado

        if ($user) {
            $modulo1->matriculas()->create([
                'user_id' => $user->id,
                'data_inicio' => now(),
                'status' => 'em_andamento',
            ]);

            $modulo2->matriculas()->create([
                'user_id' => $user->id,
                'data_inicio' => now(),
                'status' => 'em_andamento',
            ]);
        }
    }
}
