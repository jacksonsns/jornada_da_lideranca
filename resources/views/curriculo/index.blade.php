@extends('layouts.app')

@section('title', 'Currículo Junior')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <h1 class="display-5 fw-bold text-primary mb-3">Meu Currículo Juniorístico</h1>
                        <p class="lead text-muted">Preencha seu currículo para participar da Jornada da Liderança</p>
                    </div>
                    
                    <form id="msform" action="{{ route('curriculo.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Progress Bar -->
                        <div class="progress-container mb-5">
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 0%"></div>
                            </div>
                            <div class="steps d-flex justify-content-between mt-3">
                                <div class="step active" data-step="1">
                                    <div class="step-circle">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="step-text">Informações Básicas</div>
                                </div>
                                <div class="step-line"></div>
                                <div class="step" data-step="2">
                                    <div class="step-circle">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <div class="step-text">Outras Informações</div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 1 -->
                        <div class="step-content" data-step="1">
                            <div class="row mb-4">
                                <div class="col-7">
                                    <h2 class="fs-title text-primary">
                                        <i class="fas fa-user-circle me-2"></i>
                                        Informações básicas
                                    </h2>
                                </div>
                                <div class="col-5 text-end">
                                    <span class="badge bg-primary fs-6">Etapa 1 - 2</span>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="fieldlabels">
                                        <i class="fas fa-envelope me-2"></i>
                                        Email: *
                                    </label>
                                    <input type="email" name="email" class="form-control form-control-lg" value="{{ old('email', $user->email) }}" placeholder="Seu email" required>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="fieldlabels">
                                        <i class="fas fa-user me-2"></i>
                                        Nome Completo: *
                                    </label>
                                    <input type="text" name="name" class="form-control form-control-lg" value="{{ old('name', $user->name) }}" placeholder="Seu nome completo" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="fieldlabels">
                                        <i class="fas fa-calendar me-2"></i>
                                        Data de Nascimento: *
                                    </label>
                                    <input type="date" name="data_nascimento" class="form-control form-control-lg" value="{{ old('data_nascimento', $user->data_nascimento ? $user->data_nascimento->format('Y-m-d') : '') }}" required>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="fieldlabels">
                                        <i class="fas fa-user-friends me-2"></i>
                                        Nome padrinho/madrinha: *
                                    </label>
                                    <input type="text" name="padrinho" class="form-control form-control-lg" value="{{ old('padrinho', $user->padrinho) }}" placeholder="Qual é o nome do seu padrinho/madrinha?" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="fieldlabels">
                                    <i class="fas fa-camera me-2"></i>
                                    Foto de Perfil:
                                </label>
                                <div class="avatar-upload">
                                    @if($user->avatar)
                                        <div class="mb-3">
                                            <img src="{{ Storage::url($user->avatar) }}" alt="Foto de perfil" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                        </div>
                                    @endif
                                    <div class="input-group">
                                        <input type="file" name="avatar" class="form-control form-control-lg" accept="image/*">
                                        <label class="input-group-text" for="avatar">
                                            <i class="fas fa-upload"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary btn-lg next-step">
                                    Próximo
                                    <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="step-content d-none" data-step="2">
                            <div class="row mb-4">
                                <div class="col-7">
                                    <h2 class="fs-title text-primary">
                                        <i class="fas fa-briefcase me-2"></i>
                                        Outras Informações
                                    </h2>
                                </div>
                                <div class="col-5 text-end">
                                    <span class="badge bg-primary fs-6">Etapa 2 - 2</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="fieldlabels">
                                    <i class="fas fa-tasks me-2"></i>
                                    Cite os cargos que você já ocupou informando o ano, assim como, quando você foi aspirante. Você pode pular a linha a cada cargo: *
                                </label>
                                <textarea name="cargo" class="form-control form-control-lg" rows="4" required>{{ old('cargo', $user->cargo) }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label class="fieldlabels">
                                    <i class="fas fa-calendar-check me-2"></i>
                                    Cite os eventos entre OL's que você já participou informando o ano e o local (caso não tenha, deixe em branco):
                                </label>
                                <textarea name="eventos" class="form-control form-control-lg" rows="4">{{ old('eventos', $user->eventos) }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label class="fieldlabels">
                                    <i class="fas fa-graduation-cap me-2"></i>
                                    Cite os cursos oficiais da JCI e outros que você já realizou (caso não tenha, deixe em branco):
                                </label>
                                <div class="courses-grid">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="course-group">
                                                <div class="form-check custom-checkbox mb-3">
                                                    <input type="checkbox" name="adm" class="form-check-input" id="adm" {{ old('adm', $user->adm) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="adm">
                                                        <i class="fas fa-check-circle me-2"></i>
                                                        ADM
                                                    </label>
                                                </div>
                                                <div class="form-check custom-checkbox mb-3">
                                                    <input type="checkbox" name="admin_curso" class="form-check-input" id="admin_curso" {{ old('admin_curso', $user->admin_curso) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="admin_curso">Admin</label>
                                                </div>
                                                <div class="form-check custom-checkbox mb-3">
                                                    <input type="checkbox" name="impact" class="form-check-input" id="impact" {{ old('impact', $user->impact) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="impact">Impact</label>
                                                </div>
                                                <div class="form-check custom-checkbox mb-3">
                                                    <input type="checkbox" name="archieve" class="form-check-input" id="archieve" {{ old('archieve', $user->archieve) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="archieve">Archieve</label>
                                                </div>
                                                <div class="form-check custom-checkbox mb-3">
                                                    <input type="checkbox" name="responsabilidade" class="form-check-input" id="responsabilidade" {{ old('responsabilidade', $user->responsabilidade) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="responsabilidade">Responsabilidade</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="course-group">
                                                <div class="form-check custom-checkbox mb-3">
                                                    <input type="checkbox" name="reunioes" class="form-check-input" id="reunioes" {{ old('reunioes', $user->reunioes) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="reunioes">Reuniões eficazes</label>
                                                </div>
                                                <div class="form-check custom-checkbox mb-3">
                                                    <input type="checkbox" name="networking" class="form-check-input" id="networking" {{ old('networking', $user->networking) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="networking">Networking</label>
                                                </div>
                                                <div class="form-check custom-checkbox mb-3">
                                                    <input type="checkbox" name="mentoring" class="form-check-input" id="mentoring" {{ old('mentoring', $user->mentoring) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="mentoring">Mentoring</label>
                                                </div>
                                                <div class="form-check custom-checkbox mb-3">
                                                    <input type="checkbox" name="explore" class="form-check-input" id="explore" {{ old('explore', $user->explore) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="explore">Explore</label>
                                                </div>
                                                <div class="form-check custom-checkbox mb-3">
                                                    <input type="checkbox" name="envolva" class="form-check-input" id="envolva" {{ old('envolva', $user->envolva) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="envolva">Envolva, capacite, cresça</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="contruindo_fundacao" class="form-check-input" id="contruindo_fundacao" {{ old('contruindo_fundacao', $user->contruindo_fundacao) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="contruindo_fundacao">Comunicação eficaz: Construindo uma fundação</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="elaborando_mensagem" class="form-check-input" id="elaborando_mensagem" {{ old('elaborando_mensagem', $user->elaborando_mensagem) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="elaborando_mensagem">Comunicação eficaz: Elaborando uma mensagem</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="entrega_mensagem" class="form-check-input" id="entrega_mensagem" {{ old('entrega_mensagem', $user->entrega_mensagem) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="entrega_mensagem">Comunicação eficaz: Entrega de mensagem</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="gestao_marketing" class="form-check-input" id="gestao_marketing" {{ old('gestao_marketing', $user->gestao_marketing) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gestao_marketing">Comunicação eficaz: Gestão de marketing</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="lideranca" class="form-check-input" id="lideranca" {{ old('lideranca', $user->lideranca) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="lideranca">Liderança efetiva</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="facilitador" class="form-check-input" id="facilitador" {{ old('facilitador', $user->facilitador) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="facilitador">Facilitador</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="gerenciamento_projeto" class="form-check-input" id="gerenciamento_projeto" {{ old('gerenciamento_projeto', $user->gerenciamento_projeto) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gerenciamento_projeto">Gerenciamento de projetos</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="discover" class="form-check-input" id="discover" {{ old('discover', $user->discover) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="discover">Discover</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="apresentador" class="form-check-input" id="apresentador" {{ old('apresentador', $user->apresentador) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="apresentador">Apresentador</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="oratoria" class="form-check-input" id="oratoria" {{ old('oratoria', $user->oratoria) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="oratoria">Oratória</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="curso_facilitador" class="form-check-input" id="curso_facilitador" {{ old('curso_facilitador', $user->curso_facilitador) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="curso_facilitador">Curso de Facilitador</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="outro" class="form-check-input" id="outro" {{ old('outro', $user->outro) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="outro">Outro</label>
                                    </div>
                                    <div class="mb-3 outro-cursos" style="display: none;">
                                        <label class="fieldlabels">Quais outros cursos?</label>
                                        <textarea name="outros_cursos" class="form-control" rows="3" 
                                            placeholder="Digite os outros cursos que você realizou, separando por vírgula.">{{ old('outros_cursos', $user->outros_cursos) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="fieldlabels">
                                    <i class="fas fa-chalkboard-teacher me-2"></i>
                                    Cite os cursos que você já foi facilitador pela JCI, se lembrar, informe o ano (caso não tenha, deixe em branco):
                                </label>
                                <textarea name="curso_facilitador" class="form-control form-control-lg" rows="4">{{ old('curso_facilitador', $user->curso_facilitador) }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label class="fieldlabels">
                                    <i class="fas fa-users me-2"></i>
                                    Cite as comissões de projetos que você já participou, se lembrar, (caso não tenha, deixe em branco):
                                </label>
                                <textarea name="comissoes" class="form-control form-control-lg" rows="4">{{ old('comissoes', $user->comissoes) }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label class="fieldlabels">
                                    <i class="fas fa-trophy me-2"></i>
                                    Cite os concursos que você já participou, se lembrar, informe o ano (caso não tenha, deixe em branco):
                                </label>
                                <textarea name="concursos_participados" class="form-control form-control-lg" rows="4">{{ old('concursos_participados', $user->concursos_participados) }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label class="fieldlabels">
                                    <i class="fas fa-medal me-2"></i>
                                    Descreva suas premiações e realizações que você recorda da sua jornada na JCI! (Caso não tenha, deixe em branco):
                                </label>
                                <textarea name="premiacoes" class="form-control form-control-lg" rows="4">{{ old('premiacoes', $user->premiacoes) }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label class="fieldlabels">
                                    <i class="fas fa-handshake me-2"></i>
                                    Cite empresas e entidades que você tem vínculos e que podem formar parcerias com a JCI! (caso não tenha, deixe em branco):
                                </label>
                                <textarea name="empresas_vinculos" class="form-control form-control-lg" rows="4">{{ old('empresas_vinculos', $user->empresas_vinculos) }}</textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary btn-lg prev-step">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Voltar
                                </button>
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-check me-2"></i>
                                    Finalizar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
.progress-container {
    position: relative;
    margin-bottom: 30px;
}

.progress {
    height: 10px;
    background-color: #e9ecef;
    border-radius: 5px;
    overflow: hidden;
}

.progress-bar {
    background: linear-gradient(45deg, #0d6efd, #0dcaf0);
    transition: width 0.3s ease;
}

.steps {
    position: relative;
    margin-top: 20px;
}

.step {
    text-align: center;
    position: relative;
    z-index: 1;
}

.step-circle {
    width: 50px;
    height: 50px;
    background-color: #e9ecef;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    color: #6c757d;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.step.active .step-circle {
    background: linear-gradient(45deg, #0d6efd, #0dcaf0);
    color: white;
    transform: scale(1.1);
}

.step-text {
    font-size: 0.9rem;
    color: #6c757d;
    transition: all 0.3s ease;
    font-weight: 500;
}

.step.active .step-text {
    color: #0d6efd;
    font-weight: 600;
}

.step-line {
    position: absolute;
    top: 25px;
    left: 25%;
    right: 25%;
    height: 2px;
    background-color: #e9ecef;
    z-index: 0;
}

.step-content {
    transition: all 0.3s ease;
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn {
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.form-control {
    border-radius: 8px;
    padding: 0.75rem 1rem;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus {
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    border-color: #86b7fe;
}

.fieldlabels {
    font-weight: 500;
    margin-bottom: 0.5rem;
    display: block;
    color: #495057;
}

.fs-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #0d6efd;
}

.avatar-upload {
    position: relative;
}

.avatar-upload img {
    border: 3px solid #0d6efd;
    transition: all 0.3s ease;
}

.avatar-upload img:hover {
    transform: scale(1.05);
}

.courses-grid {
    background-color: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
}

.custom-checkbox .form-check-input {
    width: 1.2em;
    height: 1.2em;
    margin-top: 0.2em;
}

.custom-checkbox .form-check-label {
    font-size: 1rem;
    padding-left: 0.5rem;
}

.badge {
    padding: 0.5rem 1rem;
    font-weight: 500;
}

.input-group-text {
    background-color: #0d6efd;
    color: white;
    border: none;
    cursor: pointer;
}

.input-group-text:hover {
    background-color: #0b5ed7;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('msform');
    const steps = document.querySelectorAll('.step');
    const stepContents = document.querySelectorAll('.step-content');
    const progressBar = document.querySelector('.progress-bar');
    const nextButtons = document.querySelectorAll('.next-step');
    const prevButtons = document.querySelectorAll('.prev-step');
    let currentStep = 1;

    // Função para mostrar/esconder o textarea de outros cursos
    const outroCheckbox = document.getElementById('outro');
    const outrosCursosDiv = document.querySelector('.outro-cursos');
    
    function toggleOutrosCursos() {
        outrosCursosDiv.style.display = outroCheckbox.checked ? 'block' : 'none';
    }
    
    outroCheckbox.addEventListener('change', toggleOutrosCursos);
    toggleOutrosCursos();

    function updateProgress() {
        const progress = ((currentStep - 1) / (steps.length - 1)) * 100;
        progressBar.style.width = `${progress}%`;

        steps.forEach((step, index) => {
            if (index + 1 <= currentStep) {
                step.classList.add('active');
            } else {
                step.classList.remove('active');
            }
        });

        stepContents.forEach((content, index) => {
            if (index + 1 === currentStep) {
                content.classList.remove('d-none');
                content.style.animation = 'fadeIn 0.5s ease';
            } else {
                content.classList.add('d-none');
            }
        });
    }

    nextButtons.forEach(button => {
        button.addEventListener('click', () => {
            if (currentStep < steps.length) {
                currentStep++;
                updateProgress();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    });

    prevButtons.forEach(button => {
        button.addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                updateProgress();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    });

    // Inicialização
    updateProgress();
});
</script>
@endpush
@endsection 