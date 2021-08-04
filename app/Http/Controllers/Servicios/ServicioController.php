<?php

namespace App\Http\Controllers\Servicios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
        // redireccion de tipo de planes vista 
    public function TipoPlanes(){
        return view('cruds.Servicios.TipoPlanes.index');
    }
  
        // redireccion de servicios vista
    public function Servicio(){
        return view('cruds.Servicios.Servicios.servicio');
    }
  

}
