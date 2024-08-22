<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Claim;

class ReclamosController extends Controller
{
    public function getBandeja ()
    {
        return view('reclamos.bandeja');
    }
    public function getSeguimiento ()
    {
        return view('reclamos.seguimientoreclamos');
    }
    public function getShow ($id)
    {
       // Aquí puedes cargar el reclamo basado en el ID
       $claim = Claim::findOrFail($id);
       return view('reclamos.show', compact('claim'));
    }
}
