<?php

namespace App\Tienda;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $guard_name = 'shops';

    protected $fillable =[
        'costo',
        'user_id',
        'tipoplan_id',
        'plan_id',
        'subservice_id',
        'estado',
        'especialista_id',
        'accion_id',
       ];

    public function cliente()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function subservicio(){
        return $this->belongsTo('App\Servicios\Subservice','subservice_id','id');
    }

    public function tipoplan(){
        return $this->belongsTo('App\Servicios\Tipoplan');
    }

    public function plan(){
        return $this->belongsTo('App\Servicios\Plan');
    }

    public function especialista()
    {
        return $this->belongsTo('App\User', 'especialista_id');
    }

    public function interaccions()
    {
        return $this->belongsTo('App\Interaccion');
    }

    public function documento()
    {
        return $this->morphOne('App\Document', 'documentable');
    }




}
