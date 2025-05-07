<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JornadaAspiranteEtapa extends Model
{
    use HasFactory;

    protected $fillable = [
        'jornada_aspirante_id',
        'titulo',
        'descricao',
        'pontos',
        'ordem',
    ];

    public function jornada()
    {
        return $this->belongsTo(JornadaAspirante::class, 'jornada_aspirante_id');
    }
} 