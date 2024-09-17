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
        // Obtener la ciudad del usuario autenticado
        $userCity = auth()->user()->city;
        
        // Filtrar los registros según el rol del usuario utilizando Spatie
        $claim = Claim::where('estado', 'RESUELTO')
            ->when(auth()->user()->hasRole('Reclamos'), function ($query) use ($userCity) {
                // Aplicar filtro de ciudad solo si el usuario tiene el rol de Reclamos
                return $query->where('ciudad', $userCity);
            })
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
        // Obtener la ciudad del usuario autenticado
        $userCity = auth()->user()->city;
    
        // Filtrar los registros según el rol del usuario utilizando Spatie
        $claims = Claim::where('estado', 'RESUELTO')
            ->when(auth()->user()->hasRole('Reclamos'), function ($query) use ($userCity) {
                // Aplicar filtro de ciudad solo si el usuario tiene el rol de Reclamos
                return $query->where('ciudad', $userCity);
            })
            ->when($this->selectedDate, function ($query) {
                return $query->whereDate('updated_at', $this->selectedDate);
            })
            ->get();
    
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
