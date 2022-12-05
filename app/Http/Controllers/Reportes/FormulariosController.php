<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;
use SoapClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\TipoTransaccion;
use App\TransaccionDiaria;
use App\UserEmpresa;
use App\Role;
use App\UserRole;
use App\User;
use App\Accion;
use App\Servicios\ServicioAccion;
use App\Servicios\Proyeccion;
use App\Servicios\Plancontable;
use App\Servicios\Tiposervicio;
use App\Servicios\Service;
use App\Servicios\Subservice;
use App\Servicios\Plan;
use App\Tienda\Shop;
use Datetime;
use Carbon\Carbon;
use SimpleXMLElement;

class FormulariosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Formulario104()
    {


        $rutas = [];
        $acciones = [];
        $nombres = [];
        $dataEmpresas = [];
        $usuariosEspecialista = [];
        $campoQuery = "user_id";

        if(Auth::user()->hasRole('contador')){
            $campoQuery = "especialista_id";
        }

        $data = Shop::where('shops.'.$campoQuery, Auth::user()->id)
        ->join('users','shops.especialista_id', '=','users.id')
        ->join('services','shops.service_id', '=','services.id')
        ->join('tipoplans','shops.tipoplan_id','=','tipoplans.id')
        ->where('shops.estado','!=','pendiente')
        ->select('shops.*','services.nombre as sub','tipoplans.nombre as tipoplan','users.name as especialista',
                'services.id as id_subservice', 'tipoplans.id as id_tipoplan', 'tipoplans.id as id_tipoplan')
        ->orderBy('shops.id', 'asc')
        ->paginate(25);

        $rutasNombre    = Accion::pluck('descripcion','ruta');

        foreach ($data as $key => $value) {
            $servicioAccion = ServicioAccion::where('plan_id', $value->plan_id)
                            ->join('acciones','servicio_accion.accion_id', '=','acciones.id')
                            ->select('servicio_accion.*','acciones.ruta as ruta', 'acciones.descripcion as nombreRuta')->get();
            if(!$servicioAccion->isEmpty()){
                foreach ($servicioAccion as $keyserv => $valueserv) {
                    array_push($rutas, $valueserv->ruta);
                }
                $acciones[$value->id] = $rutas;
                $rutas = [];
            }

            if(Auth::user()->hasRole('contador')){
                array_push($usuariosEspecialista, $value->user_id);
            }
        }

        if(Auth::user()->hasRole('contador')){
            $EmpresasNombre = UserEmpresa::whereIn('user_id', $usuariosEspecialista)->pluck('razon_social', 'id');
            $EmpresasUsuarios = UserEmpresa::whereIn('user_id', $usuariosEspecialista)->pluck('user_id', 'id');
        }else{
            $EmpresasNombre = UserEmpresa::where('user_id', Auth::user()->id)->pluck('razon_social', 'id');
        }

        $date1 = new DateTime(Carbon::now());

        foreach ($EmpresasNombre as $keyEn => $valueEn) {

            if(Auth::user()->hasRole('contador'))
                $userId = $EmpresasUsuarios[$keyEn];
            else
                $userId = Auth::user()->id;

            $dataEmpresas[$valueEn] = Shop::where('shops.user_id', $userId)
                    ->join('users','shops.especialista_id', '=','users.id')
                    ->join('services','shops.service_id', '=','services.id')
                    ->join('tipoplans','shops.tipoplan_id','=','tipoplans.id')
                    ->where('shops.estado','!=','pendiente')
                    ->where('user_empresas_id', $keyEn)
                    ->select('shops.*','services.nombre as sub','tipoplans.nombre as tipoplan','users.name as especialista',
                            'services.id as id_subservice', 'tipoplans.id as id_tipoplan', 'tipoplans.id as id_tipoplan', 'shops.user_empresas_id as userEmpresa',
                            'shops.id as shop_id')
                    ->orderBy('shops.id', 'asc')
                    ->paginate(25);

            foreach ($dataEmpresas[$valueEn] as $key => $value) {
                $date2 = new DateTime($dataEmpresas[$valueEn][$key]->fecha_caducidad);
                $diff = $date2->diff($date1)->format("%a");
                if($date1 > $date2)
                    $dataEmpresas[$valueEn][$key]->diasRestantes = (-1 * intval($diff));
                else
                    $dataEmpresas[$valueEn][$key]->diasRestantes = intval($diff);
            }
        }

        //return view('livewire.tienda.listacliente', compact('data', 'acciones', 'rutasNombre', 'EmpresasNombre', 'dataEmpresas'));

        /*
        $user_id = Auth::id();
        $userEmpresa = UserEmpresa::where('user_id', $user_id)->pluck('id','razon_social');
        $userInfo = User::where('id', $user_id)->first();
        $meses = array('Enero' => "01", 'Febrero' => "02", 'Marzo' => "03",
                        'Abril' => "04", 'Mayo' => "05", 'Junio' => "06",
                        'Julio' => "07", 'Agosto' => "08", 'Septiembre' => "09",
                        'Octubre' => "10", 'Noviembre' => "11", 'Diciembre' => "12");

        return view('cruds.reportes.formulario104', compact('meses', 'userEmpresa'));
        */

        return view('cruds.reportes.formulario104', compact('data', 'acciones', 'rutasNombre', 'EmpresasNombre', 'dataEmpresas'));
    }

    public function Consultar104($shop){

        $user_id = Auth::id();
        $userInfo = User::where('id', $user_id)->first();
        $meses = array('Enero' => "01", 'Febrero' => "02", 'Marzo' => "03",
                        'Abril' => "04", 'Mayo' => "05", 'Junio' => "06",
                        'Julio' => "07", 'Agosto' => "08", 'Septiembre' => "09",
                        'Octubre' => "10", 'Noviembre' => "11", 'Diciembre' => "12");
        $shop_id = $shop;

        return view('cruds.reportes.consultar104', compact('meses', 'shop_id'));

    }

    public function Detalle104($shop, $anio, $mes){
        $shopData = Shop::find($shop);
        $userEmpresa = UserEmpresa::find($shopData->user_empresas_id);
        $dateObj   = DateTime::createFromFormat('!m', $mes);
        $nombreMes = $dateObj->format('F');

        $categorias = Proyeccion::where('estado','=','activo')->get();

        $dataDetalle = TransaccionDiaria::join('tipotransaccion', 'tipotransaccion.id', '=', 'transacciondiaria.tipotransaccion_id')
                                    ->join('proyeccions', 'proyeccions.id', '=', 'transacciondiaria.proyeccions_id')
                                    //->leftJoin('plancontables', 'plancontables.id', 'transacciondiaria.plancuenta_id')
                                    ->select('tipotransaccion.nombre',
                                            //'plancontables.codigo',
                                            //'plancontables.cuenta',
                                            'proyeccions.descripcion as descripcion_categoria',
                                            'proyeccions.codigosri as cod_sri',
                                            'transacciondiaria.proyeccions_id',
                                            'transacciondiaria.detalle',
                                            'transacciondiaria.tarifacero',
                                            'transacciondiaria.tarifadifcero',
                                            'transacciondiaria.iva',
                                            'transacciondiaria.importe',
                                            'transacciondiaria.created_at')
                                    ->where('transacciondiaria.usuarioplan_id', $shop)
                                    ->whereRaw('YEAR(transacciondiaria.fecha_registro) ='.$anio)
                                    ->whereRaw('MONTH(transacciondiaria.fecha_registro) ='.$mes)
                                    ->where('transacciondiaria.estado','=','activo')
                                    ->get();

        $formulario = [];

        foreach ($dataDetalle as $key => $value) {
            $acumCategoria = 0;
            foreach ($categorias as $keyCat => $valueCat) {
                if($value->proyeccions_id == $valueCat->id){
                    $valorTransaccion = ($value->tarifacero + $value->tarifadifcero + $value->iva + $value->importe);
                    $acumCategoria+= $valorTransaccion;
                }
            }

            $formulario[$value->cod_sri] = array(
                                            "valorTransaccion" => $acumCategoria,
                                            "descripcionCategoria" => $value->descripcion_categoria,
                                            "codigoCategoria" => $value->cod_sri,
                                        );
        }

        $total = 0;
        foreach ($categorias as $keyCat => $valueCat) {
            if (array_key_exists($valueCat->codigosri, $formulario)){
                $valueCat->valorTransaccion = $formulario[$valueCat->codigosri]["valorTransaccion"];
            }else{
                $valueCat->valorTransaccion = 0;
            }

            $total += $valueCat->valorTransaccion;
        }

        return view('cruds.reportes.detalle104', compact('formulario', 'categorias', 'anio', 'nombreMes', 'mes','userEmpresa', 'total', 'shop'));
    }

    public function generarXML($shop, $anio, $mes){

        $shopData = Shop::find($shop);
        $userEmpresa = UserEmpresa::find($shopData->user_empresas_id);
        $dateObj   = DateTime::createFromFormat('!m', $mes);

        $categorias = Proyeccion::where('estado','=','activo')->get()->toArray();

        $dataDetalle = TransaccionDiaria::join('tipotransaccion', 'tipotransaccion.id', '=', 'transacciondiaria.tipotransaccion_id')
                                    ->join('proyeccions', 'proyeccions.id', '=', 'transacciondiaria.proyeccions_id')
                                    //->leftJoin('plancontables', 'plancontables.id', 'transacciondiaria.plancuenta_id')
                                    ->select('tipotransaccion.nombre',
                                            //'plancontables.codigo',
                                            //'plancontables.cuenta',
                                            'proyeccions.descripcion as descripcion_categoria',
                                            'proyeccions.codigosri as cod_sri',
                                            'transacciondiaria.proyeccions_id',
                                            'transacciondiaria.detalle',
                                            'transacciondiaria.tarifacero',
                                            'transacciondiaria.tarifadifcero',
                                            'transacciondiaria.iva',
                                            'transacciondiaria.importe',
                                            'transacciondiaria.created_at')
                                    ->where('transacciondiaria.usuarioplan_id', $shop)
                                    ->whereRaw('YEAR(transacciondiaria.fecha_registro) ='.$anio)
                                    ->whereRaw('MONTH(transacciondiaria.fecha_registro) ='.$mes)
                                    ->where('transacciondiaria.estado','=','activo')
                                    ->get();

        $formulario = [];

        foreach ($dataDetalle as $key => $value) {
            $acumCategoria = 0;
            foreach ($categorias as $keyCat => $valueCat) {
                if($value->proyeccions_id == $valueCat["id"]){
                    $valorTransaccion = ($value->tarifacero + $value->tarifadifcero + $value->iva + $value->importe);
                    $acumCategoria+= $valorTransaccion;
                }
            }

            $formulario[$value->cod_sri] = array(
                                            "valorTransaccion" => $acumCategoria,
                                            "descripcionCategoria" => $value->descripcion_categoria,
                                            "codigoCategoria" => $value->cod_sri,
                                        );
        }

        foreach ($categorias as $keyCat => $valueCat) {
            if (array_key_exists($valueCat["codigosri"], $formulario)){
                $categorias[$keyCat]["valorTransaccion"] = $formulario[$valueCat["codigosri"]]["valorTransaccion"];
            }else{
                $categorias[$keyCat]["valorTransaccion"] = 0;
            }

            unset($categorias[$keyCat]["id"]);
            unset($categorias[$keyCat]["estado"]);
            unset($categorias[$keyCat]["created_at"]);
            unset($categorias[$keyCat]["updated_at"]);
        }

        $xml_data = new SimpleXMLElement('<?xml version="1.0"?><data></data>');

        $this->array_to_xml($categorias, $xml_data);
        $fileName = $this->generateRandomString();
        $fileName = $fileName."_formularioxml";
        $result = $xml_data->asXML('generadosXml/'.$fileName.'.xml');

        return Response::download( public_path(). "/generadosXml/".$fileName.".xml", $fileName.'.xml')->deleteFileAfterSend(true);
    }

    public function array_to_xml( $data, &$xml_data ) {
        foreach( $data as $key => $value ) {
            if( is_array($value) ) {
                if( is_numeric($key) ){
                    $key = 'item'.$key; //dealing with <0/>..<n/> issues
                }
                $subnode = $xml_data->addChild($key);
                $this->array_to_xml($value, $subnode);
            } else {
                $xml_data->addChild("$key",htmlspecialchars("$value"));
            }
         }
    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}