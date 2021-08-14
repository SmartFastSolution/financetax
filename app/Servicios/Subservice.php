<?php

namespace App\Servicios;

use Illuminate\Database\Eloquent\Model;

class Subservice extends Model
{
    protected $fillable =[

        'nombre',
        'descripcion',
   
       ];

       public function documento()
    {
        return $this->morphOne('App\Document', 'documentable');
    }


    public function servicio(){
        return $this->belongsTo('App\Servicios\Service','service_id','id');
    }
    

    public function planes(){
        return $this->hasMany('App\Servicios\Plan');
    }



}
