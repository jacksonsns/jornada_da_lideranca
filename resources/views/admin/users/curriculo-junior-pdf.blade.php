<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Currículo Juniorístico - {{ $user->name }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }
        .resume-container {
            width: 100%;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }
        .header-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 120px; /* Altura reduzida para a barra superior */
            background: linear-gradient(to right, #ee0979, #ff6a00);
            z-index: 1;
        }
        .profile-header {
            position: relative; /* Remover absolute positioning */
            z-index: 2;
            text-align: center;
            padding-top: 40px; /* Ajustar padding no topo */
            margin-bottom: 50px; /* Espaço abaixo da seção do perfil */
        }
        .avatar {
            width: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin-bottom: 15px;
        }
        .user-name {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }
        .user-title {
             font-size: 16px;
             color: #555;
         }
        .content-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
            position: relative;
            z-index: 2;
            padding: 0 20px 20px 20px;
        }
        .grid-row {
            display: table-row;
        }
        .sidebar {
            display: table-cell;
            width: 35%;
            background-color: #f0f0f0;
            padding: 20px;
            vertical-align: top;
        }
        .main-content {
            display: table-cell;
            width: 65%;
            padding: 20px;
            vertical-align: top;
        }
        .section {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .section:last-child {
            border-bottom: none;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
            text-transform: uppercase;
        }
        .info-item {
            margin-bottom: 8px;
            font-size: 14px;
        }
        .info-label {
            font-weight: bold;
            color: #555;
        }
        .text-content {
            white-space: pre-line;
            font-size: 14px;
            color: #555;
            margin-top: 5px;
        }
        .text-content:empty::before {
            content: 'Não informado';
            color: #999;
            font-style: italic;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        li {
            margin-bottom: 5px;
            padding-left: 0;
            position: relative;
            font-size: 14px;
            color: #555;
        }
        li::before {
            content: '';
        }
         .skills-list li::before {
             content: '';
         }
         .contact-info .info-item {
             font-size: 14px;
             color: #555;
         }

    </style>
</head>
<body>
    <div class="resume-container">
        <div class="header-bg"></div>

        <div class="content-grid">
            <div class="grid-row">
                <div class="sidebar">

                <div class="profile-header">
                    @if($user->avatar)
                        <img src="{{ public_path('storage/' . $user->avatar) }}" alt="Foto de Perfil" class="avatar">
                    @endif
                </div>
                    <div class="section contact-info">
                        <div class="section-title">Informações Básicas</div>
                        <div class="info-item"><span class="info-label">Email:</span> {{ $user->email ?? 'Não informado' }}</div>
                        <div class="info-item"><span class="info-label">Telefone:</span> {{ $user->telefone ?? 'Não informado' }}</div>
                        <div class="info-item"><span class="info-label">Nascimento:</span> {{ $user->data_nascimento ? \Carbon\Carbon::parse($user->data_nascimento)->format('d/m/Y') : 'Não informado' }}</div>
                        <div class="info-item"><span class="info-label">Ingresso:</span> {{ $user->ano_de_ingresso ?? 'Não informado' }}</div>
                        <div class="info-item"><span class="info-label">Padrinho:</span> {{ $user->padrinho ?? 'Não informado' }}</div>
                    </div>
                </div> {{-- Fim sidebar --}}

                <div class="main-content">
                    <div class="user-name">{{ $user->name ?? 'Não informado' }}</div>
                    <div class="section skills-section">
                         <div class="section-title">Cursos oficiais da JCI e outros realizados</div>
                        <ul class="skills-list">
                             {{-- Listar todos os cursos booleanos --}}
                             @if($user->adm)<li>ADM</li>@endif
                             @if($user->admin_curso)<li>Admin</li>@endif
                             @if($user->impact)<li>Impact</li>@endif
                             @if($user->archieve)<li>Archieve</li>@endif
                             @if($user->responsabilidade)<li>Responsabilidade</li>@endif
                             @if($user->reunioes)<li>Reuniões eficazes</li>@endif
                             @if($user->networking)<li>Networking</li>@endif
                             @if($user->mentoring)<li>Mentoring</li>@endif
                             @if($user->explore)<li>Explore</li>@endif
                             @if($user->envolva)<li>Envolva, capacite, cresça</li>@endif
                             @if($user->contruindo_fundacao)<li>Comunicação eficaz: Construindo uma fundação</li>@endif
                             @if($user->elaborando_mensagem)<li>Comunicação eficaz: Elaborando uma mensagem</li>@endif
                             @if($user->entrega_mensagem)<li>Comunicação eficaz: Entrega de mensagem</li>@endif
                             @if($user->gestao_marketing)<li>Comunicação eficaz: Gestão de marketing</li>@endif
                             @if($user->lideranca)<li>Liderança efetiva</li>@endif
                             @if($user->facilitador)<li>Facilitador</li>@endif
                             @if($user->gerenciamento_projeto)<li>Gerenciamento de projetos</li>@endif
                             @if($user->discover)<li>Discover</li>@endif
                             @if($user->apresentador)<li>Apresentador</li>@endif
                             @if($user->oratoria)<li>Oratória</li>@endif
                             @if($user->curso_facilitador)<li>Curso de Facilitador</li>@endif

                             {{-- Adicionar outros campos booleanos de cursos/habilidades se houver --}}

                             {{-- Adicionar outros cursos especificados --}}
                             @if($user->outro && $user->outros_cursos)
                                 <li>Outros: {{ $user->outros_cursos }}</li>
                             @endif

                             {{-- Se nenhuma habilidade/curso estiver selecionado --}}
                             @if(!$user->adm && !$user->admin_curso && !$user->impact && !$user->archieve && !$user->responsabilidade && !$user->reunioes && !$user->networking && !$user->mentoring && !$user->explore && !$user->envolva && !$user->contruindo_fundacao && !$user->elaborando_mensagem && !$user->entrega_mensagem && !$user->gestao_marketing && !$user->lideranca && !$user->facilitador && !$user->gerenciamento_projeto && !$user->discover && !$user->apresentador && !$user->oratoria && !$user->curso_facilitador && !($user->outro && $user->outros_cursos))
                                 <li>Não informado</li>
                             @endif
                        </ul>
                    </div>

                    <div class="section">
                        <div class="section-title">Outras Informações</div>

                        <div class="info-item">
                            <span class="info-label">Cite os cargos que você já ocupou informando o ano, assim como, quando você foi aspirante. Você pode pular a linha a cada cargo: *:</span>
                            <div class="text-content">{{ $user->cargo ?? '' }}</div>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Cite os eventos entre OL's que você já participou informando o ano e o local (caso não tenha, deixe em branco):</span>
                            <div class="text-content">{{ $user->eventos ?? '' }}</div>
                        </div>

                         <div class="info-item">
                            <span class="info-label">Cite os cursos que você já foi facilitador pela JCI, se lembrar, informe o ano (caso não tenha, deixe em branco):</span>
                            <div class="text-content">{{ $user->curso_facilitador ?? '' }}</div>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Cite as comissões de projetos que você já participou, se lembrar, (caso não tenha, deixe em branco):</span>
                            <div class="text-content">{{ $user->comissoes ?? '' }}</div>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Cite os concursos que você já participou, se lembrar, informe o ano (caso não tenha, deixe em branco):</span>
                            <div class="text-content">{{ $user->concursos_participados ?? '' }}</div>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Descreva suas premiações e realizações que você recorda da sua jornada na JCI! (Caso não tenha, deixe em branco):</span>
                            <div class="text-content">{{ $user->premiacoes ?? '' }}</div>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Cite empresas e entidades que você tem vínculos e que podem formar parcerias com a JCI! (caso não tenha, deixe em branco):</span>
                            <div class="text-content">{{ $user->empresas_vinculos ?? '' }}</div>
                        </div>

                    </div>

                     {{-- Adicionar outras seções para a coluna direita se necessário com base no formulário --}}

                </div> {{-- Fim main-content --}}
            </div> {{-- Fim grid-row --}}
        </div> {{-- Fim content-grid --}}

    </div> {{-- Fim resume-container --}}
</body>
</html> 