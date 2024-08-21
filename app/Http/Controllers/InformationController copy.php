<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function getRecords ()
    {
        return view('information.records ');
    }
}
