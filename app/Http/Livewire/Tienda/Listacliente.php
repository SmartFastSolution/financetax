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
    public $condicional;
    
    //LISTA DE LOS PLANES DE LOS CLIENTES- SOLICITUD DE COMPRA

    public function mount($condicional=false){
        $this-> uid = Auth::user()->id;
        $this->condicional = $condicional;

    }

    public function render()
    {
        $data = Shop::where('user_id', $this->uid)
        ->join('users','shops.especialista_id', '=','users.id')
        ->join('subservices','shops.subservice_id', '=','subservices.id')
        ->join('tipoplans','shops.tipoplan_id','=','tipoplans.id')
        ->where(function($query){
            $query->where('subservices.nombre', 'like', '%' . $this->search . '%')
            ->orWhere('users.name', 'like', '%' . $this->search . '%');
        })
        ->where('shops.estado','!=','pendiente')
        ->where(function ($query) {
            if ($this->condicional) {
                $query->where('shops.estado', 'aprobada');
            } else {
                $query->where('shops.estado', '!=', 'aprobada');
            }
        })
        ->select('shops.*','subservices.nombre as sub','tipoplans.nombre as tipoplan','users.name as especialista')
         ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
         ->paginate($this->perPage);
        //  ->get();
        // dd($data);
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
