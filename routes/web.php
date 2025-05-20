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
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\CapacitacoesController;
use App\Http\Controllers\CurriculoJuniorController;

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
    Route::get('quadro-dos-sonhos', [QuadroDosSonhosController::class, 'index'])->name('quadro-dos-sonhos.index');
    Route::get('quadro-dos-sonhos/create', [QuadroDosSonhosController::class, 'create'])->name('quadro-dos-sonhos.create');
    Route::post('quadro-dos-sonhos/store', [QuadroDosSonhosController::class, 'store'])->name('quadro-dos-sonhos.store');
    Route::get('quadro-dos-sonhos/{quadro_dos_sonho}', [QuadroDosSonhosController::class, 'show'])->name('quadro-dos-sonhos.show');
    Route::get('quadro-dos-sonhos/{quadro_dos_sonho}/edit', [QuadroDosSonhosController::class, 'edit'])->name('quadro-dos-sonhos.edit');
    Route::put('quadro-dos-sonhos/{quadro_dos_sonho}', [QuadroDosSonhosController::class, 'update'])->name('quadro-dos-sonhos.update');
    Route::delete('quadro-dos-sonhos/{quadro_dos_sonho}', [QuadroDosSonhosController::class, 'destroy'])->name('quadro-dos-sonhos.destroy');

    // Desafios
    Route::get('desafios', [DesafioController::class, 'index'])->name('desafios.index');
    Route::post('desafios/concluir', [DesafioController::class, 'concluir'])->name('desafios.concluir');

    Route::post('jornada/{desafio}/concluir', [JornadaAspiranteController::class, 'concluir'])->name('jornada.concluir');

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


    // Capacitações (visualização para usuários)
    Route::get('capacitacoes', [CapacitacoesController::class, 'index'])->name('capacitacoes.index');
    Route::get('capacitacoes/{capacitacao}', [CapacitacoesController::class, 'show'])->name('capacitacoes.show');

    // Projeto Individual
    Route::resource('projetos-individuais', ProjetoIndividualController::class);
    Route::post('projetos-individuais/{projeto}/concluir', [ProjetoIndividualController::class, 'concluir'])->name('projetos-individuais.concluir');
    Route::post('projetos-individuais/{projeto}/atualizar-progresso', [ProjetoIndividualController::class, 'atualizarProgresso'])->name('projetos-individuais.progresso');

    // Agenda
    Route::resource('agenda', AgendaController::class);
    Route::post('agenda/{evento}/confirmar-presenca', [AgendaController::class, 'confirmarPresenca'])->name('agenda.confirmar-presenca');

    // Integração e Acompanhamento
    Route::resource('integracao-acompanhamento', IntegracaoAcompanhamentoController::class);

    // Perfil
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');
    Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
    Route::post('/perfil/avatar', [PerfilController::class, 'atualizarAvatar'])->name('perfil.avatar');

    // Google Auth
    Route::get('google/auth', [EventoController::class, 'googleAuth'])->name('google.auth');

    // Projeto Individual (alias para projetos-individuais)
    Route::get('projeto-individual', [ProjetoIndividualController::class, 'index'])->name('projeto-individual.index');
    Route::post('admin/projetos-individuais', [ProjetoIndividualController::class, 'store'])->name('projetos-individuais.store');
    Route::put('admin/projetos-individuais/{projeto}', [ProjetoIndividualController::class, 'update'])->name('projetos-individuais.update');
    Route::delete('admin/projetos-individuais/{projeto}', [ProjetoIndividualController::class, 'destroy'])->name('projetos-individuais.destroy');

    // Rotas da Escola de Líderes
    Route::get('/escola-lideres', [EscolaLideresController::class, 'index'])->name('escola-lideres.index');

    Route::get('/curriculo-junior', [CurriculoJuniorController::class, 'index'])->name('curriculo-junior.index');
    
    // Rotas para módulos
    Route::get('/escola-lideres/modulo/{modulo}', [EscolaLideresController::class, 'modulo'])->name('escola-lideres.modulo');
    Route::post('/escola-lideres/modulo/{modulo}/matricular', [EscolaLideresController::class, 'matricular'])->name('escola-lideres.matricular');
    
    // Rotas para aulas
    Route::get('/escola-lideres/aula/{aula}', [EscolaLideresController::class, 'aula'])->name('escola-lideres.aula');
    Route::post('/escola-lideres/aula/{aula}/concluir', [EscolaLideresController::class, 'concluirAula'])->name('escola-lideres.concluir-aula');
    Route::post('/escola-lideres/aula/{aula}/avaliar', [EscolaLideresController::class, 'avaliarAula'])->name('escola-lideres.avaliar-aula');

    // Google Calendar Routes
    Route::get('/agenda', [App\Http\Controllers\GoogleCalendarController::class, 'index'])->name('agenda.index');
    Route::get('/google/connect', [App\Http\Controllers\GoogleCalendarController::class, 'connect'])->name('google.connect');
    Route::get('/google/callback', [App\Http\Controllers\GoogleCalendarController::class, 'callback'])->name('google.callback');
    Route::get('/google/disconnect', [App\Http\Controllers\GoogleCalendarController::class, 'disconnect'])->name('google.disconnect');
});

