<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GoogleCalendarController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        $this->client->setRedirectUri(config('services.google.redirect_uri'));
        $this->client->addScope(Calendar::CALENDAR);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('consent');
    }

    public function connect()
    {
        $authUrl = $this->client->createAuthUrl();
        return redirect($authUrl);
    }

    public function callback(Request $request)
    {
        if ($request->has('code')) {
            $token = $this->client->fetchAccessTokenWithAuthCode($request->code);
            
            if (!isset($token['error'])) {
                $user = Auth::user();
                $user->google_access_token = json_encode($token);
                $user->save();
                
                return redirect()->route('agenda.index')->with('success', 'Conectado com sucesso ao Google Calendar!');
            }
        }
        
        return redirect()->route('agenda.index')->with('error', 'Erro ao conectar com o Google Calendar.');
    }

    public function index()
    {
        $user = Auth::user();
        
        if (!$user->google_access_token) {
            return view('agenda.index', ['connected' => false]);
        }

        try {
            $this->client->setAccessToken($user->google_access_token);
            
            if ($this->client->isAccessTokenExpired()) {
                if ($this->client->getRefreshToken()) {
                    $token = $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                    $user->google_access_token = json_encode($token);
                    $user->save();
                } else {
                    return view('agenda.index', ['connected' => false]);
                }
            }

            $service = new Calendar($this->client);
            $calendarId = 'primary';
            $optParams = [
                'maxResults' => 10,
                'orderBy' => 'startTime',
                'singleEvents' => true,
                'timeMin' => date('c'),
            ];

            $results = $service->events->listEvents($calendarId, $optParams);
            $events = $results->getItems();

            return view('agenda.index', [
                'connected' => true,
                'events' => $events
            ]);

        } catch (\Exception $e) {
            return view('agenda.index', [
                'connected' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function disconnect()
    {
        $user = Auth::user();
        $user->google_access_token = null;
        $user->save();
        
        return redirect()->route('agenda.index')->with('success', 'Desconectado do Google Calendar com sucesso!');
    }
} 