<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Verifica se o usuário de teste já existe
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        $this->call([
            NovosDesafiosPerfilSeeder::class,
            UserSeeder::class,
            JornadaAspiranteSeeder::class,
            DesafioSeeder::class,
            ConquistaSeeder::class,
        ]);
    }
}
