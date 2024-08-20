<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Information;
use PDF;

class Records extends Component
{
    use WithPagination;

    public $perPage = 10; // Número de registros por página
    public $selectedDate; // Fecha seleccionada

    protected $paginationTheme = 'bootstrap'; // Para usar los estilos de AdminLTE

    public function render()
    {
        // Filtrar los registros según la fecha seleccionada
        $records = Information::when($this->selectedDate, function($query) {
            return $query->whereDate('created_at', $this->selectedDate);
        })->paginate($this->perPage);

        return view('livewire.records', ['records' => $records]);
    }

    public function exportPdf()
    {
        // Filtrar los registros según la fecha seleccionada para el PDF
        $records = Information::when($this->selectedDate, function($query) {
            return $query->whereDate('created_at', $this->selectedDate);
        })->get();

        $pdf = PDF::loadView('livewire.pdf-records', compact('records'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'records_' . ($this->selectedDate ?? 'all') . '.pdf');
    }
}