<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Desafio;
use App\Models\User;

class DesafioSeeder extends Seeder
{
    public function run()
    {
        $desafios = [
            [
                'titulo' => 'Primeiros Passos',
                'descricao' => 'Complete seu perfil no sistema',
                'pontos' => 2,
                'tipo' => 'perfil'
            ],
            [
                'titulo' => 'Explorador',
                'descricao' => 'Visite todas as seções do sistema',
                'pontos' => 3,
                'tipo' => 'exploracao'
            ],
            [
                'titulo' => 'Sonhador',
                'descricao' => 'Adicione seu primeiro sonho no Quadro dos Sonhos',
                'pontos' => 5,
                'tipo' => 'sonhos'
            ],
            [
                'titulo' => 'Desafiador',
                'descricao' => 'Complete seu primeiro desafio',
                'pontos' => 4,
                'tipo' => 'desafios'
            ],
            [
                'titulo' => 'Estudante',
                'descricao' => 'Assista sua primeira aula na Escola de Líderes',
                'pontos' => 3,
                'tipo' => 'escola'
            ],
            [
                'titulo' => 'Projetista',
                'descricao' => 'Crie seu primeiro projeto individual',
                'pontos' => 5,
                'tipo' => 'projetos'
            ],
            [
                'titulo' => 'Organizado',
                'descricao' => 'Adicione seu primeiro evento na agenda',
                'pontos' => 2,
                'tipo' => 'agenda'
            ],
            [
                'titulo' => 'Financeiro',
                'descricao' => 'Registre sua primeira transação financeira',
                'pontos' => 3,
                'tipo' => 'financeiro'
            ],
            [
                'titulo' => 'Social',
                'descricao' => 'Conecte-se com 5 outros usuários',
                'pontos' => 4,
                'tipo' => 'social'
            ],
            [
                'titulo' => 'Mestre',
                'descricao' => 'Complete todos os desafios básicos',
                'pontos' => 10,
                'tipo' => 'geral'
            ]
        ];

        foreach ($desafios as $desafio) {
            Desafio::create($desafio);
        }

        // Atribui os desafios a todos os usuários existentes
        $users = User::all();
        foreach ($users as $user) {
            $user->desafios()->attach(Desafio::all()->pluck('id'));
        }
    }
} 