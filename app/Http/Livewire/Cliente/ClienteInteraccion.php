<?php

namespace App\Http\Livewire\Cliente;

use App\DocumentosInteraccion;
use App\Interaccion;
use App\Tienda\Shop;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ClienteInteraccion extends Component
{
    public $cliente;
    public $interaccion;
    public $mensajes;
    public $shop;
    public $compra = '';


    public function mount(Shop $compra)
    {
        $this->id = Auth::user()->id;
        $this->actualizarBandeja();
        $this->shop = $compra->id;
    }


    public function render()
    {
        //dd("render ClienteInteraccion");
        $data = Interaccion::where('cliente_id', $this->id)->where('shop_id', $this->shop)->get();

        // $data = Interaccion::where('cliente_id', $this->id)
        // ->with(['documentableinteraccion' => function (MorphTo $morphTo) {
        //     $morphTo->morphWith([
        //         DocumentosInteraccion::class => ['documentableinteraccion'],
        //     ]);
        // }])->get();


       // $documentos = DocumentosInteraccion::where('user_id', $this->id)->get();
         //dd($data);





        return view('livewire.cliente.cliente-interaccion', compact('data'));
    }


    public function actualizarBandeja()
    {
        //dd("actualizarBandeja ClienteInteraccion");
        /* Se traen los datos de la tabla Interacción */
        $mensajes = Interaccion::where('cliente_id', $this->cliente)->get();
        $documentos = DocumentosInteraccion::where('user_id', Auth::id())->get();
       /*  dd($documentos); */
    }

    public function enviarMensajeCliente()
    {
        $this->validate([
            'detalle'     => 'required',
            'observacion'      => 'required',
            //'fecha'      => 'required',
        ], [
            'detalle.required'              => 'No has agregado un Detalle ',
            'observacion.required'          => 'No has agregado una Observacion',
            //'fecha.required'                => 'No has selecionado una Fecha',

        ]);

        $this->createMode = true;


        $message                       = new AppInteraccion;
        $message->cliente_id           = Auth::user()->id;
        $message->especialista_id      = $this->especialista;
        $message->tipo                 = "C";
        $message->fecha                = Carbon::now();
        $message->detalle              = $this->detalle;
        $message->observacion          = $this->observacion;
        $message->shop_id              = $this->shop;
        $message->save();
        $documentos = $this->StoreMultipleDoc($message);
        $this->resetModal();
        $this->emit('success', ['mensaje' => 'Mensaje Enviado Correctamente', 'modal' => '#modalInteraccion']);

        $this->createMode = false;

        return redirect()->to('/tienda/interaccion-compra/35/show');
    }

    public function resetModal()
    {
        $this->reset(['createMode', 'detalle', 'observacion', 'fecha', 'documentos']);
        $this->resetValidation();
    }
}
