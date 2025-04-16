<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conquista;

class ConquistaSeeder extends Seeder
{
    public function run()
    {
        $conquistas = [
            [
                'nome' => 'Primeiros Passos',
                'descricao' => 'Conclua sua primeira etapa da jornada',
                'pontos' => 100,
                'criterio' => 'etapas_concluidas',
                'valor_requerido' => 1,
            ],
            [
                'nome' => 'Explorador',
                'descricao' => 'Conclua 5 etapas da jornada',
                'pontos' => 500,
                'criterio' => 'etapas_concluidas',
                'valor_requerido' => 5,
            ],
            [
                'nome' => 'Mestre da Jornada',
                'descricao' => 'Conclua todas as etapas da jornada',
                'pontos' => 1000,
                'criterio' => 'etapas_concluidas',
                'valor_requerido' => 10,
            ],
            [
                'nome' => 'Desafiante',
                'descricao' => 'Conclua seu primeiro desafio',
                'pontos' => 100,
                'criterio' => 'desafios_concluidos',
                'valor_requerido' => 1,
            ],
            [
                'nome' => 'Campeão',
                'descricao' => 'Conclua 5 desafios',
                'pontos' => 500,
                'criterio' => 'desafios_concluidos',
                'valor_requerido' => 5,
            ],
            [
                'nome' => 'Lenda',
                'descricao' => 'Conclua todos os desafios',
                'pontos' => 1000,
                'criterio' => 'desafios_concluidos',
                'valor_requerido' => 10,
            ],
            [
                'nome' => 'Estudante',
                'descricao' => 'Conclua seu primeiro módulo da Escola de Líderes',
                'pontos' => 100,
                'criterio' => 'modulos_concluidos',
                'valor_requerido' => 1,
            ],
            [
                'nome' => 'Líder em Formação',
                'descricao' => 'Conclua 3 módulos da Escola de Líderes',
                'pontos' => 500,
                'criterio' => 'modulos_concluidos',
                'valor_requerido' => 3,
            ],
            [
                'nome' => 'Mestre Líder',
                'descricao' => 'Conclua todos os módulos da Escola de Líderes',
                'pontos' => 1000,
                'criterio' => 'modulos_concluidos',
                'valor_requerido' => 5,
            ],
        ];

        foreach ($conquistas as $conquista) {
            Conquista::create($conquista);
        }
    }
} 