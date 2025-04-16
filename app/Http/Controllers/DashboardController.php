<?php

namespace App\Http\Controllers;

use App\Models\QuadroDosSonhos;
use App\Models\Desafio;
use App\Models\JornadaAspirante;
use App\Models\EscolaLideres;
use App\Models\Capacitacao;
use App\Models\ProjetoIndividual;
use App\Models\Agenda;
use App\Models\AreaFinanceira;
use App\Models\IntegracaoAcompanhamento;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }
} 