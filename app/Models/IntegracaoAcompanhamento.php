<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntegracaoAcompanhamento extends Model
{
    use HasFactory;

    protected $table = 'integracao_acompanhamento';

    protected $fillable = [
        'user_id',
        'mentor_id',
        'feedback',
        'status',
        'data_agendamento',
        'data_realizacao'
    ];

    protected $casts = [
        'data_agendamento' => 'date',
        'data_realizacao' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }
} 