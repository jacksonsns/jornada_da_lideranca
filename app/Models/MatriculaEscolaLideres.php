<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatriculaEscolaLideres extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'modulo_escola_lideres_id',
        'data_inicio',
        'data_conclusao',
        'status'
    ];

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_conclusao' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function modulo()
    {
        return $this->belongsTo(ModuloEscolaLideres::class, 'modulo_escola_lideres_id');
    }

    public function aulasAssistidas()
    {
        return $this->belongsToMany(Aula::class, 'aula_matricula')
            ->withTimestamps();
    }
} 