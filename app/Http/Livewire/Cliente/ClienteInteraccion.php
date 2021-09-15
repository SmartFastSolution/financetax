<?php

namespace App\Http\Livewire\Cliente;

use App\Interaccion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ClienteInteraccion extends Component
{
    public $cliente;
    public $interaccion;
    public $mensajes;


    public function mount()
    {
        $this->id = Auth::user()->id;
        $this->actualizarBandeja();
    }


    public function render()
    {
        $data = Interaccion::where('cliente_id', $this->id)->get();
        //dd($data);
        return view('livewire.cliente.cliente-interaccion', compact('data'));
    }


    public function actualizarBandeja()
    {
        /* Se traen los datos de la tabla Interacción */
        $mensajes = Interaccion::where('cliente_id', $this->cliente)
            ->get();
        /* dd($mensajes); */
    }
}
