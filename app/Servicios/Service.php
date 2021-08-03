<?php

namespace App\Servicios;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function subservicio(){
        return $this->hasMany('App\Servicios\Subservice');
    }
}
