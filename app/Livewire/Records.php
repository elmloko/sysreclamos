<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Information;
use App\Models\Event;
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
        // Obtener la ciudad del usuario autenticado
        $userCity = auth()->user()->city;
    
        // Filtrar los registros según el rol del usuario utilizando Spatie
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
            ->when(auth()->user()->hasRole('Informaciones'), function ($query) use ($userCity) {
                // Filtrar por la ciudad del usuario solo si tiene el rol de Reclamos
                return $query->where('ciudad', $userCity);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
    
        return view('livewire.records', ['records' => $records]);
    }
    

    public function exportPdf()
    {
        // Obtener la ciudad del usuario autenticado
        $userCity = auth()->user()->city;
    
        // Filtrar los registros según el rol del usuario para el PDF
        $records = Information::when($this->selectedDate, function ($query) {
                return $query->whereDate('created_at', $this->selectedDate);
            })
            ->when(auth()->user()->hasRole('Informaciones'), function ($query) use ($userCity) {
                // Filtrar por la ciudad del usuario solo si tiene el rol de Reclamos
                return $query->where('ciudad', $userCity);
            })
            ->get();
    
        $pdf = PDF::loadView('livewire.pdf-records', compact('records'));
    
        Event::create([
            'action' => 'REPORTE',
            'descripcion' => 'Generar Reporte para Informaciones',
            'user_id' => auth()->user()->name,
        ]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'records_' . ($this->selectedDate ?? 'all') . '.pdf');
    }
    
}
