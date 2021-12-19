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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class IngresoComprobanteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id, $tipoplan)
    {
        $user_id = Auth::id();
        $transacciones = [];
        $plan = Plan::where('tipoplan_id', $tipoplan)->where('subservice_id', $id)->first();
        $shop = Shop::where('tipoplan_id', $tipoplan)->where('subservice_id', $id)->where('plan_id', $plan->id)->where('user_id', $user_id)->pluck('id');

        $transacciones = TransaccionDiaria::join('tipotransaccion', 'tipotransaccion.id', '=', 'transacciondiaria.tipotransaccion_id')
                                    ->join('proyeccions', 'proyeccions.id', '=', 'transacciondiaria.proyeccions_id')
                                    ->where('transacciondiaria.estado','=','activo')
                                    ->selectRaw('transacciondiaria.id as id, transacciondiaria.created_at as fecha, UPPER(tipotransaccion.nombre) as tipo,
                                                transacciondiaria.detalle as detalle, transacciondiaria.iva as iva, transacciondiaria.importe as importe,
                                                transacciondiaria.usuarioplan_id as usuarioplan_id')
                                    /*->select('transacciondiaria.id as id', 'transacciondiaria.fecha_registro as fecha', 'tipotransaccion.nombre as tipo',
                                             'transacciondiaria.detalle as detalle', 'transacciondiaria.iva as iva', 'transacciondiaria.importe as importe',
                                             'transacciondiaria.usuarioplan_id as usuarioplan_id')*/
                                    ->whereIn('transacciondiaria.usuarioplan_id', $shop)
                                    ->get();

        $sumaIngresos = 0;
        $sumaEgresos = 0;
        $sumaImpuestos = 0;
        foreach ($transacciones as $key => $value) {
            if($value->tipo == "EGRESOS"){
                $sumaEgresos  = $sumaEgresos + ($value->tarifacero + $value->tarifadifcero + $value->iva + $value->importe);
            }else if($value->tipo == "INGRESOS"){
                $sumaIngresos = $sumaIngresos + ($value->tarifacero + $value->tarifadifcero + $value->iva + $value->importe);
            }
        }

        $subservicio = $id;
        $planid = $plan->id;

        //$infoGrafico["ingresos"] = $sumaIngresos;
        //$infoGrafico["egresos"] = $sumaEgresos;

        return view('admin.ingreso_facturas.ingreso_manual.index', compact('transacciones', 'subservicio', 'planid', 'tipoplan', 'sumaIngresos', 'sumaEgresos'));
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
        return TipoTransaccion::where('estado','=','activo')->get();
    }

    public function listarCategoria()
    {
        return Proyeccion::where('estado','=','activo')->get();
    }

    public function listarCuentas()
    {
        $user_id = Auth::id();
        $empresa = UserEmpresa::where('user_id',$user_id)->pluck('id')->toArray();

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
        $user_id = Auth::id();
        $plan = Plan::where('id', $request->get('plan'))->first();
        $shop = Shop::where('tipoplan_id', $plan->tipoplan_id)->where('subservice_id', $request->get('subServicio'))->where('plan_id', $request->get('plan'))
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

}
