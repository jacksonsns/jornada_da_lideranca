<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titulo',
        'descricao',
        'data_inicio',
        'data_fim',
        'local',
        'link_meet',
        'publico'
    ];

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime',
        'publico' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 