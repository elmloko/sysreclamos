<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Claim;
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

        // Calcular los días de diferencia y asignar colores
        foreach ($claims as $claim) {
            $daysDifference = now()->diffInDays($claim->created_at);
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

        return view('livewire.bandejareclamos', ['claims' => $claims]);
    }

    public function guardarTipoReclamo()
    {
        if (count($this->selectedClaims) > 0 && $this->tipoReclamo) {
            // Actualizar estado y tipo de reclamo
            Claim::whereIn('id', $this->selectedClaims)
                ->update(['estado' => 'RECLAMOS', 'tipo_reclamo' => $this->tipoReclamo]);

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

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Reclamos' . ($this->selectedDate ?? 'all') . '.pdf');
    }
}
