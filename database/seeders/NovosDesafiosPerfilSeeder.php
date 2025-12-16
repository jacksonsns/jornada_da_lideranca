<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NovosDesafiosPerfil;

class NovosDesafiosPerfilSeeder extends Seeder
{
    public function run(): void
    {
        $perfis = [
            [
                'nome' => 'Ana Silva',
                'cargo' => 'Diretora de Marketing',
                'pontos' => 950,
                'projetos' => 4,
                'nivel' => 'ouro',
                'avatar_url' => 'https://cdn-icons-png.flaticon.com/512/2922/2922506.png',
                'ordem' => 1,
            ],
            [
                'nome' => 'Carlos Santos',
                'cargo' => 'Diretor de Eventos',
                'pontos' => 720,
                'projetos' => 5,
                'nivel' => 'prata',
                'avatar_url' => 'https://cdn-icons-png.flaticon.com/512/3940/3940416.png',
                'ordem' => 2,
            ],
            [
                'nome' => 'Maria Costa',
                'cargo' => 'Diretora Financeira',
                'pontos' => 1150,
                'projetos' => 3,
                'nivel' => 'diamante',
                'avatar_url' => 'https://cdn-icons-png.flaticon.com/512/3940/3940403.png',
                'ordem' => 3,
            ],
            [
                'nome' => 'João Oliveira',
                'cargo' => 'Diretor de RH',
                'pontos' => 580,
                'projetos' => 6,
                'nivel' => 'bronze',
                'avatar_url' => 'https://cdn-icons-png.flaticon.com/512/3940/3940408.png',
                'ordem' => 4,
            ],
            [
                'nome' => 'Paula Mendes',
                'cargo' => 'Voluntária - Marketing',
                'pontos' => 340,
                'projetos' => 2,
                'nivel' => 'bronze',
                'avatar_url' => 'https://cdn-icons-png.flaticon.com/512/3940/3940413.png',
                'ordem' => 5,
            ],
            [
                'nome' => 'Ricardo Lima',
                'cargo' => 'Voluntário - Eventos',
                'pontos' => 420,
                'projetos' => 3,
                'nivel' => 'prata',
                'avatar_url' => 'https://cdn-icons-png.flaticon.com/512/3940/3940425.png',
                'ordem' => 6,
            ],
        ];

        foreach ($perfis as $perfil) {
            NovosDesafiosPerfil::updateOrCreate(
                ['nome' => $perfil['nome']],
                $perfil
            );
        }
    }
}
