<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;

    protected $fillable = [
        'modulo_escola_lideres_id',
        'titulo',
        'descricao',
        'conteudo',
        'video_url',
        'material_url',
        'duracao_minutos',
        'ordem'
    ];

    protected $casts = [
        'duracao_minutos' => 'integer',
        'ordem' => 'integer'
    ];

    public function modulo()
    {
        return $this->belongsTo(ModuloEscolaLideres::class, 'modulo_escola_lideres_id');
    }

    public function matriculas()
    {
        return $this->belongsToMany(MatriculaEscolaLideres::class, 'aula_matricula')
            ->withTimestamps();
    }

    public function avaliacoes()
    {
        return $this->hasMany(AvaliacaoAula::class);
    }
} 