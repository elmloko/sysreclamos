<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Suggestion;

class FormPublic extends Component
{
    public $fullName;
    public $address;
    public $country;
    public $identityCard;
    public $codepostal;
    public $email;
    public $phone;
    public $description;

    protected $rules = [
        'fullName' => 'required|string|max:50',
        'country' => 'required|string|max:50',
        'email' => 'required|email|max:50',
        'phone' => 'required|integer',
        'description' => 'required|nullable|string',
    ];

    public function submit()
    {
        $this->validate();

        Suggestion::create([
            'fullName' => strtoupper($this->fullName),
            'address' => strtoupper($this->address),
            'country' => strtoupper($this->country),
            'codepostal' => strtoupper($this->codepostal),
            'email' => $this->email,
            'phone' => strtoupper($this->phone),
            'description' => strtoupper($this->description),
        ]);


        session()->flash('message', 'Reclamación enviada con éxito');

        // Limpia los campos del formulario
        $this->reset();
    }

    public function render()
    {
        return view('livewire.form-public');
    }
}
