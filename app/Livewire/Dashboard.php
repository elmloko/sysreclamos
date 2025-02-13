<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Information;
use PDF;
use App\Models\Claim;
use App\Models\Event;
use App\Models\Suggestion;
use App\Models\Complaint;

class Dashboard extends Component
{
    public $codigo;
    public $events = [];
    public $additionalInfo = null;
    public $destinatario;
    public $telefono;
    public $last_description;
    public $last_status;
    public $feedback;
    public $view;
    public $remitente;
    public $telf_remitente;
    public $email_r;
    public $origen;
    public $telf_destinatario;
    public $reclamo;
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
    public $tipo_envio;
    public $email;
    public $queja;
    public $funcionario;
    public $someCondition;
    public $createdId;
    public $denuncianteci;
    public $denunciante;
    public $denunciantetelf;
    public $denuncianteemail;
    public $suggestionsCountToday;
    public $claimsCountToday;
    public $complaintsCountTodayadm;
    public $complaintsCountTodayop;
    public $informationCountToday;
    public $claimsCount;
    public $claimsCountlocal;
    public $claimsCountinter;
    public $claimsCountnat;

    public function mount($view = 'dashboard')
    {
        $this->view = $view;
        $this->loadStatistics();
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

        // Obtener la descripción más reciente
        $this->last_status = substr(($latestEvent['action'] ?? ''), 0, 255);

        // Obtener el último registro de Information con el estado "SAC MANUAL" para determinar el siguiente número correlativo
        $lastRecord = Information::where('estado', 'SAC MANUAL')
            ->where('correlativo', 'LIKE', 'INFSAM%')
            ->orderBy('id', 'desc')
            ->first();

        // Si existe un registro anterior, incrementar el número correlativo, de lo contrario, comenzar en 1
        if ($lastRecord) {
            $lastCorrelativo = intval(substr($lastRecord->correlativo, 6));
            $newCorrelativo = str_pad($lastCorrelativo + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newCorrelativo = '0001';
        }

        // Crear el nuevo código correlativo
        $codigoCorrelativo = 'INFSAM' . $newCorrelativo;
        $publicoCorrelativo = 'T' . $newCorrelativo;

        // Crear el nuevo registro en la base de datos
        $information = Information::create([
            'codigo' => $this->codigo,
            'destinatario' => $this->additionalInfo['DESTINATARIO'] ?? null,
            'last_event' => $this->additionalInfo['ESTADO'] ?? null,
            'telefono' => $this->additionalInfo['TELEFONO'] ?? null,
            'ciudad' => $this->additionalInfo['CUIDAD'] ?? null,
            'ventanilla' => $this->additionalInfo['VENTANILLA'] ?? null,
            'last_status' => $this->last_status,
            'last_description' => $this->last_description, // Aquí se guarda la descripción ingresada
            'last_date' => isset($latestEvent['updated_at']) ? Carbon::createFromFormat('d/m/Y H:i:s', $latestEvent['updated_at'])->format('Y-m-d H:i:s') : null,
            'correlativo' => $codigoCorrelativo,
            'public' => $publicoCorrelativo,
            'estado' => 'SAC AUTOMATICO',
            'created_at' => Carbon::now(),
        ]);

        Event::create([
            'action' => 'INFORMACIONES',
            'descripcion' => 'Consulta SAC Automático',
            'user_id' => auth()->user()->name,
            'codigo' => $information->correlativo,
        ]);

        $this->createdId = $information->public;

        session()->flash('message', 'Información guardada exitosamente.');

        // Resetear los campos del formulario
        $this->reset(['codigo', 'destinatario', 'telefono', 'last_description']);

        // Emitir un evento para cerrar el modal y abrir el modal de calificación
        $this->dispatch('close-modal');
        $this->dispatch('open-calificando-modal');
    }

    public function savesac()
    {
        // Obtener el último registro de Information con el estado "SAC MANUAL" para determinar el siguiente número correlativo
        $lastRecord = Information::where('estado', 'SAC MANUAL')->orderBy('id', 'desc')->first();

        // Si existe un registro anterior, incrementar el número correlativo, de lo contrario, comenzar en 1
        if ($lastRecord && strpos($lastRecord->correlativo, 'INFSAC') === 0) {
            $lastCorrelativo = intval(substr($lastRecord->correlativo, 6)); // Extraer la parte numérica después de 'INFSAC'
            $newCorrelativo = str_pad($lastCorrelativo + 1, 4, '0', STR_PAD_LEFT); // Incrementar y rellenar con ceros
        } else {
            $newCorrelativo = '0001';
        }

        // Crear el nuevo código correlativo
        $codigoCorrelativo = 'INFSAC' . $newCorrelativo;
        $publicoCorrelativo = 'W' . $newCorrelativo;

        // Crear el nuevo registro en la base de datos
        $information = Information::create([
            'correlativo' => $codigoCorrelativo,
            'public' => $publicoCorrelativo,
            'codigo' => strtoupper($this->codigo),
            'destinatario' => strtoupper($this->destinatario),
            'telefono' => $this->telefono,
            'last_description' => strtoupper($this->last_description),
            'estado' => 'SAC MANUAL',
            'last_event' => 'INFORMACIONES',
            'ciudad' => strtoupper(auth()->user()->city),
            'created_at' => Carbon::now(),
        ]);

        Event::create([
            'action' => 'INFORMACIONES',
            'descripcion' => 'Consulta SAC Manual',
            'user_id' => auth()->user()->name,
            'codigo' => $information->correlativo,
        ]);

        // Almacenar el ID del registro recién creado
        $this->createdId = $information->public;

        session()->flash('message', 'Registro SAC registrado exitosamente.');

        // Resetear los campos del formulario
        $this->reset(['codigo', 'destinatario', 'telefono', 'last_description']);

        // Emitir un evento para cerrar el modal y abrir el modal de calificación
        $this->dispatch('close-modal');
        $this->dispatch('open-calificando-modal');
    }

    public function saveLlamada()
    {
        // Obtener el último registro de Information con el estado 'LLAMADA' para determinar el siguiente número correlativo
        $lastRecord = Information::where('estado', 'LLAMADA')->orderBy('id', 'desc')->first();

        // Si existe un registro anterior, incrementar el número correlativo, de lo contrario, comenzar en 1
        if ($lastRecord && strpos($lastRecord->correlativo, 'INFLL') === 0) {
            $lastCorrelativo = intval(substr($lastRecord->correlativo, 5)); // Extraer la parte numérica después de 'INFLL'
            $newCorrelativo = str_pad($lastCorrelativo + 1, 4, '0', STR_PAD_LEFT); // Incrementar y rellenar con ceros
        } else {
            $newCorrelativo = '0001';
        }

        // Crear el nuevo código correlativo
        $codigoCorrelativo = 'INFLL' . $newCorrelativo;

        // Crear el nuevo registro de Information
        $information = Information::create([
            'codigo' => strtoupper($this->codigo),
            'destinatario' => strtoupper($this->destinatario),
            'telefono' => $this->telefono,
            'last_description' => strtoupper($this->last_description),
            'estado' => 'LLAMADA',
            'last_event' => 'INFORMACIONES',
            'ciudad' => strtoupper(auth()->user()->city),
            'correlativo' => $codigoCorrelativo, // Guardar el código correlativo generado
            'created_at' => Carbon::now(),
        ]);

        // Crear el evento relacionado
        Event::create([
            'action' => 'INFORMACIONES',
            'descripcion' => 'Consulta SAC Llamada',
            'user_id' => auth()->user()->name,
            'codigo' => $information->correlativo, // Usar el correlativo recién creado
        ]);

        // Mensaje de éxito
        session()->flash('message', 'Llamada registrada exitosamente.');

        // Emitir un evento para cerrar el modal
        $this->dispatch('close-modal');

        // Resetear los campos del formulario
        $this->reset(['codigo', 'destinatario', 'telefono']);

        // Redirigir a la misma página para recargarla
        return redirect()->to(url()->previous());
    }

    public function savecn()
    {
        $this->validate([
            'remitente' => 'required|string|max:255',
            'telf_remitente' => 'required|numeric',
            'email_r' => 'nullable|email|max:255',
            'origen' => 'required|string|max:255',
            'destinatario' => 'required|string|max:255',
            'telf_destinatario' => 'nullable|numeric',
            'email_d' => 'nullable|email|max:255',
            'direccion_d' => 'required|string|max:255',
            'codigo_postal' => 'nullable|numeric',
            'destino' => 'required|string|max:255',
            'codigo' => 'required|string|max:255',
            'fecha_envio' => 'required|date',
            'contenido' => 'required|string|max:255',
            'reclamo' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'denunciante' => 'required|string|max:255',
            'denuncianteci' => 'required|numeric',
            'denuncianteemail' => 'nullable|email|max:255',
            'denunciantetelf' => 'required|numeric',
            'tipo_envio' => 'required|string|in:LOCAL,NACIONAL,INTERNACIONAL',
        ]);

        // Obtener el último registro de Claim para determinar el siguiente número correlativo
        $lastRecord = Claim::orderBy('id', 'desc')->first();

        // Si existe un registro anterior, incrementar el número correlativo, de lo contrario, comenzar en 1
        if ($lastRecord) {
            $lastCorrelativo = intval(substr($lastRecord->correlativo, 5)); // Extraer la parte numérica (suponiendo un prefijo de 5 caracteres)
            $newCorrelativo = str_pad($lastCorrelativo + 1, 4, '0', STR_PAD_LEFT); // Incrementar y rellenar con ceros
        } else {
            $newCorrelativo = '0001';
        }

        // Crear el nuevo código correlativo
        $codigoCorrelativo = 'RCL' . $newCorrelativo;
        $publicoCorrelativo = 'P' . $newCorrelativo;

        $claim = Claim::create([
            'public' => $publicoCorrelativo,
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
            'codigo' => strtoupper($this->codigo),
            'fecha_envio' => Carbon::parse($this->fecha_envio),
            'contenido' => strtoupper($this->contenido),
            'reclamo' => strtoupper($this->reclamo),
            'valor' => $this->valor,
            'correlativo' => $codigoCorrelativo,
            'ciudad' => strtoupper(auth()->user()->city),
            'estado' => 'INFORMACIONES',
            'denunciante' => strtoupper($this->denunciante),
            'denuncianteci' => strtoupper($this->denuncianteci),
            'denunciantetelf' => $this->denunciantetelf,
            'denuncianteemail' => $this->denuncianteemail,
            'tipo_envio' => $this->tipo_envio,
            'created_at' => Carbon::now(),
        ]);

        Event::create([
            'action' => 'RECLAMO',
            'descripcion' => 'Registro Reclamo por Ventanilla',
            'user_id' => auth()->user()->name,
            'codigo' => $claim->codigoCorrelativo, // Usar el correlativo recién creado
        ]);

        // Almacenar el ID del registro recién creado
        $this->createdId = $claim->public;

        session()->flash('message', 'Registro CN08 registrado exitosamente.');

        // Emitir un evento para cerrar el modal y abrir el modal de calificación
        $this->dispatch('close-modal');
        $this->dispatch('open-calificando-modal');

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
            'ci' => 'numeric',
            'email' => 'email|max:255',
            'queja' => 'required|string|max:255',
            'funcionario' => 'required|string|max:255',
        ]);

