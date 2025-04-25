<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\DesafioAutomaticoService;

class RegistrarVisitaMiddleware
{
    protected $desafioService;

    public function __construct(DesafioAutomaticoService $desafioService)
    {
        $this->desafioService = $desafioService;
    }

    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $secao = $this->identificarSecao($request->path());

            if ($secao) {
                $user->visitas()->create(['secao' => $secao]);
                $this->desafioService->verificarDesafios($user);
            }
        }

        return $next($request);
    }

    private function identificarSecao(string $path): ?string
    {
        $mapeamento = [
            'quadro-dos-sonhos' => 'quadro-dos-sonhos',
            'desafios' => 'desafios',
            'escola-lideres' => 'escola-lideres',
            'capacitacoes' => 'capacitacoes',
            'projeto-individual' => 'projeto-individual',
            'agenda' => 'agenda',
            'area-financeira' => 'area-financeira'
        ];

        foreach ($mapeamento as $padrao => $secao) {
            if (str_starts_with($path, $padrao)) {
                return $secao;
            }
        }

        return null;
    }
} 