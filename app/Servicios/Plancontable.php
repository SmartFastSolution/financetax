<?php

namespace App\Servicios;

use Illuminate\Database\Eloquent\Model;

class Plancontable extends Model
{
    protected $fillable =[
        'cuenta',
        'codigo',
        'nivel',
        'user_id',
        'user_empresa_id',
        'tipocuenta_id',
        'estado',
    ];
}
