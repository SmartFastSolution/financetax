<?php

namespace App\Http\Controllers\Servicios;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubservicioRequest;
use App\Servicios\Service;
use App\Servicios\Subservice;
use App\Traits\SubservicioTrait;
use Illuminate\Http\Request;

class SubserviceController extends Controller
{
    use SubservicioTrait;
   
   public function index (){
    return view('cruds.Servicios.Servicios.subserviceindex');
   }
   
    public function Sub_service(Request $request){

      $servicios = Service::where('estado', 'activo')->get();
      if ($request->has('subservice')) {
          $subservice = Subservice::with(['servicio','servicio.nombre'])->firstOrFail($request->get('subservice')); 

          return view('cruds.Servicios.Servicios.subservice', compact('servicios', 'subservice'));  
        }else {
           
            return view('cruds.Servicios.Servicios.subservice', compact('servicios'));
        }
        
    }


    public function store(SubservicioRequest $request){

        $result = $request->edit == 'si' ? $this->UpdateSubservicio($request) : $this->CreateSubservicio($request);
        return response()->json($result, 201);

    }
}
