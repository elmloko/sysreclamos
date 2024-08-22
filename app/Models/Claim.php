<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Claim extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'claims';

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
        'fecha_envio',
        'contenido',
        'valor',
        'estado',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'fecha_envio',
        'deleted_at',
    ];
    public function follows()
    {
        return $this->hasMany(Follow::class, 'claims_id');
    }
}
