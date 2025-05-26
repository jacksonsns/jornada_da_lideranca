<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Transacao;
use App\Policies\TransacaoPolicy;
use App\Models\Classificado;
use App\Policies\ClassificadoPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Transacao::class => TransacaoPolicy::class,
        Classificado::class => ClassificadoPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
} 