<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Information;

class Dashboard extends Component
{
    public $codigo;
    public $events = [];
    public $additionalInfo = null;
    public $destinatario;
    public $telefono;
    public $last_description;

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

    public function saveData()
    {
        // Asegúrate de que los eventos están ordenados por fecha en orden descendente
        usort($this->events, function ($a, $b) {
            return strtotime($b['updated_at']) - strtotime($a['updated_at']);
        });

        // Recupera el evento más reciente
        $latestEvent = $this->events[0] ?? null;

        Information::create([
            'codigo' => $this->codigo,
            'destinatario' => $this->additionalInfo['DESTINATARIO'] ?? null,
            'last_event' => $this->additionalInfo['ESTADO'] ?? null,
            'telefono' => $this->additionalInfo['TELEFONO'] ?? null,
            'ciudad' => $this->additionalInfo['CUIDAD'] ?? null,
            'ventanilla' => $this->additionalInfo['VENTANILLA'] ?? null,
            'last_status' => $latestEvent['action'] ?? null,  // Toma el estado del último evento
            'last_description' => substr($latestEvent['descripcion'] ?? '', 0, 255),  // Toma la descripción del último evento
            'last_date' => isset($latestEvent['updated_at']) ? Carbon::createFromFormat('d/m/Y H:i:s', $latestEvent['updated_at'])->format('Y-m-d H:i:s') : null,
            'estado' => 'SAC',
            'created_at' => Carbon::now(),
        ]);

        session()->flash('message', 'Información guardada exitosamente.');
    }

    public function saveLlamada()
    {
        Information::create([
            'codigo' => strtoupper($this->codigo),
            'destinatario' => strtoupper($this->destinatario),
            'telefono' => $this->telefono,
            'last_description' => strtoupper($this->last_description),
            'estado' => 'LLAMADA',
            'last_event' => 'INFORMACIONES',
            'ciudad' => strtoupper(auth()->user()->city),
            'created_at' => Carbon::now(),
        ]);

        session()->flash('message', 'Llamada registrada exitosamente.');

        // Emitir un evento para cerrar el modal
        $this->dispatch('close-modal');

        // Resetear los campos del formulario
        $this->reset(['codigo', 'destinatario', 'telefono']);
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
