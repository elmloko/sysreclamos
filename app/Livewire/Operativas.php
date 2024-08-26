<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Complaint;
use PDF;

class Operativas extends Component
{
    use WithPagination;

    public $perPage = 10; // Número de registros por página
    public $selectedDate; // Fecha seleccionada
    public $selectedcomplaints = []; // Arreglo de IDs seleccionados
    public $selectAll = false; // Controlar el checkbox "seleccionar todo"

    protected $paginationTheme = 'bootstrap'; // Para usar los estilos de AdminLTE

    public function render()
    {
        // Filtrar los registros según la fecha seleccionada y el estado "RECLAMOS"
        $complaint = Complaint::where('estado', 'RECEPCIONADO')
            ->where('tipo', 'OPERATIVO')
            ->when($this->selectedDate, function ($query) {
                return $query->whereDate('created_at', $this->selectedDate);
            })
            ->paginate($this->perPage);

        return view('livewire.operativas', ['complaints' => $complaint]);
    }

    public function exportPdf()
    {
        // Filtrar los registros según la fecha seleccionada para el PDF
        $complaints = Complaint::where('estado', 'RECEPCIONADO')
            ->where('tipo', 'OPERATIVO')
            ->when($this->selectedDate, function ($query) {
                return $query->whereDate('created_at', $this->selectedDate);
            })
            ->get();

        $pdf = PDF::loadView('livewire.pdf-bandejaq', compact('complaints'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Quejas Operativas' . ($this->selectedDate ?? 'all') . '.pdf');
    }

    public function mostrarQueja($claimId)
    {
        // Redirigir a la ruta claim.show con el ID del reclamo
        return redirect()->to(route('quejas.show', $claimId));
    }
}
