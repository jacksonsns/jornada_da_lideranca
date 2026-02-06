@extends('layouts.app')

@section('title', 'Agenda')

@section('content')
<style>
    .agenda-page-wrapper {
        padding: 1.5rem 1.5rem 1rem;
    }

    .agenda-shell-card {
        border-radius: 26px;
        border: none;
        background: radial-gradient(circle at 0 0, rgba(255,255,255,0.96), rgba(233,239,255,0.98));
        box-shadow: 0 22px 55px rgba(0,0,0,0.65);
        overflow: hidden;
    }

    .agenda-shell-card .white_card_header {
        border: none;
        border-radius: 26px 26px 0 0 !important;
        background: linear-gradient(135deg,#1b7aff,#33b3ff);
        box-shadow: 0 10px 25px rgba(15,35,95,0.45);
        padding: 16px 22px;
    }

    .agenda-shell-card .white_card_header .main-title h3 {
        color: #f5f7ff;
        margin: 0;
        font-weight: 600;
    }

    .agenda-shell-card .white_card_body {
        padding: 20px 22px 22px;
    }

    @media (max-width: 768px) {
        .agenda-page-wrapper {
            padding: 1rem 1rem 0.75rem;
        }
    }
</style>

<div class="container-fluid agenda-page-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="white_card card_height_100 mb_30 agenda-shell-card">
                <div class="white_card_header">
                    <div class="box_header m-0">
                        <div class="main-title">
                            <h3 class="m-0">Agenda Compartilhada</h3>
                        </div>
                    </div>
                </div>
                <div class="white_card_body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if (!$connected)
                    <div class="text-center mb-4">
                        <p>Para visualizar e compartilhar eventos, conecte sua conta do Google Calendar.</p>
                        <a href="{{ route('google.connect') }}" class="btn btn-primary">
                            <i class="fab fa-google"></i> Conectar com Google Calendar
                        </a>
                    </div>
                @else
                    <div class="mb-3 text-end">
                        <a href="{{ route('google.disconnect') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-unlink"></i> Desconectar do Google Calendar
                        </a>
                    </div>

                    @if(isset($events) && count($events) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Evento</th>
                                        <th>Data</th>
                                        <th>Horário</th>
                                        <th>Descrição</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($events as $event)
                                        <tr>
                                            <td>{{ $event->getSummary() }}</td>
                                            <td>
                                                @if($event->start->dateTime)
                                                    {{ \Carbon\Carbon::parse($event->start->dateTime)->format('d/m/Y') }}
                                                @else
                                                    {{ \Carbon\Carbon::parse($event->start->date)->format('d/m/Y') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($event->start->dateTime)
                                                    {{ \Carbon\Carbon::parse($event->start->dateTime)->format('H:i') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($event->end->dateTime)->format('H:i') }}
                                                @else
                                                    Dia todo
                                                @endif
                                            </td>
                                            <td>{{ $event->getDescription() ?? 'Sem descrição' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Nenhum evento encontrado para os próximos dias.
                        </div>
                    @endif
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 