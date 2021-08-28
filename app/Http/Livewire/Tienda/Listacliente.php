<?php

namespace App\Http\Livewire\Tienda;

use App\Tienda\Shop;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Listacliente extends Component
{
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
    
    //LISTA DE LOS PLANES DE LOS CLIENTES- SOLICITUD DE COMPRA

    public function mount(){
        $this-> uid = Auth::user()->id;

    }

    public function render()
    {
        $data = Shop::join('users','shops.user_id','=','users.id')
        ->join('subservices','shops.subservice_id','=','subservices.id')
        ->join('services','subservices.service_id','=','services.id')
        ->join('tiposervicios','services.tiposervicio_id','=','tiposervicios.id')
        ->join('tipoplans','shops.tipoplan_id','=','tipoplans.id')
        ->where('user_id', $this->uid)
        ->where('shops.estado', 'aprobada')
        ->where(function($query){
            $query->where('subservices.nombre', 'like', '%' . $this->search . '%')
            ->orWhere('users.name', 'like', '%' . $this->search . '%')
            ->orWhere('tipoplans.nombre', 'like', '%' . $this->search . '%');
        })
         ->select('shops.*','users.name as cliente','subservices.nombre as sub', 'tipoplans.nombre as ti')
         
         ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
         ->paginate($this->perPage);
        //dd($data);
        return view('livewire.tienda.listacliente', compact('data'));
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
}
