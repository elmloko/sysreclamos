<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Follow;

class QuejasController extends Controller
{
    public function getSeguimientoad()
    {
        return view('quejas.administrativas');
    }
    public function getSeguimientop()
    {
        return view('quejas.operativas');
    }
    public function getShow($id)
    {
        $complaint = Complaint::findOrFail($id);
        $follows = $complaint->follows; // Asegúrate de que la relación 'follows' esté bien definida en el modelo complaint
        return view('quejas.show', compact('complaint', 'follows'));
    }
}
