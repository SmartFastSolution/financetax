<?php

namespace App\Http\Livewire\Cliente;

use App\Interaccion as AppInteraccion;
use Livewire\Component;
use App\Tienda\Shop;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class Interaccion extends Component

{
    use WithFileUploads;

    public $compra = '';
    public $shop;
    public $especialista ;
    public $detalle ='';
    public $fecha;
    public $observacion ='';
    public $documento = [];//es un array
    public $createMode          = false;

    public function mount(Shop $compra)
    {
        $this-> especialista = $compra->especialista->id;
        $this-> shop = $compra->id;
        $this-> compra = $compra;
    }


    public function render()
    {
        $data = Shop::where('especialista_id', $this->especialista)
                    ->where('id', $this->shop)
            ->get();
            //dd($data);
        return view('livewire.cliente.interaccion', compact('data'));
    }


    public function resetModal(){
        $this->reset(['createMode','detalle','observacion','fecha']);
        $this->resetValidation();
    }

    public function enviarMensaje(){
        $this->createMode = true;
        $message                       = new AppInteraccion;
        $message->cliente_id           = Auth::user()->id;
        $message->especialista_id      = $this->especialista;
        $message->fecha                = $this->fecha;
        $message->detalle              = $this->detalle;
        $message->observacion          = $this->observacion;
        $message->save();
        $this->resetModal();
        $this->emit('success',['mensaje' => 'Mensaje Enviado Correctamente', 'modal' => '#SendMessage']);
        $this->createMode = false;
    }


}
