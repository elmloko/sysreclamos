<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Claim;
use PDF;

class Bajareclamos extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $selectedDate; // Fecha seleccionada
    public $searchTerm; // Término de búsqueda

    public function render()
    {

        // Filtrar los registros según la fecha seleccionada y el término de búsqueda
        $claim = Claim::where('estado', 'RESUELTO')
            ->when($this->selectedDate, function ($query) {
                return $query->whereDate('updated_at', $this->selectedDate);
            })
            ->when($this->searchTerm, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('codigo', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('remitente', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('telf_remitente', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('correlativo', 'like', '%' . $this->searchTerm . '%');
                });
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.bajareclamos', ['claims' => $claim]);
    }
    public function exportPdf()
    {
        // Filtrar los registros según la fecha seleccionada para el PDF
        $claims = Claim::when($this->selectedDate, function ($query) {
            return $query->whereDate('updated_at', $this->selectedDate);
        })->get();

        $pdf = PDF::loadView('livewire.pdf-bajareclamo', compact('claims'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Casos Resueltos.pdf');
    }
    public function mostrarReclamo($claimId)
    {
        // Redirigir a la ruta claim.show con el ID del reclamo
        return redirect()->to(route('reclamos.show', $claimId));
    }
    public function darDeAlta($claimId)
    {
        $claim = Claim::find($claimId);

        if ($claim) {
            $claim->update([
                'estado' => 'RECLAMOS',
                'deleted_at' => null // Si estás utilizando SoftDeletes y quieres restaurarlo
            ]);
            session()->flash('message', 'Reclamo dado de alta y marcado como RECLAMOS con éxito.');
        } else {
            session()->flash('error', 'No se pudo dar de alta el reclamo.');
        }
    }
}
