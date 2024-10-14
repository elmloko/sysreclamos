<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Claim;
use App\Models\Event;
use Carbon\Carbon;
use PDF;

class Seguimientoreclamos extends Component
{
    use WithPagination;

    // Propiedades del formulario de reclamo
    public $remitente, $telf_remitente, $email_r, $origen, $contenido, $valor, $fecha_envio;
    public $destinatario, $telf_destinatario, $email_d, $destino, $direccion_d, $codigo_postal, $codigo, $reclamo, $denunciante, $denuncianteci,$denuncianteemail,$denunciantetelf;

    public $perPage = 10;
    public $selectedDate;
    public $selectedClaims = [];
    public $selectAll = false;
    public $searchTerm;
    public $tipo_reclamo;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        Carbon::setLocale('es');

        // Obtener la ciudad del usuario autenticado
        $userCity = auth()->user()->city;

        // Filtrar los registros según el rol del usuario
        $claims = Claim::where('estado', 'RECLAMOS')
            ->when(auth()->user()->hasRole('Reclamos'), function ($query) use ($userCity) {
                return $query->where('ciudad', $userCity);
            })
            ->when($this->selectedDate, function ($query) {
                return $query->whereDate('updated_at', $this->selectedDate);
            })
            ->when($this->searchTerm, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('codigo', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('remitente', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('telf_remitente', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('correlativo', 'like', '%' . $this->searchTerm . '%');
                });
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($this->perPage);

        // Calcular los días de diferencia y asignar colores
        foreach ($claims as $claim) {
            $daysDifference = Carbon::parse($claim->fecha_envio)->diffInDays(Carbon::now());
            if ($daysDifference >= 0 && $daysDifference <= 4) {
                $claim->color = 'green';
            } elseif ($daysDifference >= 5 && $daysDifference <= 9) {
                $claim->color = 'yellow';
            } elseif ($daysDifference >= 10 && $daysDifference <= 14) {
                $claim->color = 'orange';
            } else {
                $claim->color = 'red';
            }
            $claim->days_difference = $daysDifference;
        }

        return view('livewire.seguimientoreclamos', ['claims' => $claims]);
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
            'tipo_reclamo' => 'required|in:ENTRADA,SALIDA',
            'denunciante' => 'required|string|max:255',
            'denuncianteci' => 'required|numeric',
            'denuncianteemail' => 'nullable|email|max:255',
            'denunciantetelf' => 'required|numeric',
        ]);

        // Obtener el último registro de Claim para determinar el siguiente número correlativo
        $lastRecord = Claim::orderBy('id', 'desc')->first();

        // Si existe un registro anterior, incrementar el número correlativo, de lo contrario, comenzar en 1
        if ($lastRecord) {
            $lastCorrelativo = intval(substr($lastRecord->correlativo, 3)); // Extraer la parte numérica después del prefijo
            $newCorrelativo = str_pad($lastCorrelativo + 1, 4, '0', STR_PAD_LEFT); // Incrementar y rellenar con ceros
        } else {
            $newCorrelativo = '0001';
        }

        // Crear el nuevo código correlativo
        $codigoCorrelativo = 'RCL' . $newCorrelativo; // RCL para Reclamo
        $publicoCorrelativo = 'P' . $newCorrelativo; // P para el correlativo público

        // Crear el nuevo reclamo
        $claim = Claim::create([
            'tipo_reclamo' => $this->tipo_reclamo,
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
            'estado' => 'RECLAMOS',
            'denunciante' => strtoupper($this->denunciante),
            'denuncianteci' => strtoupper($this->denuncianteci),
            'denunciantetelf' => $this->denunciantetelf,
            'denuncianteemail' => $this->denuncianteemail,
            'ciudad' => auth()->user()->city,
            'created_at' => Carbon::now(),
        ]);

        Event::create([
            'action' => 'RECLAMO',
            'descripcion' => 'Registro Reclamo por Área de Reclamos',
            'user_id' => auth()->user()->name,
            'codigo' => $claim->codigoCorrelativo, // Usar el correlativo recién creado
        ]);
        // Almacenar el ID del registro recién creado
        $this->createdId = $claim->public;

        // Mensaje de éxito
        session()->flash('message', 'Registro CN08 registrado exitosamente.');

        // Emitir eventos para cerrar el modal
        $this->dispatch('close-modal');

        // Llamar a resetForm para resetear los campos del formulario
        $this->resetForm();
    }

    public function exportPdf()
    {
        // Obtener la ciudad del usuario autenticado
        $userCity = auth()->user()->city;

        // Filtrar los registros según el rol del usuario utilizando Spatie
        $claims = Claim::where('estado', 'RECLAMOS')
            ->when(auth()->user()->hasRole('Reclamos'), function ($query) use ($userCity) {
                // Aplicar filtro de ciudad solo si el usuario tiene el rol de Reclamos
                return $query->where('ciudad', $userCity);
            })
            ->when($this->selectedDate, function ($query) {
                return $query->whereDate('updated_at', $this->selectedDate);
            })
            ->get();

        $pdf = PDF::loadView('livewire.pdf-bandeja', compact('claims'));

        Event::create([
            'action' => 'REPORTE',
            'descripcion' => 'Generar Reporte para Seguimiento de Reclamos',
            'user_id' => auth()->user()->name,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Reclamos' . ($this->selectedDate ?? 'all') . '.pdf');
    }

    // Resetear el formulario
    public function resetForm()
    {
        $this->reset([
            'remitente',
            'telf_remitente',
            'email_r',
            'origen',
            'contenido',
            'valor',
            'fecha_envio',
            'destinatario',
            'telf_destinatario',
            'email_d',
            'destino',
            'direccion_d',
            'codigo_postal',
            'codigo',
            'reclamo'
        ]);
    }
    public function mostrarReclamo($claimId)
    {
        // Redirigir a la ruta claim.show con el ID del reclamo
        return redirect()->to(route('reclamos.show', $claimId));
    }
    public function darDeBaja($claimId)
    {
        $claim = Claim::find($claimId);

        if ($claim) {
            $claim->update([
                'deleted_at' => now(),
                'estado' => 'RESUELTO'
            ]);
            Event::create([
                'action' => 'RESUELTO',
                'descripcion' => 'Reclamo Cerrado.',
                'user_id' => auth()->user()->name,
                'codigo' => $claim->correlativo,
            ]);
            session()->flash('message', 'Reclamo dado de baja y marcado como resuelto con éxito.');
        } else {
            session()->flash('error', 'No se pudo dar de baja el reclamo.');
        }
    }
}
