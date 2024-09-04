<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Information;
use App\Models\Claim;  // Asegúrate de tener los modelos correctos
use App\Models\Complaint;  // Asegúrate de tener los modelos correctos

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
            // Buscar el registro en las tres tablas por 'public'
            $information = Information::where('public', $this->inputId)->first();
            $claim = Claim::where('public', $this->inputId)->first();
            $complaint = Complaint::where('public', $this->inputId)->first();

            // Verificar si el registro existe en alguna de las tablas
            if ($information) {
                $this->actualizarPuntuacion($information);
            } elseif ($claim) {
                $this->actualizarPuntuacion($claim);
            } elseif ($complaint) {
                $this->actualizarPuntuacion($complaint);
            } else {
                $this->mensaje = 'ID no encontrado.';
            }
        } else {
            $this->mensaje = 'Por favor ingresa un ID válido.';
        }
    }

    // Método para actualizar la puntuación en cualquier tabla
    protected function actualizarPuntuacion($record)
    {
        // Verificar si el ID ya ha sido calificado
        if ($record->feedback !== null) {
            $this->mensaje = 'ESTE ID YA FUE CALIFICADO.';
            return;
        }

        // Actualizar el registro con la puntuación
        $record->update(['feedback' => $this->puntuacion]);

        // Mostrar mensaje de agradecimiento
        $this->feedbackEnviado = true;

        // Disparar la recarga de la página desde el backend
        $this->dispatch('recargar-pagina');
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
