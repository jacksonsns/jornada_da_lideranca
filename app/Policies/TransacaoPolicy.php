<?php

namespace App\Policies;

use App\Models\Transacao;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransacaoPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->admin) {
            return true;
        }
    }

    public function view(User $user, Transacao $transacao)
    {
        return false; // Somente admins podem ver
    }

    public function update(User $user, Transacao $transacao)
    {
        return false; // Somente admins podem editar
    }

    public function delete(User $user, Transacao $transacao)
    {
        return false; // Somente admins podem excluir
    }
} 