<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class JornadaAspiranteSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $dados = [
            // A. Ações de Alto Impacto – Valendo 100 Pontos
            ['Ações de Alto Impacto', 'Jornada da Liderança (conclusão completa da trilha)', 100],
            ['Ações de Alto Impacto', 'Criação da logo do aplicativo de gamificação (entrega e aprovação)', 100],

            // B. Participação em Reuniões, Eventos e Capacitações
            ['Participação em Reuniões, Eventos e Capacitações', 'Presença em Plenárias', 5],
            ['Participação em Reuniões, Eventos e Capacitações', 'Presença em Eventos Festivos', 4],
            ['Participação em Reuniões, Eventos e Capacitações', 'Presença em Capacitações', 6],
            ['Participação em Reuniões, Eventos e Capacitações', 'Presença na Escola de Líderes', 7],
            ['Participação em Reuniões, Eventos e Capacitações', 'Presença em Eventos da JCI', 5],
            ['Participação em Reuniões, Eventos e Capacitações', 'Presença no JCI Day', 6],
            ['Participação em Reuniões, Eventos e Capacitações', 'Presença em Reuniões Preparatórias', 4],

            // C. Participação em Projetos, Ações e Atividades Estratégicas
            ['Participação em Projetos, Ações e Atividades Estratégicas', 'Participação em Comissões', 6],
            ['Participação em Projetos, Ações e Atividades Estratégicas', 'Participação em Projetos (Dia D)', 8],
            ['Participação em Projetos, Ações e Atividades Estratégicas', 'Participação em Concursos', 5],
            ['Participação em Projetos, Ações e Atividades Estratégicas', 'Participação em Cursos', 6],
            ['Participação em Projetos, Ações e Atividades Estratégicas', 'Participação na Comunidade (desenvolvimento da liderança)', 7],
            ['Participação em Projetos, Ações e Atividades Estratégicas', 'Participação em Realinhamento Estratégico', 8],
            ['Participação em Projetos, Ações e Atividades Estratégicas', 'Participação em Alinhamento Estratégico', 8],
            ['Participação em Projetos, Ações e Atividades Estratégicas', 'Participação em Mutirões', 6],
            ['Participação em Projetos, Ações e Atividades Estratégicas', 'Participação na Gincana', 5],

            // D. Entregas e Contribuições Técnicas
            ['Entregas e Contribuições Técnicas', 'Indicação de Aspirantes aprovados', 10],
            ['Entregas e Contribuições Técnicas', 'Indicação de Locação da Casa de Oportunidades (alugada com sucesso)', 10],
            ['Entregas e Contribuições Técnicas', 'Atualização do Drive (organização e constância)', 4],
            ['Entregas e Contribuições Técnicas', 'Orçamento da Pasta entregue no prazo', 6],
            ['Entregas e Contribuições Técnicas', 'Acompanhamento do TEVEP (datas e checklists em dia)', 6],
            ['Entregas e Contribuições Técnicas', 'Casa de Oportunidades (uso documentado e estratégico)', 5],

            // E. Bônus e Penalidades
            ['Bônus e Penalidades', 'Cumpriu todas as ações do mês', 10],
            ['Bônus e Penalidades', 'Faltou sem justificativa a evento obrigatório', -5],
            ['Bônus e Penalidades', 'Atraso em entregas importantes (ex: orçamento, TEVEP)', -3],
        ];

        foreach ($dados as $ordem => [$titulo, $descricao, $pontos]) {
            DB::table('desafios')->insert([
                'titulo' => $titulo,
                'descricao' => $descricao,
                'pontos' => $pontos,
                'tipo' => '',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
