<?php

namespace App\Http\Livewire\Servicios\Servicios;

use App\Servicios\Service;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Servicio extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarService'];
    protected $queryString     =['search' => ['except' => ''],
    'page',
];

public $perPage         = 10;
public $search          = '';
public $orderBy         = 'id';
public $orderAsc        = true;
public $estado          = 'activo';
public $editMode        = false;

public $service_id      = '';
public $nombre, $descripcion, $image;

    public function render()
    {   
        $data = Service::where(function($query){
            $query->where('services.nombre', 'like','%'.$this->search.'%');
        })->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

        return view('livewire.servicios.servicios.servicio', compact('data'));
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

    public function estadochange($id)
   {

       $estado = Service::find($id);
       $estado->estado = $estado->estado == 'activo' ? 'inactivo' : 'activo';
       $estado->save();

        $this->emit('info',['mensaje' => $estado->estado == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);

   }

   public function resetModal(){
    $this->reset(['nombre', 'descripcion','image','editMode']);;
    $this->resetValidation();
   }


    public function createService(){
      
        $this->validate([
            'nombre'        =>'required',
            'descripcion'   =>'required',
            'image'         =>'required|image|max:4080',

        ],[
            'nombre.required'           => 'No has agregado el nombre del Servicio',
            'descripcion.required'      => 'No has agregado la Descripción',
            'image.required'            => 'No ha Seleccionado la Imagen',
        ]);

       
        $imagen =  $this->image->store("/Imagenes" , 'public_upload');

        $s  = new Service;
        $s->nombre  = $this->nombre;
        $s->descripcion  = $this->descripcion;
        $s->estado       = $this->estado == 'activo' ? 'activo' : 'inactivo';
        $s->image       = $imagen;
        $s->save();
        $this->resetModal();
        $this->emit('success',['mensaje' => 'Servicio Creado Correctamente', 'modal' => '#createService']);
       
    }

    public function editService($id)
    {
        $c                    = Service::find($id);
        $this->service_id     =$id;
        $this->nombre         =$c->nombre;
        $this->descripcion    =$c->descripcion;
        $this->estado         =$c->estado;
        $this->image          =$c->image;
        $this->editMode       =true;
   }

   public function updateService(){
        
    $this->validate([
        'nombre'        =>'required',
        'descripcion'   =>'required',
        'image'         =>'image|max:4080',

    ],[
        'nombre.required'           => 'No has agregado el nombre del Servicio',
        'descripcion.required'      => 'No has agregado la Descripción',
        
    ]);
   
    $imagen =  $this->image->store("/Imagenes" , 'public_upload');
  

    $s              = Service::find($this->service_id);
    $s->nombre      = $this->nombre;
    $s->descripcion = $this->descripcion;
    $s->estado      = $this->estado;
    $s->image       = $imagen;
    $s->save();
    $this->resetModal();
    $this->emit('info',['mensaje' => 'Servicio Actualizada Correctamente', 'modal' => '#createService']);
   }



    public function eliminarService($id)
   {
       $c = Service::find($id);
       $c->delete();
       $this->emit('info',['mensaje' => 'Servicio Eliminada Correctamente']);
   }


}
