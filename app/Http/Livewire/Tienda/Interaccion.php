<?php

namespace App\Http\Livewire\Tienda;

use App\Interaccion as AppInteraccion;
use Livewire\Component;
use App\Tienda\Shop;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class Interaccion extends Component

{
    use WithFileUploads;

    public $compra = '';
    public $cliente;
    public $shop;


    //prueba para la bandeja
    public $mensajes;


    //prueba para el modal
    public $detalle = '';
    public $fecha;
    public $observacion = '';
    public $documento = []; //es un array
    public $createMode = false;

    public function mount(Shop $compra)
    {
        $this->cliente = $compra->cliente->id;
        $this->shop = $compra->id;
        $this->compra = $compra;

        $this->mensajes = [];

    }


    public function render()
    {
        $data = Shop::where('user_id', $this->cliente)
            ->where('id', $this->shop)
            ->get();
        //dd($data);
        return view('livewire.tienda.interaccion', compact('data'));
    }



    public function resetModal()
    {
        $this->reset(['detalle', 'observacion', 'fecha']);
        $this->resetValidation();
    }

    public function enviarMensaje()
    {
        $this->validate([
            'detalle'     => 'required',
            'observacion'      => 'required',
            'fecha'      => 'required',
        ],[
            'detalle.required'        => 'No has agregado un Detalle ',
            'observacion.required'         => 'No has agregado una Observacion',
            'fecha.required'         => 'No has selecionado una Fecha',
        ]);


        $this->createMode = true;

        $message                       = new AppInteraccion;
        $message->especialista_id      = Auth::user()->id;
        $message->cliente_id           = $this->cliente;
        $message->fecha                = $this->fecha;
        $message->detalle              = $this->detalle;
        $message->observacion          = $this->observacion;
        $message->shop_id              = $this->shop;
        $message->save();
        $this->resetModal();
        $this->emit('success', ['mensaje' => 'Mensaje Enviado Correctamente', 'modal' => '#modalInteraccionEspecialista']);

        $this->createMode = false;
    }


}
