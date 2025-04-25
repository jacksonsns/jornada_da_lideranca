<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capacitacao extends Model
{
    use HasFactory;

    protected $table = 'capacitacoes';

    protected $fillable = [
        'titulo',
        'descricao',
        'data_realizacao',
        'instrutor',
        'material_url',
        'insights',
        'categoria',
        'carga_horaria',
        'local'
    ];

    protected $casts = [
        'data_realizacao' => 'datetime',
        'insights' => 'array'
    ];

    public function participantes()
    {
        return $this->belongsToMany(User::class, 'capacitacao_participantes')
            ->withPivot('presente', 'feedback', 'nota')
            ->withTimestamps();
    }

    public function anexos()
    {
        return $this->hasMany(CapacitacaoAnexo::class);
    }

    public function avaliacoes()
    {
        return $this->hasMany(CapacitacaoAvaliacao::class);
    }
} 