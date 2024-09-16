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
        $claims = Claim::when($this->selectedDate, function ($query) {
            return $query->whereDate('created_at', $this->selectedDate);
        })->get();

        $pdf = PDF::loadView('livewire.pdf-bandeja', compact('claims'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Reclamos' . ($this->selectedDate ?? 'all') . '.pdf');
    }
}
