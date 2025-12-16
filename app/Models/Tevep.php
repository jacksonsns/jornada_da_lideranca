<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tevep extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'desafio_user_id',
        'area_estrategica',
        'indicador',
        'data_inicio',
        'data_fim',
        'nome_evento',
        'espaco',
        'pessoas_envolvidas',
        'utilidade_objetivo',
        'inerencias_planejamento',
        'expectativas',
        'custo',
        'entrega',
        'atendimento',
        'qualidade',
        'inovacao',
        'logistica',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function desafioUser()
    {
        return $this->belongsTo(DesafioUser::class);
    }

    public function acoes()
    {
        return $this->hasMany(TevepAcao::class);
    }
}
