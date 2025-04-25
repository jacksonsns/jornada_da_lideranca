<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descricao',
        'data_inicio',
        'data_fim',
        'local',
        'google_calendar_id',
        'criador_id'
    ];

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime'
    ];

    public function criador()
    {
        return $this->belongsTo(User::class, 'criador_id');
    }

    public function participantes()
    {
        return $this->belongsToMany(User::class, 'evento_participantes')
            ->withPivot('confirmado', 'data_confirmacao')
            ->withTimestamps();
    }
} 