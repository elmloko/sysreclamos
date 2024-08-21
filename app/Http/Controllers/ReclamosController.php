<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
