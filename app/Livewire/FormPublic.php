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
        'address' => 'required|string',
        'country' => 'required|string|max:50',
        'identityCard' => 'required|integer',
        'codepostal' => 'required|string|max:50',
        'email' => 'required|email|max:50',
        'phone' => 'required|integer',
        'description' => 'nullable|string',
    ];

    public function submit()
    {
        $this->validate();

        Suggestion::create([
            'fullName' => $this->fullName,
            'address' => $this->address,
            'country' => $this->country,
            'identityCard' => $this->identityCard,
            'codepostal' => $this->codepostal,
            'email' => $this->email,
            'phone' => $this->phone,
            'description' => $this->description,
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
