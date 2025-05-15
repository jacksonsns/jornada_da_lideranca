@extends('layouts.app')

@section('title', 'Agenda')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="white_card card_height_100 mb_30">
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
@endsection 