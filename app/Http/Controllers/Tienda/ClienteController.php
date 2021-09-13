<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use App\Tienda\Shop;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    //funciones para el cliente e interacciones

    public function __construct()
    {
        $this->middleware('auth');
    }

    //funcion para redireccionar a la vista detalle de la lista de cliente
    public function ShowDataCliente($id){

        $compra = Shop::with([
            'tipoplan'=>function($query){
                $query->select('id','nombre');
            },
            'tipoplan.planes',
            'subservicio' =>function($query){
                $query->select('id','nombre','descripcion');
            },
            'especialista' => function($query){
                $query->select('id','name','email');
            },
            'plan' => function($query){
                $query->select('id','descripcion');
            }

            ]) ->find($id);
       //dd($compra);
        return view('cruds.cliente.showdetalle', compact('compra'));
    }

    //funcion para la interaccion con el especialista
    public function InteraccionCliente($id){
        $compra = Shop::with([
            'tipoplan'=>function($query){
                $query->select('id','nombre');
            },
            'especialista' => function($query){
                $query->select('id','name','email');
            },

            ]) ->find($id);
        return view('cruds.cliente.cliente-interaccion', compact('compra'));
    }



}