        // Obtener el último registro de Complaint con el tipo "ADMINISTRATIVO" para determinar el siguiente número correlativo
        $lastRecord = Complaint::where('tipo', 'ADMINISTRATIVO')->orderBy('id', 'desc')->first();

        // Si existe un registro anterior, incrementar el número correlativo, de lo contrario, comenzar en 1
        if ($lastRecord) {
            $lastCorrelativo = intval(substr($lastRecord->correlativo, 6)); // Extraer la parte numérica
            $newCorrelativo = str_pad($lastCorrelativo + 1, 4, '0', STR_PAD_LEFT); // Incrementar y rellenar con ceros
        } else {
            $newCorrelativo = '0001';
        }

        // Crear el nuevo código correlativo
        $codigoCorrelativo = 'QJAADM' . $newCorrelativo;
        $publicoCorrelativo = 'F' . $newCorrelativo;

        // Guardar la queja en la base de datos
        $complaint = Complaint::create([
            'public' => $publicoCorrelativo,
            'cliente' => strtoupper($this->cliente),
            'telf' => $this->telf,
            'email' => $this->email,
            'ci' => $this->ci,
            'queja' => strtoupper($this->queja),
            'funcionario' => strtoupper($this->funcionario),
            'estado' => 'RECEPCIONADO',
            'tipo' => 'ADMINISTRATIVO',
            'ciudad' => strtoupper(auth()->user()->city),
            'correlativo' => $codigoCorrelativo, // Guardar el código correlativo generado
            'created_at' => Carbon::now(),
        ]);

