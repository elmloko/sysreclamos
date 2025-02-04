<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Claim;
use App\Models\Complaint;
use App\Models\Information;
use App\Models\Suggestion;
use App\Models\follow;

class ApiController extends Controller
{
    public function informations()
    {
        // Consulta usando Eloquent:
        $records = Information::where('estado', 'SAC')
                    ->get();

        return response()->json($records);
    }
    public function informationsm()
    {
        // Consulta usando Eloquent:
        $records = Information::where('estado', 'SAC MANUAL')
                    ->get();

        return response()->json($records);
    }
    public function informationll()
    {
        // Consulta usando Eloquent:
        $records = Information::where('estado', 'LLAMADA')
                    ->get();

        return response()->json($records);
    }
    public function claims()
    {
        // Aumentar el tiempo máximo de ejecución a 600 segundos (10 minutos)
        set_time_limit(600);
    
        // Consulta usando Eloquent, con la relación "follows"
        $records = Claim::with('follows')->get();
    
        return response()->json($records);
    }
    
    public function complaintsa()
    {
        // Consulta usando Eloquent:
        $records = Complaint::where('tipo', 'ADMINISTRATIVO')
                    ->get();

        return response()->json($records);
    } 
    public function complaintso()
    {
        // Consulta usando Eloquent:
        $records = Complaint::where('tipo', 'OPERATIVO')
                    ->get();

        return response()->json($records);
    } 
    public function suggestion()
    {
        // Aumentar el tiempo máximo de ejecución a 600 segundos (10 minutos)
        set_time_limit(600);
    
        // Consulta usando Eloquent
        $records = Suggestion::all();
        return response()->json($records);
    }  
}
