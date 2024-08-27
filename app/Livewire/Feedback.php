<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Information;

class Feedback extends Component
{
    public $inputId; // Variable para almacenar el ID ingresado manualmente
    public $puntuacion; // Variable para almacenar la puntuación seleccionada
    public $feedbackEnviado = false; // Variable para controlar si se ha enviado el feedback

    // Método para seleccionar la puntuación y guardar feedback
    public function seleccionarPuntuacion($puntuacion)
    {
        $this->puntuacion = $puntuacion;
    
        if ($this->inputId && $this->puntuacion) {
            // Buscar el registro con el ID proporcionado
            $information = Information::find($this->inputId);
    
            if ($information) {
                // Actualizar el registro con la puntuación
                $information->update(['feedback' => $this->puntuacion]);
    
                // Mostrar mensaje de agradecimiento
                $this->feedbackEnviado = true;
    
                // Disparar la recarga de la página desde el backend
                $this->dispatch('recargar-pagina');
            } else {
                session()->flash('message', 'ID no encontrado.');
            }
        } else {
            session()->flash('message', 'Por favor ingresa un ID válido.');
        }
    }
    

    public function render()
    {
        return view('livewire.feedback');
    }
}