        Event::create([
            'action' => 'QUEJA',
            'descripcion' => 'Registro Queja Administrativa por Ventanilla',
            'user_id' => auth()->user()->name,
            'codigo' => $complaint->correlativo, // Usar el correlativo recién creado
        ]);

        // Almacenar el ID del registro recién creado
        $this->createdId = $complaint->public;

        session()->flash('message', 'Registro Queja Administrativa registrada exitosamente.');

        // Emitir un evento para cerrar el modal y abrir el modal de calificación
        $this->dispatch('close-modal');
        $this->dispatch('open-calificando-modal');

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
            'ci' => 'numeric',
            'email' => 'email|max:255',
            'queja' => 'required|string',
            'funcionario' => 'required|string|max:255',
        ]);

        // Obtener el último registro de Complaint con el tipo "OPERATIVO" para determinar el siguiente número correlativo
        $lastRecord = Complaint::where('tipo', 'OPERATIVO')->orderBy('id', 'desc')->first();

        // Si existe un registro anterior, incrementar el número correlativo, de lo contrario, comenzar en 1
        if ($lastRecord) {
            $lastCorrelativo = intval(substr($lastRecord->correlativo, 5)); // Extraer la parte numérica
            $newCorrelativo = str_pad($lastCorrelativo + 1, 4, '0', STR_PAD_LEFT); // Incrementar y rellenar con ceros
        } else {
            $newCorrelativo = '0001';
        }

        // Crear el nuevo código correlativo
        $codigoCorrelativo = 'QJAOP' . $newCorrelativo;
        $publicoCorrelativo = 'G' . $newCorrelativo;

        $complaint = Complaint::create([
            'public' => $publicoCorrelativo,
            'cliente' => strtoupper($this->cliente),
            'telf' => $this->telf,
            'email' => $this->email,
            'ci' => $this->ci,
            'queja' => strtoupper($this->queja),
            'funcionario' => strtoupper($this->funcionario),
            'correlativo' => $codigoCorrelativo,
            'ciudad' => strtoupper(auth()->user()->city),
            'estado' => 'RECEPCIONADO',
            'tipo' => 'OPERATIVO',
            'created_at' => Carbon::now(),
        ]);

        Event::create([
            'action' => 'QUEJA',
            'descripcion' => 'Registro Queja Operativa por Ventanilla',
            'user_id' => auth()->user()->name,
            'codigo' => $complaint->correlativo, // Usar el correlativo recién creado
        ]);

        // Almacenar el ID del registro recién creado
        $this->createdId = $complaint->public;

        session()->flash('message', 'Registro Queja Operativa registrada exitosamente.');

        // Emitir un evento para cerrar el modal y abrir el modal de calificación
        $this->dispatch('close-modal');
        $this->dispatch('open-calificando-modal');

        // Resetear los campos del formulario
        $this->reset(['cliente', 'telf', 'email', 'queja', 'funcionario']);

        $pdf = PDF::loadView('livewire.pdf-formqo', compact('complaint'));

        // Utiliza streamDownload para transmitir el PDF al navegador
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Formulario Queja Operativa.pdf');
    }

    protected function loadStatistics()
    {
        $this->suggestionsCountToday = Suggestion::whereDate('created_at', Carbon::today())->count();
        $this->claimsCountToday = Claim::whereDate('created_at', Carbon::today())->count();
        $this->complaintsCountTodayop = Complaint::where('tipo', 'OPERATIVO')
            ->whereDate('created_at', Carbon::today())
            ->count();
        $this->complaintsCountTodayadm = Complaint::where('tipo', 'ADMINISTRATIVO')
            ->whereDate('created_at', Carbon::today())
            ->count();
        $this->informationCountToday = Information::whereDate('created_at', Carbon::today())->count();
        $this->claimsCount = Claim::where('estado', 'INFORMACIONES')->count();
        $this->claimsCountlocal = Claim::where('tipo_envio', 'LOCAL')
            ->whereBetween('created_at', [Carbon::now()->subHours(24), Carbon::now()->subHours(12)])
            ->count();
        $this->claimsCountinter = Claim::where('tipo_envio', 'INTERNACIONAL')
            ->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()->subDays(5)])
            ->count();
        $this->claimsCountnat = Claim::where('tipo_envio', 'NACIONAL')
            ->whereBetween('created_at', [Carbon::now()->subDays(10), Carbon::now()->subDays(15)])
            ->count();
    }

    public function render()
    {
        if ($this->view === 'feedback') {
            return view('livewire.feedback');
        }

        if (auth()->user()->hasAnyRole(['SuperAdmin', 'Reclamos', 'Informaciones', 'Administrador']) && $this->suggestionsCountToday > 0) {
            toastr()->warning("TIENES NUEVA SUGERENCIA EN EL LIBRO DE SUGERENCIAS :{$this->suggestionsCountToday} CASOS PARA VER");
        }
        if (auth()->user()->hasAnyRole(['SuperAdmin', 'Administrador']) && $this->complaintsCountTodayadm > 0) {
            toastr()->warning("SE PRESENTARON NUEVAS QUEJAS ADMINISTRATIVAS:{$this->complaintsCountTodayadm} CASOS PARA VER");
        }
        if (auth()->user()->hasAnyRole(['SuperAdmin', 'Administrador']) && $this->complaintsCountTodayop > 0) {
            toastr()->warning("SE PRESENTARON NUEVAS QUEJAS OPERATIVAS:{$this->complaintsCountTodayop} CASOS PARA VER");
        }
        if (auth()->user()->hasAnyRole(['SuperAdmin', 'Reclamos', 'Administrador']) && $this->claimsCountToday > 0) {
            toastr()->warning("LLEGO UN NUEVO RECLAMO:{$this->claimsCountToday} CASOS PARA VER");
        }
        if (auth()->user()->hasAnyRole(['SuperAdmin', 'Reclamos', 'Administrador']) && $this->claimsCount > 0) {
            toastr()->success("HAY RECLAMOS PENDIENTES A SER RECIBIDOS:{$this->claimsCount} CASOS PARA VER");
        }
        if (auth()->user()->hasAnyRole(['SuperAdmin', 'Reclamos', 'Administrador']) && $this->claimsCountlocal > 0) {
            toastr()->error("HAY RECLAMOS LOCALES PENDIENTES VENCERAN PRONTO:{$this->claimsCountlocal} CASOS PARA VER");
        }
        if (auth()->user()->hasAnyRole(['SuperAdmin', 'Reclamos', 'Administrador']) && $this->claimsCountinter > 0) {
            toastr()->error("HAY RECLAMOS INTERNACIONALES PENDIENTES VENCERAN PRONTO:{$this->claimsCountinter} CASOS PARA VER");
        }
        if (auth()->user()->hasAnyRole(['SuperAdmin', 'Reclamos', 'Administrador']) && $this->claimsCountnat > 0) {
            toastr()->error("HAY RECLAMOS NACIONALES PENDIENTES VENCERAN PRONTO:{$this->claimsCountnat} CASOS PARA VER");
        }
        if (auth()->user()->hasAnyRole(['SuperAdmin', 'Administrador']) && $this->informationCountToday > 0) {
            toastr()->warning("SE GENERARON NUEVAS CONSULTAS EN INFORMACIONES :{$this->informationCountToday} CASOS PARA VER");
        }
        return view('livewire.dashboard');
    }
}
