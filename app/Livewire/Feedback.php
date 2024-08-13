<?php

namespace App\Livewire;

use Livewire\Component;

class Feedback extends Component
{
    public $puntuacion = 0;

    public function mount()
    {

    }

    public function seleccionarPuntuacion($valor)
    {
        $this->puntuacion = $valor;
    }

    public function guardarFeedback()
    {
        // Guardar el feedback en la base de datos...

        session()->flash('message', '¡Gracias por tu feedback!');
    }

    public function render()
    {
        return view('livewire.feedback');
    }
}
