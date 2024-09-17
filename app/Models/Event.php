<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'events';

    // Las columnas que pueden ser asignadas masivamente
    protected $fillable = [
        'action',
        'user_id',
        'descripcion',
        'codigo',
    ];

    // Relación con el usuario (si existe un modelo User relacionado)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
