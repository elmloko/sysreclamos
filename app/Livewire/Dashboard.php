<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Information;
use PDF;
use App\Models\Claim;
use App\Models\Complaint;

class Dashboard extends Component
{
    public $codigo;
    public $events = [];
    public $additionalInfo = null;
    public $destinatario;
    public $telefono;
    public $last_description;
    public $feedback;
    public $view;
    public $remitente;
    public $telf_remitente;
    public $email_r;
    public $origen;
    public $telf_destinatario;
    public $email_d;
    public $direccion_d;
    public $codigo_postal;
    public $destino;
    public $fecha_envio;
    public $contenido;
    public $valor;
    public $cliente;
    public $telf;
    public $ci;
    public $email;
    public $queja;
    public $funcionario;

    public function mount($view = 'dashboard')
    {
        $this->view = $view;
    }

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

        // Emitir un evento para cerrar el modal
        $this->dispatch('close-modal');
        $this->dispatch('open-calificando-modal');

        // Resetear los campos del formulario
        $this->reset(['codigo', 'destinatario', 'telefono']);
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

    public function savesac()
    {
        Information::create([
            'codigo' => strtoupper($this->codigo),
            'destinatario' => strtoupper($this->destinatario),
            'telefono' => $this->telefono,
            'last_description' => strtoupper($this->last_description),
            'estado' => 'SAC MANUAL',
            'last_event' => 'INFORMACIONES',
            'ciudad' => strtoupper(auth()->user()->city),
            'created_at' => Carbon::now(),
        ]);

        session()->flash('message', 'Registro SAC registrada exitosamente.');

        // Emitir un evento para cerrar el modal
        $this->dispatch('close-modal');
        $this->dispatch('open-calificando-modal');

        // Resetear los campos del formulario
        $this->reset(['codigo', 'destinatario', 'telefono']);
    }

    public function savecn()
    {
        $this->validate([
            'remitente' => 'required|string|max:255',
            'telf_remitente' => 'required|numeric',
            'email_r' => 'required|email|max:255',
            'origen' => 'required|string|max:255',
            'destinatario' => 'required|string|max:255',
            'telf_destinatario' => 'required|numeric',
            'email_d' => 'required|email|max:255',
            'direccion_d' => 'required|string|max:255',
            'codigo_postal' => 'required|numeric',
            'destino' => 'required|string|max:255',
            'codigo' => 'required|string|max:255',
            'fecha_envio' => 'required|date',
            'contenido' => 'required|string|max:255',
            'valor' => 'required|numeric',
        ]);

        $claim = Claim::create([
            'remitente' => strtoupper($this->remitente),
            'telf_remitente' => $this->telf_remitente,
            'email_r' => $this->email_r,
            'origen' => strtoupper($this->origen),
            'destinatario' => strtoupper($this->destinatario),
            'telf_destinatario' => $this->telf_destinatario,
            'email_d' => $this->email_d,
            'direccion_d' => strtoupper($this->direccion_d),
            'codigo_postal' => $this->codigo_postal,
            'destino' => strtoupper($this->destino),
            'codigo' => $this->codigo,
            'fecha_envio' => Carbon::parse($this->fecha_envio),
            'contenido' => strtoupper($this->contenido),
            'valor' => $this->valor,
            'estado' => 'INFORMACIONES',
            'created_at' => Carbon::now(),
        ]);

        session()->flash('message', 'Registro CN08 registrada exitosamente.');

        // Emitir un evento para cerrar el modal
        $this->dispatch('close-modal');

        // Resetear los campos del formulario
        $this->reset(['remitente', 'telf_remitente', 'email_r', 'origen', 'destinatario', 'telf_destinatario', 'email_d', 'direccion_d', 'codigo_postal', 'destino', 'codigo', 'fecha_envio', 'contenido', 'valor']);

        $pdf = PDF::loadView('livewire.pdf-form', compact('claim'));

        // Utiliza streamDownload para transmitir el PDF al navegador
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Formulario Reclamo.pdf');
    }

    public function saveqa()
    {
        $this->validate([
            'cliente' => 'required|string|max:255',
            'telf' => 'required|numeric',
            'ci' => 'required|numeric',
            'email' => 'required|email|max:255',
            'queja' => 'required|string|max:255',
            'funcionario' => 'required|string|max:255',
        ]);

        $complaint = Complaint::create([
            'cliente' => strtoupper($this->cliente),
            'telf' => $this->telf,
            'email' => $this->email,
            'ci' => $this->ci,
            'queja' => strtoupper($this->queja),
            'funcionario' => strtoupper($this->funcionario),
            'estado' => 'RECEPCIONADO',
            'tipo' => 'ADMINISTRATIVO',
            'created_at' => Carbon::now(),
        ]);

        session()->flash('message', 'Registro Queja Administrativa registrada exitosamente.');

        // Emitir un evento para cerrar el modal
        $this->dispatch('close-modal');

        // Resetear los campos del formulario
        $this->reset(['cliente', 'telf', 'email', 'queja', 'funcionario']);

        $pdf = PDF::loadView('livewire.pdf-formqa', compact('complaint'));

        // Utiliza streamDownload para transmitir el PDF al navegador
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Formulario Queja Administrativa.pdf');
    }

    public function saveqo()
    {
        $this->validate([
            'cliente' => 'required|string|max:255',
            'telf' => 'required|numeric',
            'ci' => 'required|numeric',
            'email' => 'required|email|max:255',
            'queja' => 'required|string',
            'funcionario' => 'required|string|max:255',
        ]);

        $complaint = Complaint::create([
            'cliente' => strtoupper($this->cliente),
            'telf' => $this->telf,
            'email' => $this->email,
            'ci' => $this->ci,
            'queja' => strtoupper($this->queja),
            'funcionario' => strtoupper($this->funcionario),
            'estado' => 'RECEPCIONADO',
            'tipo' => 'OPERATIVO',
            'created_at' => Carbon::now(),
        ]);

        session()->flash('message', 'Registro Queja Operativa registrada exitosamente.');

        // Emitir un evento para cerrar el modal
        $this->dispatch('close-modal');

        // Resetear los campos del formulario
        $this->reset(['cliente', 'telf', 'email', 'queja', 'funcionario']);

        $pdf = PDF::loadView('livewire.pdf-formqo', compact('complaint'));

        // Utiliza streamDownload para transmitir el PDF al navegador
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Formulario Queja Operativa.pdf');
    }

    public function render()
    {
        if ($this->view === 'feedback') {
            return view('livewire.feedback');
        }

        return view('livewire.dashboard');
    }
}
