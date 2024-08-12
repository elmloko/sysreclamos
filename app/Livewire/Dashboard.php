<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $codigo;
    public $events = [];

    public function search()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer eZMlItx6mQMNZjxoijEvf7K3pYvGGXMvEHmQcqvtlAPOEAPgyKDVOpyF7JP0ilbK'
        ])->withOptions(['verify' => false])->get("https://correos.gob.bo:8000/api/events/repeated-codes/{$this->codigo}");

        if ($response->successful()) {
            $this->events = collect($response->json())->map(function ($event) {
                $event['updated_at'] = Carbon::parse($event['updated_at'])->format('d/m/Y H:i:s');
                return $event;
            })->toArray();
        } else {
            $this->events = [];
        }
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
