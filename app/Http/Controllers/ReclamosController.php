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
            'ficha' => 'nullable|integer',
            'seguimiento' => 'nullable|string|max:50',
            'acciones' => 'nullable|string|max:50',
            'docs' => 'nullable|binary',
        ]);

        Follow::create($validatedData);

        return redirect()->route('seguimiento.show', $request->claims_id)->with('success', 'Seguimiento creado correctamente');
    }
}
