<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $table = 'data';

    protected $fillable = [
        'docs', // La ruta del documento
        'claims_id', // El id del reclamo
    ];
}