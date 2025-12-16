<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NovosDesafiosPerfil extends Model
{
    use HasFactory;

    protected $table = 'novos_desafios_perfis';

    protected $fillable = [
        'nome',
        'cargo',
        'pontos',
        'projetos',
        'nivel',
        'avatar_url',
        'ordem',
    ];
}
