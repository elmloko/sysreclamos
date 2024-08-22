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

        // Obtener el valor máximo de ficha asociado al claims_id dado
        $lastFicha = Follow::where('claims_id', $request->claims_id)->max('ficha');

        // Calcular el nuevo valor de ficha
        $newFicha = $lastFicha ? str_pad($lastFicha + 1, 4, '0', STR_PAD_LEFT) : '0001';

        // Crear el nuevo seguimiento
        Follow::create([
            'claims_id' => $request->claims_id,
            'ficha' => $newFicha,
            'seguimiento' => $request->seguimiento,
            'acciones' => $request->acciones,
            'docs' => $request->docs,
        ]);

        return redirect()->route('reclamos.show', $request->claims_id)->with('success', 'Seguimiento creado correctamente');
    }
}
