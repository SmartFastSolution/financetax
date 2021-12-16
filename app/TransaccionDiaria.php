<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaccionDiaria extends Model
{
    protected $table = 'transacciondiaria';

    protected $guarded = [];

    protected $fillable = [
        'usuarioempresa_id', 'usuarioplan_id', 'tipotransaccion_id', 'plancuenta_id','proyeccions_id','fecha_registro',
        'detalle', 'tarifacero', 'tarifadifcero','iva','importe','archivo','estado'
    ];
}
