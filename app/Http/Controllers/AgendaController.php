<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Calendar;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $eventos = $user->eventos()->orderBy('data_inicio', 'desc')->get();
        $eventosParticipantes = $user->eventosParticipantes()->orderBy('data_inicio', 'desc')->get();

        return view('agenda.index', compact('eventos', 'eventosParticipantes'));
    }

    public function create()
    {
        return view('agenda.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio',
            'local' => 'nullable|string|max:255',
            'tipo' => 'required|string|max:255',
            'participantes' => 'nullable|array',
            'participantes.*' => 'exists:users,id'
        ]);

        $evento = Evento::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'local' => $request->local,
            'tipo' => $request->tipo,
            'user_id' => auth()->id()
        ]);

        if ($request->has('participantes')) {
            $evento->participantes()->attach($request->participantes);
        }

        // Sincronizar com o Google Calendar
        $this->syncWithGoogleCalendar($evento);

        return redirect()->route('agenda.index')
            ->with('success', 'Evento criado com sucesso!');
    }

    public function show(Evento $evento)
    {
        return view('agenda.show', compact('evento'));
    }

    public function edit(Evento $evento)
    {
        return view('agenda.edit', compact('evento'));
    }

    public function update(Request $request, Evento $evento)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio',
            'local' => 'nullable|string|max:255',
            'tipo' => 'required|string|max:255',
            'participantes' => 'nullable|array',
            'participantes.*' => 'exists:users,id'
        ]);

        $evento->update([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'local' => $request->local,
            'tipo' => $request->tipo
        ]);

        if ($request->has('participantes')) {
            $evento->participantes()->sync($request->participantes);
        }

        // Sincronizar com o Google Calendar
        $this->syncWithGoogleCalendar($evento);

        return redirect()->route('agenda.index')
            ->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy(Evento $evento)
    {
        $evento->delete();

        // Remover do Google Calendar
        $this->removeFromGoogleCalendar($evento);

        return redirect()->route('agenda.index')
            ->with('success', 'Evento removido com sucesso!');
    }

    public function confirmarPresenca(Evento $evento)
    {
        $user = auth()->user();
        $evento->participantes()->updateExistingPivot($user->id, ['confirmado' => true]);

        return redirect()->route('agenda.index')
            ->with('success', 'Presença confirmada com sucesso!');
    }

    private function syncWithGoogleCalendar(Evento $evento)
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-credentials.json'));
        $client->addScope(Google_Service_Calendar::CALENDAR);

        $service = new Google_Service_Calendar($client);

        $googleEvent = new \Google_Service_Calendar_Event([
            'summary' => $evento->titulo,
            'description' => $evento->descricao,
            'start' => [
                'dateTime' => Carbon::parse($evento->data_inicio)->toRfc3339String(),
                'timeZone' => 'America/Sao_Paulo',
            ],
            'end' => [
                'dateTime' => Carbon::parse($evento->data_fim)->toRfc3339String(),
                'timeZone' => 'America/Sao_Paulo',
            ],
            'location' => $evento->local,
        ]);

        try {
            $service->events->insert(config('services.google.calendar_id'), $googleEvent);
        } catch (\Exception $e) {
            \Log::error('Erro ao sincronizar com Google Calendar: ' . $e->getMessage());
        }
    }

    private function removeFromGoogleCalendar(Evento $evento)
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-credentials.json'));
        $client->addScope(Google_Service_Calendar::CALENDAR);

        $service = new Google_Service_Calendar($client);

        try {
            $service->events->delete(config('services.google.calendar_id'), $evento->google_event_id);
        } catch (\Exception $e) {
            \Log::error('Erro ao remover do Google Calendar: ' . $e->getMessage());
        }
    }
} 