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

    public function TipoPlanes(){
        return view('cruds.Servicios.TipoPlanes.index');
    }
    public function Planes(){
        return view('cruds.Servicios.TipoPlanes.Planes');
    }

    public function Servicio(){
        return view('cruds.Servicios.Servicios.servicio');
    }


}
