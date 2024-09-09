<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Claim;
use App\Models\Follow;
use App\Models\Data;
use Illuminate\Support\Arr;

class ReclamosController extends Controller
{
    public function getBandeja()
    {
        return view('reclamos.bandeja');
    }
    public function getSeguimiento()
    {
        return view('reclamos.seguimientoreclamos');
    }
    public function getBaja()
    {
        return view('reclamos.bajareclamo');
    }

    public function getShow($id)
    {
        $claim = Claim::findOrFail($id);
        $follows = $claim->follows; // Asegúrate de que la relación 'follows' esté bien definida en el modelo Claim
        return view('reclamos.show', compact('claim', 'follows'));
    }

    public function createSeguimiento($claimId)
    {
        $claim = Claim::findOrFail($claimId);
        return view('reclamos.crearSeguimiento', compact('claim'));
    }

    public function storeSeguimiento(Request $request)
    {
        // Validación de los datos del formulario
        $validatedData = $request->validate([
            'claims_id' => 'required|integer',
            'seguimiento' => 'nullable|string|max:50',
            'acciones' => 'nullable|string|max:50',
            'docs.*' => 'nullable|file|max:10240', // Permite múltiples archivos, máximo 10MB cada uno
        ]);

        // Obtener el último valor de ficha para este claims_id
        $lastFicha = Follow::where('claims_id', $request->claims_id)->max('ficha');

        // Si existe un último valor de ficha, se incrementa. Si no, se inicia desde '0001'
        $newFicha = $lastFicha ? str_pad($lastFicha + 1, 4, '0', STR_PAD_LEFT) : '0001';

        // Añadir el nuevo valor de ficha al array de datos validados, excluyendo 'docs'
        $validatedData['ficha'] = $newFicha;

        // Crear el seguimiento en la tabla Follow (excluyendo 'docs')
        $follow = Follow::create(Arr::except($validatedData, ['docs']));

        // Procesar y guardar los archivos subidos en la tabla `data`
        if ($request->hasFile('docs')) {
            foreach ($request->file('docs') as $file) {
                // Guarda cada archivo en la carpeta 'uploads' y obtiene la ruta
                $path = $file->store('uploads', 'public');

                // Crea una entrada en la tabla `data` para cada archivo
                Data::create([
                    'docs' => $path, // Guarda la ruta del archivo como una cadena, no como un array
                    'claims_id' => $request->claims_id, // Relaciona el archivo con el claim
                ]);
            }
        }

        return redirect()->route('reclamos.show', $request->claims_id)
            ->with('success', 'Seguimiento y documentos creados correctamente');
    }
}
