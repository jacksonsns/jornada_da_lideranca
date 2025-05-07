<?php

namespace Database\Seeders;

use App\Models\EscolaLideres;
use App\Models\ModuloEscolaLideres;
use Illuminate\Database\Seeder;

class EscolaLideresSeeder extends Seeder
{
    public function run()
    {
        // Criando uma escola (curso)
        $escola = EscolaLideres::create([
            'titulo' => 'Escola de Líderes - Liderança e Gestão',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Criando um módulo associado à escola
        ModuloEscolaLideres::create([
            'escola_id' => $escola->id,
            'titulo' => 'Trilha de Liderança: Introdução',
            'descricao' => 'Aprenda os primeiros passos para se tornar um líder eficaz. Aprofunde-se nas técnicas de liderança moderna.',
            'ordem' => 1,
            'duracao_minutos' => 180,
            'material_url' => 'https://exemplo.com/material1.pdf',
            'video_url' => 'https://exemplo.com/video1.mp4',
            'questionario' => json_encode([
                'questao1' => 'Qual seu maior desafio de liderança?',
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Você pode adicionar mais módulos, se necessário
    }
}
