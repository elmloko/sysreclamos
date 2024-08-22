<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Follow extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'follow';

    protected $fillable = [
        'claims_id',
        'ficha',
        'seguimiento',
        'acciones',
        'docs'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'fecha_envio',
        'deleted_at',
    ];

    public function claim()
    {
        return $this->belongsTo(Claim::class, 'claims_id');
    }
}
