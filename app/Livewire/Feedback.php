<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Information;

class Feedback extends Component
{
    public $inputId; // Variable para almacenar el ID ingresado manualmente
    public $puntuacion; // Variable para almacenar la puntuación seleccionada
    public $feedbackEnviado = false; // Variable para controlar si se ha enviado el feedback
    public $mensaje = ''; // Variable para almacenar el mensaje de advertencia

    // Método para seleccionar la puntuación y guardar feedback
    public function seleccionarPuntuacion($puntuacion)
    {
        $this->puntuacion = $puntuacion;

        if ($this->inputId && $this->puntuacion) {
            // Buscar el registro usando 'public' en lugar de 'id'
            $information = Information::where('public', $this->inputId)->first();

            if ($information) {
                // Verificar si ya ha sido calificado
                if ($information->feedback !== null) {
                    $this->mensaje = 'ESTE ID YA FUE CALIFICADO.';
                    return;
                }

                // Actualizar el registro con la puntuación
                $information->update(['feedback' => $this->puntuacion]);

                // Mostrar mensaje de agradecimiento
                $this->feedbackEnviado = true;

                // Disparar la recarga de la página desde el backend
                $this->dispatch('recargar-pagina');
            } else {
                $this->mensaje = 'ID no encontrado.';
            }
        } else {
            $this->mensaje = 'Por favor ingresa un ID válido.';
        }
    }

    public function asignarPuntuacionAutomatica()
    {
        if (!$this->feedbackEnviado) {
            $this->seleccionarPuntuacion(0);
        }
    }

    public function render()
    {
        return view('livewire.feedback');
    }
}
