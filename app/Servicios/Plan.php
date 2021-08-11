<?php

namespace App\Servicios;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable =[

        'fecha_vigencia',
        'descripcion',
        'costo',
       ];


       public function tipoplan (){
           return $this->belongsTo('App\Servicios\Tipoplan');
       }

       public function documento()
       {
           return $this->morphOne('App\Document', 'documentable');
       }
   
   
       public function subservicio(){
           return $this->belongsTo('App\Servicios\Subservice');
       }

}
