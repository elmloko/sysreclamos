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
    public $selectedClaims = []; // Arreglo de IDs seleccionados
    public $selectAll = false; // Controlar el checkbox "seleccionar todo"
    public $searchTerm; // Término de búsqueda

    protected $paginationTheme = 'bootstrap'; // Para usar los estilos de AdminLTE

    public function render()
    {
        // Filtrar los registros según la fecha seleccionada y el término de búsqueda
        $claim = Claim::where('estado', 'INFORMACIONES')
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

        return view('livewire.bandejareclamos', ['claims' => $claim]);
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
}
