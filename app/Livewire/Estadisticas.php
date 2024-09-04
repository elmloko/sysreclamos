<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Claim;
use App\Models\Complaint;
use App\Models\Information;
use App\Models\Suggestion;
use Illuminate\Support\Facades\DB;

class Estadisticas extends Component
{
    public $totalClaims;
    public $totalComplaints;
    public $totalInformation;
    public $totalSuggestions;
    public $informationPerDay = [];
    public $claimsPerDay = [];
    public $complaintsPerDay = [];
    public $suggestionsPerDay = [];
    public $claimsPerMonth = [];
    public $complaintsPerMonth = [];
    public $informationPerMonth = [];
    public $suggestionsPerMonth = [];

    public function mount()
    {
        $this->totalClaims = Claim::count();
        $this->totalComplaints = Complaint::count();
        $this->totalInformation = Information::count();
        $this->totalSuggestions = Suggestion::count();
        $this->informationPerDay = Information::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get()
            ->toArray();
        $this->claimsPerDay = Claim::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get()
            ->toArray();
        $this->complaintsPerDay = Complaint::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get()
            ->toArray();
        $this->suggestionsPerDay = Suggestion::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get()
            ->toArray();
        // Obtener los registros por mes de cada tabla
        $this->claimsPerMonth = Claim::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get()
            ->toArray();

        $this->complaintsPerMonth = Complaint::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get()
            ->toArray();

        $this->informationPerMonth = Information::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get()
            ->toArray();

        $this->suggestionsPerMonth = Suggestion::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.estadisticas', [
            'totalClaims' => $this->totalClaims,
            'totalComplaints' => $this->totalComplaints,
            'totalInformation' => $this->totalInformation,
            'totalSuggestions' => $this->totalSuggestions,
            'informationPerDay' => $this->informationPerDay,
            'claimsPerDay' => $this->claimsPerDay,
            'complaintsPerDay' => $this->complaintsPerDay,
            'suggestionsPerDay' => $this->suggestionsPerDay,
            'claimsPerMonth' => $this->claimsPerMonth,
            'complaintsPerMonth' => $this->complaintsPerMonth,
            'informationPerMonth' => $this->informationPerMonth,
            'suggestionsPerMonth' => $this->suggestionsPerMonth,
        ]);
    }
}
