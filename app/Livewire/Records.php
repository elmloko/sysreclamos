<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Information;

class Records extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap'; // Para usar los estilos de AdminLTE

    public $perPage = 10; // Número de registros por página

    public function render()
    {
        $records = Information::paginate($this->perPage);
        return view('livewire.records', ['records' => $records]);
    }
}
