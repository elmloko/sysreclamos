<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Information extends Model
{
    use HasFactory;

    protected $table = 'information';
    protected $softDelete = true;

    // Especifica los campos que pueden ser asignados en masa
    protected $fillable = [
        'codigo',
        'destinatario',
        'last_event',
        'telefono',
        'ciudad',
        'ventanilla',
        'last_status',
        'last_description',
        'last_date',
        'estado',
        'feedback',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $dates = ['last_date', 'created_at', 'updated_at', 'deleted_at'];
}
