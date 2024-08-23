<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model
{
    use SoftDeletes;

    protected $table = 'complaints';

    // Definir los campos que son asignables en masa
    protected $fillable = [
        'cliente',
        'telf',
        'ci',
        'email',
        'queja',
        'funcionario',
        'tipo',
        'estado'
    ];

    // Si usas SoftDeletes, Laravel maneja automáticamente las marcas de tiempo de borrado
    protected $dates = ['deleted_at'];
}
