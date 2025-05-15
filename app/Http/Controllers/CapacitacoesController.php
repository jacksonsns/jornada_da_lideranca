<?php

namespace App\Http\Controllers;

use App\Models\Capacitacao;
use Illuminate\Http\Request;

class CapacitacoesController extends Controller
{
    public function index()
    {
        $capacitacoes = Capacitacao::orderBy('data', 'desc')->get();
        return view('capacitacoes.index', compact('capacitacoes'));
    }

    public function show($id)
    {
        $capacitacao = Capacitacao::findOrFail($id);
        return view('capacitacoes.show', compact('capacitacao'));
    }
} 