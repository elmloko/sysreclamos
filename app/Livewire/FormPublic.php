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

        // Obtener el último correlativo
        $lastRecord = Suggestion::where('correlativo', 'like', 'SGR%')
                        ->orderBy('correlativo', 'desc')
                        ->first();

        // Generar el nuevo correlativo
        if ($lastRecord) {
            $lastNumber = (int)substr($lastRecord->correlativo, 3); // Extrae el número
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT); // Incrementa y formatea
        } else {
            $newNumber = '0001'; // Si no hay registros previos, empieza en 0001
        }

        $newCorrelativo = 'SGR' . $newNumber;

        // Crear el nuevo registro con el correlativo y estado 'PUBLICADO'
        Suggestion::create([
            'fullName' => strtoupper($this->fullName),
            'address' => strtoupper($this->address),
            'country' => strtoupper($this->country),
            'codepostal' => strtoupper($this->codepostal),
            'email' => $this->email,
            'phone' => strtoupper($this->phone),
            'description' => strtoupper($this->description),
            'correlativo' => $newCorrelativo, // Asigna el correlativo
            'estado' => 'PUBLICADO', // Asigna el estado
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
