<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interaccion extends Model
{
   protected $table = "interaccions";
        protected $fillable = [
        "user",
        "detalle",
        "observacion",
        "documento",
    ];


  /*  public function posts (){
        return $this->belongsTo('App\Tienda\Shop');
    } */
}
