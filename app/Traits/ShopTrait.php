<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\Tienda\Shop;
use App\UserEmpresa;

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
        $shop->subservice_id     = $request->subservice_id;
        $shop->tipoplan_id       = $request->tipoplan_id;
        $shop->plan_id           = $request->plan_id;
        $shop->costo             = $request->costo;
        $shop->estado            = $request->estado;
        $shop->user_empresas_id  = $empresa_id;
        $shop->save();

        $response = array('mensaje' => "Compra en Estado Revisión");
        return $response;

    }


  


}