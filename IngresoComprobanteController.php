<?php

namespace App\Http\Controllers;

use App\TipoTransaccion;
use App\TransaccionDiaria;
use App\UserEmpresa;
use App\Role;
use App\UserRole;
use App\Servicios\Proyeccion;
use App\Servicios\Plancontable;
use App\Servicios\Tiposervicio;
use App\Servicios\Service;
use App\Servicios\Subservice;
use App\Servicios\Plan;
use App\Tienda\Shop;
use App\ServicioPermisos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use DB;
use DateTime;
use Str;
use App\City;
use GoogleCloudVision\GoogleCloudVision;
use GoogleCloudVision\Request\AnnotateImageRequest;
use Carbon\Carbon;
use App\Exports\TransaccionExport;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class IngresoComprobanteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id, $tipoplan, $userEmpresa)
    {
        $transacciones = [];
        $dataUserEmpresa = UserEmpresa::where('id',$userEmpresa)->first();

        if(Auth::user()->hasRole('contador')){
            $userid = $dataUserEmpresa->user_id;
        }else{
            $userid = Auth::id();
        }

        $plan = Plan::where('tipoplan_id', $tipoplan)->where('service_id', $id)->first();
        $shop = Shop::where('tipoplan_id', $tipoplan)->where('service_id', $id)->where('plan_id', $plan->id)->where('user_id', $userid)->pluck('id');
        $mesActual = date('m');
        $empresa = $dataUserEmpresa->razon_social;
        $servicioUsuario = Shop::find($shop[0])->id;
        //$servicioPermisos = ServicioPermisos::where('plan_id', $plan->id)->get();
        //$permisos = DB::table('permissions')->pluck('name', 'id');

        $servicioPermisos = ServicioPermisos::join('permissions', 'permissions.id', '=', 'servicio_permisos.permission_id')
                                            ->select('permissions.name as permiso')
                                            ->where('servicio_permisos.plan_id', $plan->id)->get();

        $flagPermisoPlanCuentas = "false";

        if(count($servicioPermisos)){
            foreach ($servicioPermisos as $key => $value) {
                if($value->permiso == "m-plancontable")
                    $flagPermisoPlanCuentas = "true";
            }
        }

        $transacciones = TransaccionDiaria::join('tipotransaccion', 'tipotransaccion.id', '=', 'transacciondiaria.tipotransaccion_id')
                                    ->join('proyeccions', 'proyeccions.id', '=', 'transacciondiaria.proyeccions_id')
                                    ->where('transacciondiaria.estado','=','activo')
                                    ->selectRaw('transacciondiaria.id as id, transacciondiaria.created_at as fecha, UPPER(tipotransaccion.nombre) as tipo,
                                                tipotransaccion.accion as accion,
                                                transacciondiaria.detalle as detalle, transacciondiaria.iva as iva, transacciondiaria.importe as importe,
                                                transacciondiaria.usuarioplan_id as usuarioplan_id, transacciondiaria.tarifacero, transacciondiaria.tarifadifcero,
                                                proyeccions.descripcion as categoria')
                                    /*->select('transacciondiaria.id as id', 'transacciondiaria.fecha_registro as fecha', 'tipotransaccion.nombre as tipo',
                                             'transacciondiaria.detalle as detalle', 'transacciondiaria.iva as iva', 'transacciondiaria.importe as importe',
                                             'transacciondiaria.usuarioplan_id as usuarioplan_id')*/
                                    ->whereIn('transacciondiaria.usuarioplan_id', $shop)
                                    ->whereMonth('transacciondiaria.created_at', $mesActual)
                                    ->get();

        $categorias =TransaccionDiaria::join('tipotransaccion', 'tipotransaccion.id', '=', 'transacciondiaria.tipotransaccion_id')
                                ->join('proyeccions', 'proyeccions.id', '=', 'transacciondiaria.proyeccions_id')
                                ->where('transacciondiaria.estado','=','activo')
                                ->groupBy('proyeccions.descripcion')
                                ->selectRaw('(SUM(transacciondiaria.iva) + SUM(transacciondiaria.importe) + SUM(transacciondiaria.tarifadifcero)+ SUM(transacciondiaria.tarifacero)) as sum, proyeccions.descripcion as categoria')
                                ->whereIn('transacciondiaria.usuarioplan_id', $shop)
                                ->whereMonth('transacciondiaria.created_at', $mesActual)
                                ->pluck('sum','categoria');

        $sumaIngresos = 0;
        $sumaEgresos = 0;
        $sumaImpuestos = 0;

        foreach ($transacciones as $key => $value) {
            if($value->accion == "resta"){
                $sumaEgresos  = $sumaEgresos + ($value->tarifacero + $value->tarifadifcero + $value->iva + $value->importe);
            }else if($value->accion == "suma"){
                $sumaIngresos = $sumaIngresos + ($value->tarifacero + $value->tarifadifcero + $value->iva + $value->importe);
            }
        }

        $subservicio = $id;
        $planid = $plan->id;

        return view('admin.ingreso_facturas.ingreso_manual.index', compact('transacciones', 'subservicio', 'planid', 'tipoplan', 'sumaIngresos', 'sumaEgresos', 'categorias', 'userEmpresa', 'empresa', 'flagPermisoPlanCuentas', 'servicioUsuario', 'userid'));
    }

    public function listarComprobantes()
    {

        return TransaccionDiaria::join('tipotransaccion', 'tipotransaccion.id', '=', 'transacciondiaria.tipotransaccion_id')
                                    ->join('proyeccions', 'proyeccions.id', '=', 'transacciondiaria.proyeccions_id')
                                    ->where('transacciondiaria.estado','=','activo')
                                    ->select('transacciondiaria.id as id', 'transacciondiaria.fecha_registro as fecha', 'tipotransaccion.nombre as tipo', 'transacciondiaria.detalle as detalle',
                                             'transacciondiaria.iva as iva', 'transacciondiaria.importe as importe')
                                    ->get();

        //select('id','tipo_','activo')
    }

    public function listarTipoTransaccion()
    {
        return TipoTransaccion::where('estado','=','activo')
                                ->selectRaw('tipotransaccion.id as id,
                                            UPPER(tipotransaccion.nombre) as nombre,
                                            tipotransaccion.accion as accion,
                                            tipotransaccion.estado as estado')
                                ->get();
    }

    public function listarCategoria()
    {
        return Proyeccion::where('estado','=','activo')->get();
    }

    public function listarCuentas($id)
    {
        //$user_id = Auth::id();
        $empresa = UserEmpresa::where('id',$id)->pluck('id')->toArray();

        return Plancontable::where('estado','=','activo')->whereIn('user_empresa_id', $empresa)->get();
    }

    public function listarEmpresas()
    {
        $user_id = Auth::id();
        $empresa = UserEmpresa::where('user_id',$user_id)->get();
        return $empresa;
    }

    public function store(Request $request)
    {
        $user_id = $request->get('user_id');
        $plan = Plan::where('id', $request->get('plan'))->first();
        $shop = Shop::where('tipoplan_id', $plan->tipoplan_id)->where('service_id', $request->get('subServicio'))->where('plan_id', $request->get('plan'))
                    ->where('user_id', $user_id)->first();

        $transaccion = new TransaccionDiaria();
        $transaccion->usuarioempresa_id = $request->get('empresa_transaccion');
        $transaccion->usuarioplan_id = $shop->id;
        $transaccion->tipotransaccion_id = $request->get('tipo_transaccion');
        $transaccion->plancuenta_id = $request->get('cuenta');
        $transaccion->proyeccions_id = $request->get('tipo_categoria');
        $transaccion->fecha_registro = $request->get('fecha');
        $transaccion->detalle = $request->get('detalle');
        $transaccion->tarifacero = $request->get('tarifacero');
        $transaccion->tarifadifcero = $request->get('tarifadifcero');
        $transaccion->iva = $request->get('iva');
        $transaccion->importe = $request->get('importe');
        $transaccion->estado = $request->get('estado');
        $transaccion->archivo = $request->get('nombreFactura');

        $image =  $request->get('imagenBase64');
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = $request->get('nombreFactura') . '.png';
        file_put_contents(public_path().'/documentos/'.$imageName, base64_decode($image));

        $result = $transaccion->save();
        return response()->json($result, 201);

   }

   public function listarCalendario($id, $tipoplan, $userEmpresa)
   {

        $dataUserEmpresa = UserEmpresa::where('id',$userEmpresa)->first();
        $user_id = $dataUserEmpresa->user_id;
        $transacciones = [];
        $plan = Plan::where('tipoplan_id', $tipoplan)->where('service_id', $id)->first();
        $shop = Shop::where('tipoplan_id', $tipoplan)->where('service_id', $id)->where('plan_id', $plan->id)->where('user_id', $user_id)->pluck('id');
        $mesActual = date('m');
        $empresa = $dataUserEmpresa->razon_social;
        $arrayDataCalendario = array();
        $arraySumasFecha = array();
        $arraySumaMes = array();
        $arrayMeses = ["01","02","03","04","05","06","07","08","09","10","11","12"];
        $arraySumasDaily = array();

        $transacciones = TransaccionDiaria::selectRaw('COUNT(*) AS result, transacciondiaria.created_at as fecha_creacion')//select('transacciondiaria.*')
                                    ->whereIn('transacciondiaria.usuarioplan_id', $shop)
                                    ->where('transacciondiaria.estado','=','activo')
                                    ->groupBy('transacciondiaria.created_at')
                                    ->get()->toArray();

        $documentosElectronicos =TransaccionDiaria::join('tipotransaccion', 'tipotransaccion.id', '=', 'transacciondiaria.tipotransaccion_id')
        ->where('transacciondiaria.estado','=','activo')
        ->selectRaw('transacciondiaria.iva, transacciondiaria.importe, transacciondiaria.tarifadifcero, transacciondiaria.tarifacero, tipotransaccion.accion as transaccion, transacciondiaria.created_at as fecha_creacion')
        //->selectRaw('(SUM(transacciondiaria.iva) + SUM(transacciondiaria.importe) + SUM(transacciondiaria.tarifadifcero)+ SUM(transacciondiaria.tarifacero)) as valor_documento, tipotransaccion.accion as transaccion, transacciondiaria.created_at as fecha_creacion')
        ->whereIn('transacciondiaria.usuarioplan_id', $shop)
        ->orderBy('transacciondiaria.created_at')
        ->get()->toArray();

        $ingreso = 0;
        $egreso = 0;

        $ingresoDaily = 0;
        $egresoDaily = 0;

        $ingresoMensual = 0;
        $egresoMensual = 0;

        $j=0;

        foreach ($documentosElectronicos as $key => $value) {
            if($j > 0){
                $fechaCreacionActual = new DateTime($documentosElectronicos[$j]["fecha_creacion"]);
                $fechaCreacionAnterior = new DateTime($documentosElectronicos[$j-1]["fecha_creacion"]);
                if($fechaCreacionActual->format('d') !== $fechaCreacionAnterior->format('d')){
                    $ingreso = 0;
                    $egreso = 0;

                    $ingresoDaily = 0;
                    $egresoDaily = 0;
                }
            }

            if($value["transaccion"] == "suma"){
                $ingreso = $ingreso + ($value["iva"] + $value["tarifadifcero"] + $value["importe"] + $value["tarifacero"]);
                $ingresoDaily = $ingresoDaily + ($value["iva"] + $value["tarifadifcero"] + $value["importe"] + $value["tarifacero"]);
            }else{
                $egreso = $egreso + ($value["iva"] + $value["tarifadifcero"] + $value["importe"] + $value["tarifacero"]);
                $egresoDaily = $egresoDaily + ($value["iva"] + $value["tarifadifcero"] + $value["importe"] + $value["tarifacero"]);
            }

            $fechaKey = date('Y-m-d', strtotime($value["fecha_creacion"]));//d-m-Y
            $mes = date("m",strtotime($value["fecha_creacion"]));
            $arraySumasFecha[$fechaKey] = array("ingreso" => $ingreso, "egreso" => $egreso, "fecha_completa" => $value["fecha_creacion"]);
            $arraySumasDaily[$mes][$value["fecha_creacion"]] = array("ingreso" => $ingresoDaily, "egreso" => $egresoDaily, "fecha_completa" => $value["fecha_creacion"]);
            $j++;
        }

        $i = 0;
        foreach ($arraySumasFecha as $key => $value) {
            $arrayDataCalendario[$i] = array("groupId"=> '999', "title" => "$".$value["ingreso"], "start" => $key, "end" => $key, "classNames"=> "evento-ingresos");//INGRESOS
            $i++;
            $arrayDataCalendario[$i] = array("groupId"=> '1000', "title" => "$".$value["egreso"], "start" => $key, "end" => $key, "classNames"=> "evento-egresos");//EGRESOS
            $i++;
            $arrayDataCalendario[$i] = array("groupId"=> '2000', "title" => "$".($value["ingreso"] - $value["egreso"]), "start" => $key, "end" => $key, "classNames"=> "evento-saldos");//SALDO
            $i++;

            //$ingresoMensual = $ingresoMensual + $value["ingreso"];
            //$egresoMensual = $egresoMensual + $value["egreso"];
        }

        foreach ($arrayMeses as $key => $value) {
            foreach ($arraySumasFecha as $keyV => $valueV) {
                $fechaCreacionActual = new DateTime($valueV["fecha_completa"]);
                if($fechaCreacionActual->format('m') == $value){
                    $ingresoMensual = $ingresoMensual + $valueV["ingreso"];
                    $egresoMensual = $egresoMensual + $valueV["egreso"];
                }
            }

            $arraySumaMes[$value] = array("ingreso"=>$ingresoMensual, "egreso"=>$egresoMensual, "saldo"=>($ingresoMensual - $egresoMensual));
            $ingresoMensual = 0;
            $egresoMensual = 0;
        }

        $mesActual = date('m');

       return view('admin.ingreso_facturas.calendario', compact('arrayDataCalendario', 'empresa', 'arraySumaMes', 'mesActual', 'arraySumasDaily'));
   }

    public function leerFactura(Request $request)
    {

        $stringBase64 = explode(',', $request->get('img_factura'))[1];
        $data = explode(';', $request->get('img_factura'));
        $file = base64_decode($stringBase64);
        $type = explode('/', $data[0])[1];
        $ciudades = City::pluck('nombre')->toArray();
        $arrayValoresImagen = array("TOTAL"=> 0,
                                    "NUMERO-FACTURA"=> '',
                                    "FECHA-FACTURA"=> Carbon::now()->format('d/m/Y'),
                                    "IVA"=> 0);

        //$nombreArchivo = Str::random(5).'.'.$type;
        //$success = file_put_contents(public_path().'/Imagenes/'.$nombreArchivo, $file);
        //$rutaImagen = public_path().'/Imagenes/'.$nombreArchivo;

        //$ubicacionImagen = public_path()."/aegis/source/light/assets/img/factura-prueba-2.PNG";

        //$image = base64_encode(file_get_contents($ubicacionImagen));

        //convert image to base64
        //$image = base64_encode(file_get_contents($request->file('image')));

        try {
            //Prepare request
            $request = new AnnotateImageRequest();
            $request->setImage($stringBase64);
            $request->setFeature("TEXT_DETECTION");

            $gcvRequest = new GoogleCloudVision([$request], env('API_KEY'));

            //send annotation request
            $response = $gcvRequest->annotate();

            if(!isset($response->responses)){
                return response()->json($arrayValoresImagen, 201);
            }

            $textoEncontrado = $response->responses[0]->textAnnotations[0]->description;
            $arrayTexto = preg_split("/\r\n|\n|\r/", $textoEncontrado);
            //$arrayValoresImagen = [];

            $i = 0;
            foreach ($arrayTexto as $key => $value) {
                if (strpos($value, 'TOTAL') !== false && strpos($value, 'SUB') === false && preg_match('~[0-9]+~', $value)) {
                    $cantidad = preg_replace('/[^0-9]/', '', str_replace('$', '', $value));//substr($value, (strpos($value,"TOTAL") + 4), 10);
                    $arrayValoresImagen[/*preg_replace("/[^a-zA-Z]+/", "", $value)*/ "TOTAL"] = trim($cantidad);
                }

                if(strlen($value) > 5 && is_numeric($value)){
                    $arrayValoresImagen["NUMERO-FACTURA"] = trim($value);
                }

                if(in_array(trim($value) ,$ciudades)){
                    $arrayValoresImagen["FECHA-FACTURA"] = $arrayTexto[$i+1]."/".$arrayTexto[$i+2]."/".$arrayTexto[$i+3];
                }

                if ((strpos($value, 'IVA') !== false || strpos($value, 'I.V.A.') !== false) && preg_match('~[0-9]+~', $value)) {
                    $value = str_replace('12', '', $value);
                    $cantidad = preg_replace('/[^0-9]/', '', str_replace('$', '', $value));//substr($value, (strpos($value,"TOTAL") + 4), 10);
                    $arrayValoresImagen["IVA"] = trim($cantidad);
                }

                $i++;
            }

            return response()->json($arrayValoresImagen, 201);

        }catch(Exception $e){
            return response()->json($arrayValoresImagen, 201);
        }
    }

    public function exportarDocumentos($id){
        $shop = Shop::find($id);
        $empresa = UserEmpresa::find($shop->user_empresas_id);

        $name = 'documentos_'.str_replace(" ", "_", $empresa->razon_social);

        return (new TransaccionExport($id))->download($name.'.xlsx');
    }

}