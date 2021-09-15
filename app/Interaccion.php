<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interaccion extends Model
{
   protected $table = "interaccions";
        protected $fillable = [
        "detalle",
        "observacion",
        'fecha',
    ];


  /*  public function posts (){
        return $this->belongsTo('App\Tienda\Shop');
    } */
}
