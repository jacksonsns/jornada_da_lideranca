<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

class EventoController extends Controller
{
    protected $googleClient;

    public function __construct()
    {
        $this->googleClient = new Google_Client();
        $this->googleClient->setAuthConfig(storage_path('app/google-calendar/credentials.json'));
        $this->googleClient->addScope(Google_Service_Calendar::CALENDAR);
    }

    public function index()
    {
        $eventos = Evento::with('participantes')->latest()->get();
        return view('eventos.index', compact('eventos'));
    }

    public function create()
    {
        return view('eventos.create');
    }

    public function store(Request $request)
    {
        $validados = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after:data_inicio',
            'local' => 'nullable|string|max:255'
        ]);

        $evento = Evento::create([
            ...$validados,
            'criador_id' => auth()->id()
        ]);

        // Sincroniza com o Google Calendar se o usuário estiver autenticado
        if ($this->googleClient->getAccessToken()) {
            $service = new Google_Service_Calendar($this->googleClient);
            
            $googleEvent = new Google_Service_Calendar_Event([
                'summary' => $validados['titulo'],
                'description' => $validados['descricao'],
                'start' => ['dateTime' => $validados['data_inicio']],
                'end' => ['dateTime' => $validados['data_fim'] ?? $validados['data_inicio']],
                'location' => $validados['local']
            ]);

            $calendarId = 'primary';
            $googleEvent = $service->events->insert($calendarId, $googleEvent);
            
            $evento->update(['google_calendar_id' => $googleEvent->id]);
        }

        return redirect()->route('eventos.index')
            ->with('sucesso', 'Evento criado com sucesso!');
    }

    public function show(Evento $evento)
    {
        return view('eventos.show', compact('evento'));
    }

    public function edit(Evento $evento)
    {
        $this->authorize('update', $evento);
        return view('eventos.edit', compact('evento'));
    }

    public function update(Request $request, Evento $evento)
    {
        $this->authorize('update', $evento);

        $validados = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after:data_inicio',
            'local' => 'nullable|string|max:255'
        ]);

        $evento->update($validados);

        // Atualiza no Google Calendar se existir
        if ($evento->google_calendar_id && $this->googleClient->getAccessToken()) {
            $service = new Google_Service_Calendar($this->googleClient);
            
            $googleEvent = new Google_Service_Calendar_Event([
                'summary' => $validados['titulo'],
                'description' => $validados['descricao'],
                'start' => ['dateTime' => $validados['data_inicio']],
                'end' => ['dateTime' => $validados['data_fim'] ?? $validados['data_inicio']],
                'location' => $validados['local']
            ]);

            $service->events->update('primary', $evento->google_calendar_id, $googleEvent);
        }

        return redirect()->route('eventos.index')
            ->with('sucesso', 'Evento atualizado com sucesso!');
    }

    public function destroy(Evento $evento)
    {
        $this->authorize('delete', $evento);

        // Remove do Google Calendar se existir
        if ($evento->google_calendar_id && $this->googleClient->getAccessToken()) {
            $service = new Google_Service_Calendar($this->googleClient);
            $service->events->delete('primary', $evento->google_calendar_id);
        }

        $evento->delete();

        return redirect()->route('eventos.index')
            ->with('sucesso', 'Evento removido com sucesso!');
    }

    public function confirmarPresenca(Evento $evento)
    {
        $user = auth()->user();
        
        if (!$evento->participantes()->where('user_id', $user->id)->exists()) {
            $evento->participantes()->attach($user->id, [
                'confirmado' => true,
                'data_confirmacao' => now()
            ]);

            return redirect()->back()
                ->with('sucesso', 'Presença confirmada com sucesso!');
        }

        return redirect()->back()
            ->with('erro', 'Você já confirmou presença neste evento.');
    }

    public function cancelarPresenca(Evento $evento)
    {
        $user = auth()->user();
        
        $evento->participantes()->detach($user->id);

        return redirect()->back()
            ->with('sucesso', 'Presença cancelada com sucesso!');
    }

    public function sincronizarGoogleCalendar()
    {
        if (!$this->googleClient->getAccessToken()) {
            return redirect()->route('google.auth');
        }

        $service = new Google_Service_Calendar($this->googleClient);
        
        $eventos = Evento::whereNull('google_calendar_id')->get();

        foreach ($eventos as $evento) {
            $googleEvent = new Google_Service_Calendar_Event([
                'summary' => $evento->titulo,
                'description' => $evento->descricao,
                'start' => ['dateTime' => $evento->data_inicio],
                'end' => ['dateTime' => $evento->data_fim ?? $evento->data_inicio],
                'location' => $evento->local
            ]);

            $googleEvent = $service->events->insert('primary', $googleEvent);
            $evento->update(['google_calendar_id' => $googleEvent->id]);
        }

        return redirect()->route('eventos.index')
            ->with('sucesso', 'Eventos sincronizados com o Google Calendar!');
    }
} 