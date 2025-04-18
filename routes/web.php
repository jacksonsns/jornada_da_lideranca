<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuadroDosSonhosController;
use App\Http\Controllers\DesafioController;
use App\Http\Controllers\JornadaAspiranteController;
use App\Http\Controllers\EscolaLideresController;
use App\Http\Controllers\CapacitacaoController;
use App\Http\Controllers\ProjetoIndividualController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AreaFinanceiraController;
use App\Http\Controllers\IntegracaoAcompanhamentoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotas de autenticação
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Rotas protegidas
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Quadro dos Sonhos
    Route::resource('quadro-dos-sonhos', QuadroDosSonhosController::class);

    // Desafios
    Route::resource('desafios', DesafioController::class);
    Route::post('desafios/{desafio}/concluir', [DesafioController::class, 'concluir'])->name('desafios.concluir');

    // Jornada do Aspirante
    Route::resource('jornada-aspirante', JornadaAspiranteController::class);
    Route::post('jornada-aspirante/{jornada}/concluir', [JornadaAspiranteController::class, 'concluir'])->name('jornada-aspirante.concluir');

    // Rotas da Jornada do Aspirante
    Route::get('/jornada-aspirante', [JornadaAspiranteController::class, 'index'])->name('jornada-aspirante.index');
    Route::get('/jornada-aspirante/iniciar', [JornadaAspiranteController::class, 'iniciarJornada'])->name('jornada-aspirante.iniciar');
    Route::get('/jornada-aspirante/{etapa}', [JornadaAspiranteController::class, 'show'])->name('jornada-aspirante.show');
    Route::post('/jornada-aspirante/{etapa}/progresso', [JornadaAspiranteController::class, 'atualizarProgresso'])->name('jornada-aspirante.progresso');
    Route::post('/jornada-aspirante/{etapa}/concluir', [JornadaAspiranteController::class, 'concluirEtapa'])->name('jornada-aspirante.concluir');
    Route::get('/jornada-aspirante/relatorio', [JornadaAspiranteController::class, 'relatorio'])->name('jornada-aspirante.relatorio');

    // Escola de Líderes
    Route::resource('escola-lideres', EscolaLideresController::class);
    Route::post('escola-lideres/{escola}/concluir', [EscolaLideresController::class, 'concluir'])->name('escola-lideres.concluir');

    // Capacitações
    Route::resource('capacitacoes', CapacitacaoController::class);
    Route::post('capacitacoes/{capacitacao}/concluir', [CapacitacaoController::class, 'concluir'])->name('capacitacoes.concluir');

    // Projeto Individual
    Route::resource('projeto-individual', ProjetoIndividualController::class);

    // Agenda
    Route::resource('agenda', AgendaController::class);
    Route::post('agenda/{evento}/confirmar-presenca', [AgendaController::class, 'confirmarPresenca'])->name('agenda.confirmar-presenca');

    // Área Financeira
    Route::resource('area-financeira', AreaFinanceiraController::class);

    // Integração e Acompanhamento
    Route::resource('integracao-acompanhamento', IntegracaoAcompanhamentoController::class);
});

require __DIR__.'/auth.php';
