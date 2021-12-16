<?php

namespace App\Servicios;

use Illuminate\Database\Eloquent\Model;

class ServicioAccion extends Model
{
    protected $table = 'servicio_accion';

    protected $fillable =[
        'shop_id',
        'accion_id',
       ];
}
