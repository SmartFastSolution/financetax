<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\Tienda\Shop;
use App\UserEmpresa;
use App\Servicios\Plancontable;
use App\Servicios\Service;
use App\Servicios\Subservice;
use App\Tienda\DetallePagoPP;
use Carbon\Carbon;

trait ShopTrait
{


    public function CreateData($request){

        $user_id = Auth::id();
        $empresa_id = $request->empresa;

        if($request->empresa == 0){
            $userEmpresa = UserEmpresa::where('user_id',$user_id)->first();
            $empresa_id = $userEmpresa->id;
        }

        $shop                    = new Shop();
        $shop->user_id           = $user_id;
        $shop->service_id        = $request->service_id;
        $shop->tipoplan_id       = $request->tipoplan_id;
        $shop->plan_id           = $request->plan_id;
        $shop->costo             = $request->costo;
        $shop->estado            = $request->estado;
        $shop->user_empresas_id  = $empresa_id;
        $shop->save();

        if($request->tipoPago == "B"){
            $detallePP = DetallePagoPP::where('transactionId', $request->transactionId)->where('clientTransactionId', $request->clientTransactionId)->first()->id;

            $detalle = DetallePagoPP::find($detallePP);
            $detalle->shop_id = $shop->id;
            $detalle->save();
        }

        $subservicio = Service::find($request->service_id);

        $response = array('mensaje' => "Compra en Estado Revisión");
        return $response;

    }



}