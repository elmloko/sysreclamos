<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Claim;
use App\Models\Event;
use PDF;

class Bandejareclamos extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $selectedDate;
    public $selectedClaims = [];
    public $selectAll = false;
    public $searchTerm;
    public $tipoReclamo; // Nueva propiedad para almacenar el tipo de reclamo seleccionado

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        // Obtener la ciudad del usuario autenticado
        $userCity = auth()->user()->city;

        // Filtrar los registros para que solo muestren los que tienen el estado 'INFORMACIONES'
        $claims = Claim::where('estado', 'INFORMACIONES')
            ->when(auth()->user()->hasAnyRole(['Reclamos', 'Informaciones']), function ($query) use ($userCity) {
                // Si el usuario tiene el rol 'Reclamos' o 'Informaciones', filtrar por ciudad
                return $query->where('ciudad', $userCity);
            })
            ->when($this->selectedDate, function ($query) {
                return $query->whereDate('created_at', $this->selectedDate);
            })
            ->when($this->searchTerm, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('codigo', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('remitente', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('telf_remitente', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('correlativo', 'like', '%' . $this->searchTerm . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        // Calcular el tiempo y asignar colores
        foreach ($claims as $claim) {
            // Inicializar la variable de diferencia de tiempo
            $timeDifference = 0;
            $timeUnit = '';

            // Determinar el tipo de reclamo y calcular el tiempo según corresponda
            if ($claim->tipo_envio == 'LOCAL') {
                // Calcular en horas
                $timeDifference = now()->diffInHours($claim->created_at);
                $timeUnit = 'horas';
                // Asignar color según el tiempo en horas
                if ($timeDifference >= 0 && $timeDifference <= 8) {
                    $claim->color = 'green';
                } elseif ($timeDifference >= 9 && $timeDifference <= 16) {
                    $claim->color = 'yellow';
                } else {
                    $claim->color = 'red';
                }
            } elseif ($claim->tipo_envio == 'NACIONAL') {
                // Calcular en días
                $timeDifference = now()->diffInDays($claim->created_at);
                $timeUnit = 'días';
                // Asignar color según el tiempo en días
                if ($timeDifference >= 0 && $timeDifference <= 5) {
                    $claim->color = 'green';
                } elseif ($timeDifference >= 6 && $timeDifference <= 10) {
                    $claim->color = 'yellow';
                } else {
                    $claim->color = 'red';
                }
            } elseif ($claim->tipo_envio == 'INTERNACIONAL') {
                // Calcular en días
                $timeDifference = now()->diffInDays($claim->created_at);
                $timeUnit = 'días';
                // Asignar color según el tiempo en días
                if ($timeDifference >= 0 && $timeDifference <= 2) {
                    $claim->color = 'green';
                } elseif ($timeDifference >= 3 && $timeDifference <= 5) {
                    $claim->color = 'yellow';
                } else {
                    $claim->color = 'red';
                }
            }

            // Guardar el tiempo de diferencia en horas o días
            $claim->time_difference = $timeDifference;
            $claim->time_unit = $timeUnit;
        }

        return view('livewire.bandejareclamos', ['claims' => $claims]);
    }


    public function guardarTipoReclamo()
    {
        if (count($this->selectedClaims) > 0 && $this->tipoReclamo) {
            // Actualizar estado y tipo de reclamo
            Claim::whereIn('id', $this->selectedClaims)
                ->update(['estado' => 'RECLAMOS', 'tipo_reclamo' => $this->tipoReclamo]);

            // Recorrer las reclamaciones seleccionadas para registrar un evento por cada una
            foreach ($this->selectedClaims as $claimId) {
                // Obtener el correlativo del reclamo
                $claim = Claim::find($claimId);

                // Crear el evento para cada reclamo
                Event::create([
                    'action' => 'RECLAMO PROCESADO',
                    'descripcion' => 'Reclamo recibido y procesado por el área de atención a reclamos.',
                    'user_id' => auth()->user()->name,
                    'codigo' => $claim->correlativo,
                ]);
            }

            session()->flash('message', 'Reclamo recibido y tipo de reclamo guardado con éxito!');
            $this->reset(['selectedClaims', 'selectAll', 'tipoReclamo']); // Resetear las selecciones
            $this->dispatch('modal-close'); // Cerrar el modal
        } else {
            session()->flash('error', 'No has seleccionado ningún reclamo o no has seleccionado el tipo de reclamo.');
        }
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedClaims = Claim::pluck('id')->toArray();
        } else {
            $this->selectedClaims = [];
        }
    }

    public function exportPdf()
    {
        // Obtener la ciudad del usuario autenticado
        $userCity = auth()->user()->city;

        // Filtrar los registros para exportar a PDF solo los que tienen el estado 'INFORMACIONES'
        $claims = Claim::where('estado', 'INFORMACIONES')
            ->when(auth()->user()->hasAnyRole(['Reclamos', 'Informaciones']), function ($query) use ($userCity) {
                // Si el usuario tiene el rol 'Reclamos' o 'Informaciones', filtrar por ciudad
                return $query->where('ciudad', $userCity);
            })
            ->when($this->selectedDate, function ($query) {
                return $query->whereDate('created_at', $this->selectedDate);
            })
            ->get();

        $pdf = PDF::loadView('livewire.pdf-bandeja', compact('claims'));

        Event::create([
            'action' => 'REPORTE',
            'descripcion' => 'Generar Reporte para Bandeja de Reclamos',
            'user_id' => auth()->user()->name,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Reclamos' . ($this->selectedDate ?? 'all') . '.pdf');
    }
}
