<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Claim;
use App\Models\Complaint;
use App\Models\Information;
use App\Models\Suggestion;

class Estadisticas extends Component
{
    public $totalClaims;
    public $totalComplaints;
    public $totalInformation;
    public $totalSuggestions;

    public function mount()
    {
        $this->totalClaims = Claim::count();
        $this->totalComplaints = Complaint::count();
        $this->totalInformation = Information::count();
        $this->totalSuggestions = Suggestion::count();
    }

    public function render()
    {
        return view('livewire.estadisticas', [
            'totalClaims' => $this->totalClaims,
            'totalComplaints' => $this->totalComplaints,
            'totalInformation' => $this->totalInformation,
            'totalSuggestions' => $this->totalSuggestions,
        ]);
    }
}
