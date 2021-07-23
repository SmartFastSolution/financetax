<?php

namespace App\Http\Livewire\Admin\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use App\User;

class DatosPersonales extends Component
{   
 
     public $user, $telefono, $fecha_n, $ciudad, $domicilio ;

    public function render()
    {   $this->user      = Auth::user();
        $this->name      = $this->user->name;
        $this->telefono  = $this->user->telefono;
        $this->fecha_n   = $this->user->fecha_n;
        $this->ciudad    = $this->user->ciudad;
        $this->domicilio = $this->user->domicilio;

        return view('livewire.admin.user.datos-personales');
    }

    public function ActualizarDatos(){

       

        $user  = Auth::user();
        $user->telefono   = $this->telefono;
        $user->fecha_n    = $this->fecha_n;
        $user->ciudad     = $this->ciudad;
        $user->domicilio  = $this->domicilio;
        $user->save();
        $this->ResetInput();

        $this->emit('info',['mensaje' => 'Datos Actualizados Correctamente']);
    }


    public function ResetInput(){
        $this->telefono = null;
        $this->fecha_n  = null;
        $this->ciudad   = null;
        $this->domicilio = null;
    }
}
