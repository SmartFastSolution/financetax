<?php

namespace App\Indicador;

use Illuminate\Database\Eloquent\Model;

class Razoncorriente extends Model
{
    
    protected $fillable = [
       
        'activo_corriente',
        'pasivo_corriente',
        'razon_social',
        'ano',
        'user_id',
    ];
}
