<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Complaint;
use PDF;

class Administrativas extends Component
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
        // Obtener la ciudad del usuario autenticado
        $userCity = auth()->user()->city;

        // Filtrar los registros según el rol del usuario utilizando Spatie
        $complaint = Complaint::where('estado', 'RECEPCIONADO')
            ->where('tipo', 'ADMINISTRATIVO')
            ->when(auth()->user()->hasRole('Informaciones'), function ($query) use ($userCity) {
                // Filtrar por la ciudad del usuario solo si tiene el rol de Reclamos
                return $query->where('ciudad', $userCity);
            })
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

        return view('livewire.administrativas', ['complaints' => $complaint]);
    }


    public function exportPdf()
    {
        // Obtener la ciudad del usuario autenticado
        $userCity = auth()->user()->city;

        // Filtrar los registros según el rol del usuario para el PDF
        $complaints = Complaint::where('estado', 'RECEPCIONADO')
            ->where('tipo', 'OPERATIVO')
            ->when(auth()->user()->hasRole('Informaciones'), function ($query) use ($userCity) {
                // Filtrar por la ciudad del usuario solo si tiene el rol de Reclamos
                return $query->where('ciudad', $userCity);
            })
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
