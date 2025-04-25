<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscolaLideres extends Model
{
    use HasFactory;

    protected $table = 'escola_lideres';

    protected $fillable = [
        'titulo',
        'descricao',
        'nivel',
        'carga_horaria',
        'material_url',
        'video_url',
        'certificado_template',
        'pre_requisitos'
    ];

    protected $casts = [
        'pre_requisitos' => 'array'
    ];

    public function alunos()
    {
        return $this->belongsToMany(User::class, 'escola_lideres_alunos')
            ->withPivot('progresso', 'concluido', 'data_conclusao', 'nota')
            ->withTimestamps();
    }

    public function modulos()
    {
        return $this->hasMany(ModuloEscolaLideres::class, 'escola_id');
    }

    public function certificados()
    {
        return $this->hasMany(Certificado::class, 'curso_id');
    }
} 