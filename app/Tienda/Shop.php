<?php

namespace App\Tienda;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
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

    public function especialista()
    {
        return $this->belongsTo('App\User', 'especialista_id');
    }

}
