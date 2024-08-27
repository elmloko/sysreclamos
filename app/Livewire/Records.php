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
    public $searchTerm; // Término de búsqueda

    protected $paginationTheme = 'bootstrap'; // Para usar los estilos de AdminLTE

    public function render()
    {
        // Filtrar los registros según la fecha seleccionada y el término de búsqueda
        $records = Information::when($this->selectedDate, function ($query) {
            return $query->whereDate('created_at', $this->selectedDate);
        })
            ->when($this->searchTerm, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('codigo', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('destinatario', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('telefono', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('correlativo', 'like', '%' . $this->searchTerm . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.records', ['records' => $records]);
    }

    public function exportPdf()
    {
        // Filtrar los registros según la fecha seleccionada para el PDF
        $records = Information::when($this->selectedDate, function ($query) {
            return $query->whereDate('created_at', $this->selectedDate);
        })->get();

        $pdf = PDF::loadView('livewire.pdf-records', compact('records'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'records_' . ($this->selectedDate ?? 'all') . '.pdf');
    }
}
