<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Models\Claim;
use App\Models\Complaint;
use App\Models\Information;
use App\Models\Suggestion;
use Illuminate\Support\Collection;
use PDF; // Añade esto para usar el PDF
use Carbon\Carbon;

class All extends Component
{
    public $perPage = 10; // Número de registros por página
    public $searchTerm = ''; // Término de búsqueda
    public $selectedDate; // Fecha seleccionada para el filtro

    protected $paginationTheme = 'bootstrap'; // Tema Bootstrap para la paginación

    public function render()
    {
        // Recuperar los datos de todas las tablas, incluyendo created_at
        $claims = Claim::select('id', 'correlativo', 'remitente', 'telf_remitente', 'estado', 'created_at')
            ->when($this->selectedDate, function ($query) {
                $query->whereDate('created_at', $this->selectedDate);
            })
            ->when($this->searchTerm, function ($query) {
                $query->where('correlativo', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('remitente', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('telf_remitente', 'like', '%' . $this->searchTerm . '%');
            })
            ->get();

        $complaints = Complaint::select('id', 'correlativo', 'cliente as remitente', 'telf', 'estado', 'created_at')
            ->when($this->selectedDate, function ($query) {
                $query->whereDate('created_at', $this->selectedDate);
            })
            ->when($this->searchTerm, function ($query) {
                $query->where('correlativo', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('cliente', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('telf', 'like', '%' . $this->searchTerm . '%');
            })
            ->get();

        $information = Information::select('id', 'correlativo', 'destinatario as remitente', 'telefono', 'estado', 'created_at')
            ->when($this->selectedDate, function ($query) {
                $query->whereDate('created_at', $this->selectedDate);
            })
            ->when($this->searchTerm, function ($query) {
                $query->where('correlativo', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('destinatario', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('telefono', 'like', '%' . $this->searchTerm . '%');
            })
            ->get();

        $suggestions = Suggestion::select('id', 'correlativo', 'fullName as remitente', 'phone as telf', 'created_at')
            ->when($this->selectedDate, function ($query) {
                $query->whereDate('created_at', $this->selectedDate);
            })
            ->when($this->searchTerm, function ($query) {
                $query->where('fullName', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('correlativo', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('phone', 'like', '%' . $this->searchTerm . '%');
            })
            ->get();

        // Combinar todos los resultados en un solo array
        $allRecords = $claims->concat($complaints)->concat($information)->concat($suggestions);

        // Ordenar por created_at en orden descendente
        $allRecords = $allRecords->sortByDesc('created_at');

        // Paginar el array combinado
        $paginatedRecords = $this->paginate($allRecords, $this->perPage);

        // Pasar los datos paginados a la vista
        return view('livewire.all', ['records' => $paginatedRecords]);
    }

    public function exportPdf()
    {
        // Recuperar los datos de todas las tablas filtrados por la fecha seleccionada
        $claims = Claim::select('id', 'correlativo', 'remitente', 'telf_remitente', 'estado', 'created_at')
            ->when($this->selectedDate, function ($query) {
                $query->whereDate('created_at', $this->selectedDate);
            })
            ->get();

        $complaints = Complaint::select('id', 'correlativo', 'cliente as remitente', 'telf', 'estado', 'created_at')
            ->when($this->selectedDate, function ($query) {
                $query->whereDate('created_at', $this->selectedDate);
            })
            ->get();

        $information = Information::select('id', 'correlativo', 'destinatario as remitente', 'telefono', 'estado', 'created_at')
            ->when($this->selectedDate, function ($query) {
                $query->whereDate('created_at', $this->selectedDate);
            })
            ->get();

        $suggestions = Suggestion::select('id', 'fullName as remitente', 'phone as telf', 'created_at')
            ->when($this->selectedDate, function ($query) {
                $query->whereDate('created_at', $this->selectedDate);
            })
            ->get();

        // Combinar todos los resultados en un solo array
        $allRecords = $claims->concat($complaints)->concat($information)->concat($suggestions);

        // Ordenar por created_at en orden descendente
        $allRecords = $allRecords->sortByDesc('created_at');

        // Generar el PDF
        $pdf = PDF::loadView('livewire.pdf-all', ['records' => $allRecords]);

        // Retornar el PDF para descargar
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'reporte_' . ($this->selectedDate ?? 'todos') . '.pdf');
    }

    // Método de paginación manual para Collection
    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()] + $options
        );
    }
}
