<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use GuzzleHttp\Client;

class Dashboard extends Component
{
    public $codigo;
    public $events = [];
    public $additionalInfo = null;  // Nueva variable para la información adicional

    public function search()
    {
        // Primera API: Autenticación y obtención del token JWT
        $client = new Client(['base_uri' => 'http://172.65.10.37/']);
        $response = $client->post('api/Autenticacion/Validar', [
            'json' => [
                'correo' => 'Correos',
                'clave' => 'AGBClp2020'
            ]
        ]);
        $body = json_decode($response->getBody());
        $token = $body->token;

        // Primera API: Buscar eventos con el código
        $response = $client->post('api/O_MAIL_OBJECTS/buscar', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ],
            'json' => [
                'id' => $this->codigo
            ]
        ]);

        $firstApiEvents = [];
        if ($response->getStatusCode() === 200) {
            $results = json_decode($response->getBody(), true);

            // Ordenar y formatear los resultados
            usort($results, function ($a, $b) {
                return strtotime($b['eventDate']) - strtotime($a['eventDate']);
            });

            $firstApiEvents = collect($results)->map(function ($event) {
                return [
                    'action' => $event['eventType'],
                    'descripcion' => $event['office'] . ' - ' . $event['scanned'],
                    'updated_at' => Carbon::parse($event['eventDate'])->format('d/m/Y H:i:s')
                ];
            })->toArray();
        }

        // Segunda API: Buscar eventos con el código (repetidos)
        $response = Http::withHeaders([
            'Authorization' => 'Bearer eZMlItx6mQMNZjxoijEvf7K3pYvGGXMvEHmQcqvtlAPOEAPgyKDVOpyF7JP0ilbK'
        ])->withOptions(['verify' => false])->get("https://correos.gob.bo:8000/api/events/repeated-codes/{$this->codigo}");

        $secondApiEvents = [];
        if ($response->successful()) {
            $secondApiEvents = collect($response->json())->map(function ($event) {
                return [
                    'action' => $event['action'],
                    'descripcion' => $event['descripcion'],
                    'updated_at' => Carbon::parse($event['updated_at'])->format('d/m/Y H:i:s')
                ];
            })->toArray();
        }

        // Tercera API: Obtener la información adicional
        $additionalResponse = Http::withHeaders([
            'Authorization' => 'Bearer eZMlItx6mQMNZjxoijEvf7K3pYvGGXMvEHmQcqvtlAPOEAPgyKDVOpyF7JP0ilbK'
        ])->withOptions(['verify' => false])->get("https://correos.gob.bo:8000/api/prueba/{$this->codigo}");

        if ($additionalResponse->successful()) {
            $this->additionalInfo = $additionalResponse->json();
        } else {
            $this->additionalInfo = null;  // Si no se puede obtener la información
        }

        // Combinamos los resultados de ambas APIs
        $this->events = array_merge($firstApiEvents, $secondApiEvents);

        // Ordenamos todos los eventos por fecha descendente
        usort($this->events, function ($a, $b) {
            return strtotime($b['updated_at']) - strtotime($a['updated_at']);
        });
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
