<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Claim extends Model
{
    use HasFactory, SoftDeletes;

    // Especificar el nombre de la tabla, aunque Laravel puede inferirlo por convención
    protected $table = 'claims';

    // Especificar los campos que se pueden llenar de manera masiva
    protected $fillable = [
        'remitente',
        'telf_remitente',
        'email_r',
        'origen',
        'destinatario',
        'telf_destinatario',
        'email_d',
        'direccion_d',
        'codigo_postal',
        'destino',
        'codigo',
        'public',
        'fecha_envio',
        'contenido',
        'valor',
        'estado',
        'reclamo',
        'correlativo',
    ];

    // Especificar los campos que son de tipo fecha
    protected $dates = [
        'created_at',
        'updated_at',
        'fecha_envio',
        'deleted_at', // Este campo es necesario para las eliminaciones suaves (soft deletes)
    ];

    // Definir una relación uno a muchos con el modelo Follow
    public function follows()
    {
        return $this->hasMany(Follow::class, 'claims_id');
    }
}
