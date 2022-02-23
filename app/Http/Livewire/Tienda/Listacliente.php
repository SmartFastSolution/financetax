<?php

namespace App\Http\Livewire\Tienda;

use App\Tienda\Shop;
use App\Accion;
use App\UserEmpresa;
use App\Servicios\ServicioAccion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Listacliente extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $queryString     = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];

    public $perPage         = 10;
    public $search          = '';
    public $orderBy         = 'shops.id';
    public $orderAsc        = true;
    public $uid;
    public $condicional;

    //prueba para el modal
    public $user;
    public $detalle;
    public $observacion;
    public $documento = [];

    //LISTA DE LOS PLANES DE LOS CLIENTES- SOLICITUD DE COMPRA

    public function mount(){
        $this-> uid = Auth::user()->id;


    }

    public function render()
    {
        $rutas = [];
        $acciones = [];
        $nombres = [];
        $dataEmpresas = [];
        $data = Shop::where('user_id', $this->uid)
        ->join('users','shops.especialista_id', '=','users.id')
        ->join('subservices','shops.subservice_id', '=','subservices.id')
        ->join('tipoplans','shops.tipoplan_id','=','tipoplans.id')
        ->where(function($query){
            $query->where('subservices.nombre', 'like', '%' . $this->search . '%')
            ->orWhere('users.name', 'like', '%' . $this->search . '%');
        })
        ->where('shops.estado','!=','pendiente')
        ->select('shops.*','subservices.nombre as sub','tipoplans.nombre as tipoplan','users.name as especialista',
                 'subservices.id as id_subservice', 'tipoplans.id as id_tipoplan', 'tipoplans.id as id_tipoplan')
         ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
         ->paginate($this->perPage);

        $rutasNombre    = Accion::pluck('descripcion','ruta');
        $EmpresasNombre = UserEmpresa::where('user_id', $this->uid)->pluck('razon_social', 'id');

        foreach ($data as $key => $value) {
            $servicioAccion = ServicioAccion::where('plan_id', $value->plan_id)
                            ->join('acciones','servicio_accion.accion_id', '=','acciones.id')
                            ->select('servicio_accion.*','acciones.ruta as ruta', 'acciones.descripcion as nombreRuta')->get();
            if(!$servicioAccion->isEmpty()){
                foreach ($servicioAccion as $keyserv => $valueserv) {
                    array_push($rutas, $valueserv->ruta);
                }
                $acciones[$value->id] = $rutas;
            }
        }

        foreach ($EmpresasNombre as $keyEn => $valueEn) {
            $dataEmpresas[$valueEn] = Shop::where('user_id', $this->uid)
                    ->join('users','shops.especialista_id', '=','users.id')
                    ->join('subservices','shops.subservice_id', '=','subservices.id')
                    ->join('tipoplans','shops.tipoplan_id','=','tipoplans.id')
                    ->where(function($query){
                        $query->where('subservices.nombre', 'like', '%' . $this->search . '%')
                        ->orWhere('users.name', 'like', '%' . $this->search . '%');
                    })
                    ->where('shops.estado','!=','pendiente')
                    ->where('user_empresas_id', $keyEn)
                    ->select('shops.*','subservices.nombre as sub','tipoplans.nombre as tipoplan','users.name as especialista',
                            'subservices.id as id_subservice', 'tipoplans.id as id_tipoplan', 'tipoplans.id as id_tipoplan', 'shops.user_empresas_id as userEmpresa')
                    ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);
        }

        return view('livewire.tienda.listacliente', compact('data', 'acciones', 'rutasNombre', 'EmpresasNombre', 'dataEmpresas'));
    }


    public function sortBy($field)
    {
        if ($this->orderBy === $field) {
            $this->orderAsc = !$this->orderAsc;
        } else {
            $this->orderAsc = true;
        }
        $this->orderBy = $field;
    }

    //function para la vista de detalle de la compra realizada por el cliente
    public function Show($id){

        return redirect()->route('cliente.detalle.compra', $id);

    }
    //function dedicada para la interaccion entre el cliente y especialista
    public function Interaccion($id){
        return redirect()->route('cliente.interaccion', $id);
    }


}
