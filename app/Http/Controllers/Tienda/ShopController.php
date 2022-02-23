<?php

namespace App\Http\Controllers\Tienda;

use App\DocumentosInteraccion;

use App\Http\Controllers\Controller;
use App\Http\Requests\TiendaRequest;
use App\Servicios\Service;
use App\Servicios\Subservice;
use Illuminate\Http\Request;
use App\Servicios\Plan;
use App\Servicios\Tipoplan;
use App\Tienda\Shop;
use App\Traits\ShopTrait;
use App\UserEmpresa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    use ShopTrait;
    //controlador dedicado a la administracion de los planes que compra el usuario
    //y administracion de los mismos por parte del especialista

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function Index()
    {
        $data = Service::where('estado', 'activo')->paginate(8);
        return view('cruds.Tienda.index', compact('data'));
    }

    //function para el redireccionamiento a la pagina de lista de solicitudes
    public function access($id)
    {

        //$servicio = Service::where('id', $id)->firstOrfail();
        $servicio = Service::where('slug', $id)->firstOrfail();
        $data  = Subservice::where('service_id', $servicio->id)->paginate(8);


        return view('cruds.Tienda.listasubservicios', compact('servicio', 'data'));
    }

    //function para el redireccionamiento de la informacion de compra de la solicitud
    public function access2($id)
    {

        $user_id = Auth::id();
        $empresas = UserEmpresa::where('user_id',$user_id)->get();

        $data  = Subservice::join('services', 'subservices.service_id', '=', 'services.id')
            ->join('tiposervicios', 'services.tiposervicio_id', '=', 'tiposervicios.id')
            //->where('subservices.id', $id)
            ->where('subservices.slug', $id)
            ->select('subservices.*', 'services.nombre as servicio', 'tiposervicios.nombre as tiposervicio')
            ->get();

        $plans = Plan::where('estado', 'activo')
            ->with(['subservicio', 'subservicio.nombre'], ['tipoplan', 'tipoplan.nombre'])
            //->where('subservice_id', '=', $id)
            ->where('subservice_id', '=', $data[0]->id)
            ->get();

        $tipoplan = Tipoplan::join('plans', 'plans.tipoplan_id', '=', 'tipoplans.id')
            //->where('plans.subservice_id', $id)
            ->where('plans.subservice_id', $data[0]->id)
            ->where('plans.estado', 'activo')
            ->where('tipoplans.estado', 'activo')

            ->get();

        return view('cruds.Tienda.paginacompra', compact('data', 'plans', 'tipoplan', 'empresas'));
    }


    //almacenamiento del data
    public function Storee(TiendaRequest $request)
    {

        return response()->json($this->CreateData($request), 201);
    }



    public function adminplanindex()
    {

        return view('cruds.Tienda.adminplan.admincompra');
    }


    public function MiadminPlan()
    {
        return view('cruds.Tienda.adminplan.miadminplan');
    }

    //redirecciona a la vista de los detalles de la compra del cliente
    // a la cual no se le ha asignado ningun especialista
    public function Showdetalle($id)
    {
        $compra = Shop::with([
            'tipoplan' => function ($query) {
                $query->select('id', 'nombre');
            },
            'tipoplan.planes',
            'subservicio' => function ($query) {
                $query->select('id', 'nombre', 'descripcion');
            },
            'cliente' => function ($query) {
                $query->select('id', 'name', 'email');
            },
            'plan' => function ($query) {
                $query->select('id', 'descripcion');
            }

        ])->find($id);
        // dd($compra);
        return view('cruds.Tienda.adminplan.show.showplangeneral', compact('compra'));
    }

    //function para visualizar el detalle de cada compra por parte de la lista de especialista acoplada
    public function Showdetalleindividual($id)
    {
        $compra = Shop::with([
            'tipoplan' => function ($query) {
                $query->select('id', 'nombre');
            },
            'tipoplan.planes',
            'subservicio' => function ($query) {
                $query->select('id', 'nombre', 'descripcion');
            },
            'cliente' => function ($query) {
                $query->select('id', 'name', 'email');
            },
            'plan' => function ($query) {
                $query->select('id', 'descripcion');
            },
            'especialista' => function ($query) {
                $query->select('id', 'name');
            }

        ])->find($id);
        $empresasUser = UserEmpresa::where('user_id', $compra->cliente->id)->get();

        return view('cruds.Tienda.adminplan.show.showplanindividual', compact('compra', 'empresasUser'));
    }

    public function ListaPlanesCliente()
    {

        return view('cruds.cliente.listacompra');
    }

    /* public function store(Request $request)
    {
        $max_size = (int)ini_get('upload_max_filesize') * 10240;
        $files = $request->file('files');
        $user_id = Auth::id();



        if ($request->hasFile('files')) {
            foreach ($files as $file) {
                $fileName = Str::slug($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension() ;

                if (Storage::putFileAs('/public/' . $user_id . '/', $file, $fileName)) {
                    DocumentosInteraccion::create([
                        'user_id'               => $user_id,
                        'nombre'                => $fileName,
                    ]);
                }
            }

            return back();

        } else {
            return 'Error';
        }

    } */


    public function store(Request $request)
    {
        $max_size = (int)ini_get('upload_max_filesize') * 10240;
        $files = $request->file('files');
        $user_id = Auth::id();



        if ($request->hasFile('files')) {
            foreach ($files as $file) {
                $fileName = Str::slug($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension() ;

                if (Storage::putFileAs('/public/' . $user_id . '/', $file, $fileName)) {
                    DocumentosInteraccion::create([
                        'user_id'               => $user_id,
                        'nombre'                => $fileName,
                    ]);
                }
            }

            return back();

        } else {
            return 'Error';
        }

    }




    //funcion para la interaccion con el cliente
    public function InteraccionEspecialista($id)
    {
        $compra = Shop::with([
           /*  'users' => function ($query) {
                $query->select('id', 'nombre');
            }, */
            'tipoplan' => function ($query) {
                $query->select('id', 'nombre');
            },
            'cliente' => function ($query) {
                $query->select('id', 'name', 'email');
            },

        ])->find($id);
        
        return view('cruds.Tienda.adminplan.especialistainteraccion', compact('compra'));
        /* return view('cruds.Tienda.adminplan.especialistainteraccion'); */
    }

    public function consultaEmpresa(Request $request){

        $user_id = Auth::id();
        $flagEmpresa = false;
        $empresa_id = $request->empresa;
        
        if($request->empresa == 0){
            $userEmpresa = UserEmpresa::where('user_id',$user_id)->first();
            $empresa_id = $userEmpresa->id;
        }

        $compra = Shop::select('*')
                        ->where('user_id', $user_id)
                        ->where('tipoplan_id', $request->tipoplan_id)
                        ->where('plan_id', $request->plan_id)
                        ->where('subservice_id', $request->subservice_id)
                        ->where('user_empresas_id', $empresa_id)
                        ->get();

        $empresa = UserEmpresa::where('id',$empresa_id)->first();

        if($compra->count() > 0)
        {
            $flagEmpresa = true;
        }

        $result = array("flag" => $flagEmpresa, "empresa" => $empresa->razon_social);

        return response()->json($result, 201);
    }
}
