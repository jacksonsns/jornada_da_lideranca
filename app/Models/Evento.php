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
        'tipo',
        'user_id'
    ];

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function participantes()
    {
        return $this->belongsToMany(User::class, 'evento_user')
            ->withPivot('confirmado')
            ->withTimestamps();
    }
} 