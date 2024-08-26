<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Claim;
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
}
