<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Claim;
use App\Models\Follow;

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
        $validatedData = $request->validate([
            'claims_id' => 'required|integer',
            'seguimiento' => 'nullable|string|max:50',
            'acciones' => 'nullable|string|max:50',
            'docs' => 'nullable|binary',
        ]);

        // Obtener el último valor de ficha para este claim_id
        $lastFicha = Follow::where('claims_id', $request->claims_id)->max('ficha');

        // Si existe un último valor de ficha, se incrementa. Si no, se inicia desde '0001'
        $newFicha = $lastFicha ? str_pad($lastFicha + 1, 4, '0', STR_PAD_LEFT) : '0001';

        // Añadir el nuevo valor de ficha al array de datos validados
        $validatedData['ficha'] = $newFicha;

        // Crear el seguimiento con los datos validados
        Follow::create($validatedData);

        return redirect()->route('reclamos.show', $request->claims_id)->with('success', 'Seguimiento creado correctamente');
    }
}