// Rotas administrativas
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('admin', [AdminController::class, 'index'])->name('admin.index');
    
    // Rotas de Usuários
    Route::resource('admin/users', \App\Http\Controllers\Admin\UserController::class)->names('admin.users');


    Route::get('admin/users/show/{id}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('admin.users.show');
    
    Route::post('remover-jornada', [\App\Http\Controllers\Admin\UserController::class, 'removerPontuacaoJornada'])->name('remover-pontuacao-jornada');
    Route::post('remover-desafio-junior', [\App\Http\Controllers\Admin\UserController::class, 'removerPontuacaoDesafioJunior'])->name('remover-pontuacao-desafio-junior');

    Route::post('add-jornada', [\App\Http\Controllers\Admin\UserController::class, 'addPontuacaoJornada'])->name('add-pontuacao-jornada');
    Route::post('add-desafio-junior', [\App\Http\Controllers\Admin\UserController::class, 'addPontuacaoDesafioJunior'])->name('add-pontuacao-desafio-junior');

    // Rotas de Desafios
    Route::get('admin/desafios', [AdminController::class, 'desafiosIndex'])->name('admin.desafios.index');
    Route::post('admin/desafios', [AdminController::class, 'desafioStore'])->name('admin.desafios.store');
    Route::put('admin/desafios/{desafio}', [AdminController::class, 'desafioUpdate'])->name('admin.desafios.update');
    Route::delete('admin/desafios/{desafio}', [AdminController::class, 'desafioDestroy'])->name('admin.desafios.destroy');

    // Rotas da Jornada do Aspirante
    Route::get('admin/jornada', [AdminController::class, 'jornadaIndex'])->name('admin.jornada.index');
    Route::post('admin/jornada', [AdminController::class, 'jornadaStore'])->name('admin.jornada.store');
    Route::put('admin/jornada/{jornada}', [AdminController::class, 'jornadaUpdate'])->name('admin.jornada.update');
    Route::delete('admin/jornada/{jornada}', [AdminController::class, 'jornadaDestroy'])->name('admin.jornada.destroy');

    // Rotas da Escola de Líderes (Admin)
    Route::get('admin/aulas', [AdminController::class, 'aulasIndex'])->name('admin.aulas.index');
    Route::post('admin/aulas', [AdminController::class, 'aulaStore'])->name('admin.aulas.store');
    Route::put('admin/aulas/{aula}', [AdminController::class, 'aulaUpdate'])->name('admin.aulas.update');
    Route::delete('admin/aulas/{aula}', [AdminController::class, 'aulaDestroy'])->name('admin.aulas.destroy');

    // Rotas da Escola de Líderes (Admin)
    Route::get('admin/escola-lideres', [AdminController::class, 'escolaLideresIndex'])->name('admin.escola-lideres.index');
    Route::post('admin/escola-lideres', [AdminController::class, 'escolaLideresStore'])->name('admin.escola-lideres.store');
    Route::put('admin/escola-lideres/{modulo}', [AdminController::class, 'escolaLideresUpdate'])->name('admin.escola-lideres.update');
    Route::delete('admin/escola-lideres/{modulo}', [AdminController::class, 'escolaLideresDestroy'])->name('admin.escola-lideres.destroy');

    // Rotas de Projetos Individuais (Admin)
    Route::get('admin/projetos-individuais', [AdminController::class, 'projetosIndividuaisIndex'])->name('admin.projetos-individuais.index');
    
    // Área Financeira
    Route::resource('area-financeira', AreaFinanceiraController::class)->parameters([
        'area-financeira' => 'transacao'
    ]);
    Route::get('financeiro', [AreaFinanceiraController::class, 'index'])->name('financeiro.index');
    Route::get('financeiro/metas', [AreaFinanceiraController::class, 'metas'])->name('financeiro.metas');

    // Rotas de Capacitações
    Route::get('admin/capacitacoes', [App\Http\Controllers\Admin\CapacitacoesController::class, 'index'])->name('admin.capacitacoes.index');
    Route::post('admin/capacitacoes', [App\Http\Controllers\Admin\CapacitacoesController::class, 'store'])->name('admin.capacitacoes.store');
    Route::put('admin/capacitacoes/{capacitacao}', [App\Http\Controllers\Admin\CapacitacoesController::class, 'update'])->name('admin.capacitacoes.update');
    Route::delete('admin/capacitacoes/{capacitacao}', [App\Http\Controllers\Admin\CapacitacoesController::class, 'destroy'])->name('admin.capacitacoes.destroy');

    Route::get('/admin/users/{id}/curriculo-junior', [App\Http\Controllers\Admin\UserController::class, 'generateCurriculoJunior'])
        ->name('admin.users.curriculo-junior');
});

Route::prefix('curriculo')->group(function () {
    Route::get('/', [CurriculoJuniorController::class, 'index'])->name('curriculo.index');
    Route::post('/store', [CurriculoJuniorController::class, 'store'])->name('curriculo.store');
    Route::get('/success', [CurriculoJuniorController::class, 'success'])->name('curriculo.success');
});

require __DIR__.'/auth.php';
