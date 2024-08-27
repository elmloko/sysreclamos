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
    public $searchTerm; // Término de búsqueda

    protected $paginationTheme = 'bootstrap'; // Para usar los estilos de AdminLTE

    public function render()
    {
        // Filtrar los registros según la fecha seleccionada y el término de búsqueda
        $complaint = Complaint::where('estado', 'RECEPCIONADO')
            ->where('tipo', 'OPERATIVO')
            ->when($this->selectedDate, function ($query) {
                return $query->whereDate('created_at', $this->selectedDate);
            })
            ->when($this->searchTerm, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('ci', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('cliente', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('telf', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('correlativo', 'like', '%' . $this->searchTerm . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        // Filtrar los registros según la fecha seleccionada y el estado "RECLAMOS"

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
