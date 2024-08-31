<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SugerenciaController extends Controller
{
    public function getSugerencia ()
    {
        return view('sugerencia.sugerencia');
    }
}
