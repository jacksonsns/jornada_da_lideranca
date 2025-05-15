<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Transacao;
use App\Policies\TransacaoPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Transacao::class => TransacaoPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
} 