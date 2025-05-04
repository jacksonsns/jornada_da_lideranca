<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>@yield('title', 'Jornada da Liderança')</title>

        <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap1.min.css') }}" />
        <!-- themefy CSS -->
        <link rel="stylesheet" href="{{ asset('vendors/themefy_icon/themify-icons.css') }}" />
        <!-- swiper slider CSS -->
        <link rel="stylesheet" href="{{ asset('vendors/swiper_slider/css/swiper.min.css') }}" />
        <!-- select2 CSS -->
        <link rel="stylesheet" href="{{ asset('vendors/select2/css/select2.min.css') }}" />
        <!-- select2 CSS -->
        <link rel="stylesheet" href="{{ asset('vendors/niceselect/css/nice-select.css') }}" />
        <!-- owl carousel CSS -->
        <link rel="stylesheet" href="{{ asset('vendors/owl_carousel/css/owl.carousel.css') }}" />
        <!-- gijgo css -->
        <link rel="stylesheet" href="{{ asset('vendors/gijgo/gijgo.min.css') }}" />
        <!-- font awesome CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('vendors/tagsinput/tagsinput.css') }}" />
        <!-- date picker -->
        <link rel="stylesheet" href="{{ asset('vendors/datepicker/date-picker.css') }}" />
        <!-- datatable CSS -->
        <link rel="stylesheet" href="{{ asset('vendors/datatable/css/jquery.dataTables.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('vendors/datatable/css/responsive.dataTables.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('vendors/datatable/css/buttons.dataTables.min.css') }}" />
        <!-- text editor css -->
        <link rel="stylesheet" href="{{ asset('vendors/text_editor/summernote-bs4.css') }}" />
        <!-- morris css -->
        <link rel="stylesheet" href="{{ asset('vendors/morris/morris.css') }}">
        <!-- metarial icon css -->
        <link rel="stylesheet" href="{{ asset('vendors/material_icon/material-icons.css') }}" />
        <!-- menu css  -->
        <link rel="stylesheet" href="{{ asset('css/metisMenu.css') }}">
        <!-- style CSS -->
        <link rel="stylesheet" href="{{ asset('css/style1.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/colors/default.css') }}" id="colorSkinCSS">
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
        @stack('styles')
    </head>

    <!-- Modal -->
    <div class="modal fade" id="emDesenvolvimentoModal" tabindex="-1" aria-labelledby="emDesenvolvimentoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-warning">
        <div class="modal-header bg-warning text-dark">
            <h5 class="modal-title" id="emDesenvolvimentoModalLabel">Área em Desenvolvimento</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body text-center">
            <p>Essa área ainda está em desenvolvimento.</p>
            <p>Estamos trabalhando para disponibilizá-la em breve!</p>
            <img src="https://cdn-icons-png.flaticon.com/512/2784/2784461.png" alt="Em desenvolvimento" width="80">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </div>
        </div>
    </div>
    </div>


    <body class="crm_body_bg">
        <nav class="sidebar">
            <div class="logo d-flex justify-content-between">
                <a href="{{ route('dashboard') }}"><img src="{{ asset('img/logo.png') }}" alt=""></a>
                <div class="sidebar_close_icon d-lg-none">
                    <i class="ti-close"></i>
                </div>
            </div>
            <ul id="sidebar_menu">
                <li>
                    <a href="{{ route('dashboard') }}" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a type="button" href="{{ route('quadro-dos-sonhos.index') }}" aria-expanded="false">
                        <i class="fas fa-star text-warning"></i>
                        <span>Quadro dos Sonhos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('desafios.index') }}" aria-expanded="false">
                        <i class="fas fa-trophy text-orange"></i>
                        <span>Desafio Júnior</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('jornada-aspirante.index') }}" aria-expanded="false">
                        <i class="fas fa-trophy text-orange"></i>
                        <span>Jornada do Aspirante</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('area-financeira.index') }}" aria-expanded="false">
                        <i class="fas fa-chart-bar text-success"></i>
                        <span>Área Financeira</span>
                    </a>
                </li>
                <li>
                    <a type="button" data-bs-toggle="modal" data-bs-target="#emDesenvolvimentoModal" aria-expanded="false">
                        <i class="fas fa-graduation-cap text-primary"></i>
                        <span>Escola de Líderes</span>
                    </a>
                    <ul>
                        <li>
                            <a type="button" data-bs-toggle="modal" data-bs-target="#emDesenvolvimentoModal" >
                                <i class="fas fa-chalkboard-teacher"></i>
                                <span>Capacitações</span>
                            </a>
                        </li>
                        <li>
                            <a type="button" data-bs-toggle="modal" data-bs-target="#emDesenvolvimentoModal" >
                                <i class="fas fa-project-diagram"></i>
                                <span>Projetos Individuais</span>
                            </a>
                        </li>
                        <li>
                            <a type="button" data-bs-toggle="modal" data-bs-target="#emDesenvolvimentoModal" >
                                <i class="fas fa-handshake"></i>
                                <span>Integração e Acompanhamento</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a type="button" data-bs-toggle="modal" data-bs-target="#emDesenvolvimentoModal" >
                        <i class="fas fa-bullseye text-warning"></i>
                        <span>Projeto Individual</span>
                    </a>
                </li>
                <li>
                    <a type="button" data-bs-toggle="modal" data-bs-target="#emDesenvolvimentoModal" >
                        <i class="fas fa-calendar-alt text-primary"></i>
                        <span>Agenda</span>
                    </a>
                </li>
                <li>
                    <a type="button" data-bs-toggle="modal" data-bs-target="#emDesenvolvimentoModal" aria-expanded="false">
                        <i class="fas fa-chart-line" style="color:#991ADD"></i>
                        <span>Integração e Acompanhamento</span>
                    </a>
                </li>
            </ul>
        </nav>

        <section class="main_content dashboard_part">
            <!-- menu  -->
            <div class="container-fluid g-0">
                <div class="row">
                    <div class="col-lg-12 p-0 ">
                        <div class="header_iner d-flex justify-content-between align-items-center">
                            <div class="sidebar_icon d-lg-none">
                                <i class="ti-menu"></i>
                            </div>
                            <div class="serach_field-area">
                                <div class="search_inner">
                                    <form action="#">
                                        <div class="search_field">
                                            <input type="text" placeholder="Pesquisar...">
                                        </div>
                                        <button type="submit"> <img src="{{ asset('img/icon/icon_search.svg') }}" alt=""> </button>
                                    </form>
                                </div>
                            </div>
                            <div class="header_right d-flex justify-content-between align-items-center">
                                <div class="header_notification_warp d-flex align-items-center">
                                    <li>
                                        <a class="bell_notification_clicker" href="#"> <img src="{{ asset('img/icon/bell.svg') }}" alt="">
                                            <span>04</span>
                                        </a>
                                        <!-- Menu_NOtification_Wrap  -->
                                        <div class="Menu_NOtification_Wrap">
                                            <div class="notification_Header">
                                                <h4>Notificações</h4>
                                            </div>
                                            <div class="Notification_body">
                                                <!-- single_notify  -->
                                                <div class="single_notify d-flex align-items-center">
                                                    <div class="notify_thumb">
                                                        <a href="#"><img src="{{ asset('img/staf/2.png') }}" alt=""></a>
                                                    </div>
                                                    <div class="notify_content">
                                                        <a href="#">
                                                            <h5>Cool Directory </h5>
                                                        </a>
                                                        <p>Lorem ipsum dolor sit amet</p>
                                                    </div>
                                                </div>
                                                <!-- single_notify  -->
                                                <div class="single_notify d-flex align-items-center">
                                                    <div class="notify_thumb">
                                                        <a href="#"><img src="{{ asset('img/staf/4.png') }}" alt=""></a>
                                                    </div>
                                                    <div class="notify_content">
                                                        <a href="#">
                                                            <h5>Awesome packages</h5>
                                                        </a>
                                                        <p>Lorem ipsum dolor sit amet</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="nofity_footer">
                                                <div class="submit_button text-center pt_20">
                                                    <a href="#" class="btn_1">Ver Mais</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/ Menu_NOtification_Wrap  -->
                                    </li>
                                    <li>
                                        <a class="CHATBOX_open" href="#"> <img src="{{ asset('img/icon/msg.svg') }}" alt="">
                                            <span>01</span> </a>
                                    </li>
                                </div>
                                <div class="profile_info">
                                    <img src="{{ asset('img/avatar.png') }}" alt="#">
                                    <div class="profile_info_iner">
                                        <div class="profile_author_name">
                                            <p>Olá, </p>
                                            <h5>{{ auth()->user()->name }}</h5>
                                        </div>
                                        <div class="profile_info_details">
                                            <a href="{{ route('perfil.index') }}">Meu Perfil</a>
                                            <a href="{{ route('perfil.index') }}">Configurações</a>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Sair</a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ menu  -->

            <div class="main_content_iner">
                <div class="container-fluid p-0 sm_padding_15px">
                    @yield('content')
                </div>
            </div>

            <!-- footer part -->
            <div class="footer_part">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="footer_iner text-center">
                                <p>2025 © Jsn Developer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- jquery slim -->
        <script src="{{ asset('js/jquery1-3.4.1.min.js') }}"></script>
        <!-- popper js -->
        <script src="{{ asset('js/popper1.min.js') }}"></script>
        <!-- bootstarp js -->
        <script src="{{ asset('js/bootstrap1.min.js') }}"></script>
        <!-- sidebar menu  -->
        <script src="{{ asset('js/metisMenu.js') }}"></script>
        <!-- waypoints js -->
        <script src="{{ asset('vendors/count_up/jquery.waypoints.min.js') }}"></script>
        <!-- waypoints js -->
        <script src="{{ asset('vendors/chartlist/Chart.min.js') }}"></script>
        <!-- counterup js -->
        <script src="{{ asset('vendors/count_up/jquery.counterup.min.js') }}"></script>
        <!-- swiper slider js -->
        <script src="{{ asset('vendors/swiper_slider/js/swiper.min.js') }}"></script>
        <!-- nice select -->
        <script src="{{ asset('vendors/niceselect/js/jquery.nice-select.min.js') }}"></script>
        <!-- owl carousel -->
        <script src="{{ asset('vendors/owl_carousel/js/owl.carousel.min.js') }}"></script>
        <!-- gijgo css -->
        <script src="{{ asset('vendors/gijgo/gijgo.min.js') }}"></script>
        <!-- responsive table -->
        <script src="{{ asset('vendors/datatable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('vendors/datatable/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('vendors/datatable/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('vendors/datatable/js/buttons.flash.min.js') }}"></script>
        <script src="{{ asset('vendors/datatable/js/jszip.min.js') }}"></script>
        <script src="{{ asset('vendors/datatable/js/pdfmake.min.js') }}"></script>
        <script src="{{ asset('vendors/datatable/js/vfs_fonts.js') }}"></script>
        <script src="{{ asset('vendors/datatable/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('vendors/datatable/js/buttons.print.min.js') }}"></script>
        <!-- date picker  -->
        <script src="{{ asset('vendors/datepicker/datepicker.js') }}"></script>
        <script src="{{ asset('vendors/datepicker/datepicker.en.js') }}"></script>
        <script src="{{ asset('vendors/datepicker/datepicker.custom.js') }}"></script>
        <script src="{{ asset('js/chart.min.js') }}"></script>
        <!-- progressbar js -->
        <script src="{{ asset('vendors/progressbar/jquery.barfiller.js') }}"></script>
        <!-- tag input -->
        <script src="{{ asset('vendors/tagsinput/tagsinput.js') }}"></script>
        <!-- text editor js -->
        <script src="{{ asset('vendors/text_editor/summernote-bs4.js') }}"></script>
        <script src="{{ asset('vendors/am_chart/amcharts.js') }}"></script>
        <script src="{{ asset('vendors/apex_chart/apexcharts.js') }}"></script>
        <script src="{{ asset('vendors/apex_chart/apex_realestate.js') }}"></script>
        <script src="{{ asset('vendors/chart_am/core.js') }}"></script>
        <script src="{{ asset('vendors/chart_am/charts.js') }}"></script>
        <script src="{{ asset('vendors/chart_am/animated.js') }}"></script>
        <script src="{{ asset('vendors/chart_am/kelly.js') }}"></script>
        <script src="{{ asset('vendors/chart_am/chart-custom.js') }}"></script>
        <!-- custom js -->
        <script src="{{ asset('js/custom.js') }}"></script>
        <script src="{{ asset('vendors/apex_chart/bar_active_1.js') }}"></script>
        <script src="{{ asset('vendors/apex_chart/apex_chart_list.js') }}"></script>
        @stack('scripts')
    </body>
</html>
