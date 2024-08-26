<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Claim;
use PDF;


class Seguimientoreclamos extends Component
{
    use WithPagination;

    public $perPage = 10; // Número de registros por página
    public $selectedDate; // Fecha seleccionada
    public $selectedClaims = []; // Arreglo de IDs seleccionados
    public $selectAll = false; // Controlar el checkbox "seleccionar todo"

    protected $paginationTheme = 'bootstrap'; // Para usar los estilos de AdminLTE

    public function render()
    {
        // Filtrar los registros según la fecha seleccionada y el estado "RECLAMOS"
        $claim = Claim::where('estado', 'RECLAMOS')
            ->when($this->selectedDate, function ($query) {
                return $query->whereDate('updated_at', $this->selectedDate);
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.seguimientoreclamos', ['claims' => $claim]);
    }

    public function cambiarEstadoReclamos()
    {
        if (count($this->selectedClaims) > 0) {
            Claim::whereIn('id', $this->selectedClaims)->update(['estado' => 'RECLAMOS']);
            session()->flash('message', 'Reclamo Recibido con exito!.');
            $this->reset(['selectedClaims', 'selectAll']);
        } else {
            session()->flash('error', 'No has seleccionado ningún reclamo.');
        }
    }

    // Método para seleccionar/deseleccionar todos los checkboxes
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
        // Filtrar los registros según la fecha seleccionada para el PDF
        $claims = Claim::when($this->selectedDate, function ($query) {
            return $query->whereDate('created_at', $this->selectedDate);
        })->get();

        $pdf = PDF::loadView('livewire.pdf-bandeja', compact('claims'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Reclamos' . ($this->selectedDate ?? 'all') . '.pdf');
    }

    public function mostrarReclamo($claimId)
    {
        // Redirigir a la ruta claim.show con el ID del reclamo
        return redirect()->to(route('reclamos.show', $claimId));
    }
}
