<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use App\Servicios\Service;
use App\Servicios\Subservice;
use Illuminate\Http\Request;
use App\Servicios\Plan;
use App\Servicios\Tipoplan;

class ShopController extends Controller
{
    //controlador dedicado a la administracion de los planes que compra el usuario 
    //y administracion de los mismos por parte del especialista

     public function Index()
    {
        $data = Service::where('estado','activo')->paginate(8);
        return view('cruds.Tienda.index', compact('data'));

    }

    //function para el redireccionamiento a la pagina de lista de solicitudes
    public function access ($id){

        $servicio =Service::where('id', $id)->firstOrfail();
        $data  = Subservice::where('service_id', $id)->paginate(8);

      
        return view('cruds.Tienda.listasubservicios', compact('servicio','data'));
       

    }

 //function para el redireccionamiento de la informacion de compra de la solicitud 
    public function access2 ($id){
       
       
        
        $data  = Subservice::join('services','subservices.service_id','=', 'services.id')
         ->join('tiposervicios','services.tiposervicio_id','=','tiposervicios.id')
        ->where('subservices.id',$id)
        ->select('subservices.*','services.nombre as servicio','tiposervicios.nombre as tiposervicio')
        ->get();
        
        $plans = Plan::where('estado', 'activo') 
                ->with(['subservicio','subservicio.nombre'],['tipoplan','tipoplan.nombre'])
                 ->where('subservice_id','=', $id)  
                 ->get();

        $tipoplan = Tipoplan::join('plans','plans.tipoplan_id','=','tipoplans.id')
                    ->where('plans.subservice_id',$id)
                    ->where('plans.estado', 'activo') 
                    ->where('tipoplans.estado', 'activo') 
                   
        ->get(); 
        
        //dd($tipoplan);

        return view('cruds.Tienda.paginacompra', compact('data', 'plans','tipoplan'));

    }

    // public function getPlan(Request $request){
    //     $id = $request->id;
    //     $planes = Plan::GetTipoplan($id);
    //    // dd($planes);
    //     $data = array('message' => "Plan cargado satisfactoriamente", 'data' => $planes);
    //     return response()->json(collect($data), 200);
    // }

    public function getPlanes(Request $request)
    {
        $id = $request->id;
        $plans = Plan::Planes($id);
        $data = array('message' => "Plan cargado satisfactoriamente", 'data' => $plans);
        return response()->json(collect($data), 200);
      
    }



}
