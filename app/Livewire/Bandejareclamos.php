<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Claim;
use PDF;

class Bandejareclamos extends Component
{
    use WithPagination;

    public $perPage = 10; // Número de registros por página
    public $selectedDate; // Fecha seleccionada

    protected $paginationTheme = 'bootstrap'; // Para usar los estilos de AdminLTE

    public function render()
    {
        // Filtrar los registros según la fecha seleccionada
        $claim = Claim::when($this->selectedDate, function($query) {
            return $query->whereDate('created_at', $this->selectedDate);
        })->paginate($this->perPage);

        return view('livewire.bandejareclamos', ['claims' => $claim]);
    }

    public function exportPdf()
    {
        // Filtrar los registros según la fecha seleccionada para el PDF
        $claims = Claim::when($this->selectedDate, function($query) {
            return $query->whereDate('created_at', $this->selectedDate);
        })->get();

        $pdf = PDF::loadView('livewire.pdf-bandeja', compact('claims'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Reclamos' . ($this->selectedDate ?? 'all') . '.pdf');
    }
}
