<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    //RUTA PARA ACCEDER AL REPORTE DE USUARIOS CLIENTES
    public function ReporteEdad(){
        return view('cruds.reportes.reporteusuarios.reporteusuario');
    }

    public function ReporteCiudad(){
        return view('cruds.reportes.reporteusuarios.reporteuserciudad');
    }
}
