<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Desafio;

class UserObserver
{
    public function updated(User $user)
    {
        // Verifica se o perfil está completo
        if ($this->perfilCompleto($user)) {
            $desafio = Desafio::where('descricao', 'Complete seu perfil no sistema')->first();
            if ($desafio) {
                $user->desafios()->updateOrCreate(
                    ['desafio_id' => $desafio->id],
                    [
                        'concluido' => true,
                        'concluido_em' => now()
                    ]
                );
                $user->increment('pontos', 2);
            }
        }
    }

    private function perfilCompleto(User $user)
    {
        return !empty($user->name) &&
               !empty($user->email) &&
               !empty($user->avatar);
    }
} 