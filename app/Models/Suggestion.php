<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suggestion extends Model
{
    use SoftDeletes;

    protected $table = 'suggestions';

    protected $fillable = [
        'fullName',
        'address',
        'country',
        'identityCard',
        'codepostal',
        'email',
        'phone',
        'description',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public $timestamps = true;

    // Si necesitas definir un casting adicional, puedes hacerlo aquí.
    protected $casts = [
        'identityCard' => 'integer',
        'phone' => 'integer',
    ];
}
