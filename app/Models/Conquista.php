<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conquista extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'pontos',
        'criterio',
        'valor_requerido',
    ];


    public function users()
    {
        return $this->belongsToMany(User::class, 'conquista_user')
            ->withPivot('conquistado_em')
            ->withTimestamps();
    }

    public function verificarProgresso(User $user): int
    {
        switch ($this->criterio) {
            case 'etapas_concluidas':
                return $user->jornadaAspirante()
                    ->wherePivot('concluido', true)
                    ->count();
            
            case 'desafios_concluidos':
                return $user->desafios()
                    ->wherePivot('concluido', true)
                    ->count();
            
            case 'modulos_concluidos':
                return $user->escolaLideres()
                    ->wherePivot('concluido', true)
                    ->count();
            
            default:
                return 0;
        }
    }


    public function verificarConquista(User $user): bool
    {
        return $this->verificarProgresso($user) >= $this->valor_requerido;
    }
}