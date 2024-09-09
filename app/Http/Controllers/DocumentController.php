<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function download($file)
    {
        // Asegúrate de que el archivo exista en el almacenamiento público
        if (Storage::disk('public')->exists('uploads/' . $file)) {
            // Descargar el archivo
            return Storage::disk('public')->download('uploads/' . $file);
        } else {
            // Retornar un mensaje o redireccionar en caso de que el archivo no exista
            return redirect()->back()->with('error', 'El archivo no existe.');
        }
    }
}