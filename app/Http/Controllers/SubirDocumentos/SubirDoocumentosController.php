<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;



class SubirDocumentosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /* Ruta para subir los documentos
        No me sirve :'v
    */
    public function SubirDocumentos (){

        return view('Subidadocumentos.index');
   }

}
