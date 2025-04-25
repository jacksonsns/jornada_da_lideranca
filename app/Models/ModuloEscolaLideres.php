<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModuloEscolaLideres extends Model
{
    use HasFactory;

    protected $table = 'modulos_escola_lideres';

    protected $fillable = [
        'escola_id',
        'titulo',
        'descricao',
        'ordem',
        'duracao_minutos',
        'material_url',
        'video_url',
        'questionario'
    ];

    protected $casts = [
        'questionario' => 'array'
    ];

    public function escola()
    {
        return $this->belongsTo(EscolaLideres::class, 'escola_id');
    }

    public function progressoAlunos()
    {
        return $this->hasMany(ProgressoModulo::class, 'modulo_id');
    }
} 