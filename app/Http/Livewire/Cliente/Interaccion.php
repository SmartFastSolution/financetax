<?php

namespace App\Http\Livewire\Cliente;

use Livewire\Component;
use App\Tienda\Shop;
use Livewire\WithFileUploads;

class Interaccion extends Component

{
    use WithFileUploads;

    public $compra = '';

    public $user;
    public $detalle;
    public $observacion;
    public $documento = [];

    public function mount(Shop $compra)
    {

        $this->compra = $compra;
    }
    public function render()
    {
        return view('livewire.cliente.interaccion');
    }

    public function enviarMensaje()
    {
        $validatedData = $this->validate([
            'user' => 'required',
            'documento' => 'pdf,docx|max:1024'
            /* Podriamos validar otras cosas  */
        ]);


        /* Se barre los archivos */
        /*  foreach ($this->documento as $key => $documento) {
            $this->documento[$key] = $documento->store('documento','public');
        } */

        foreach ($this->documento as $key => $documento) {
            $this->documento[$key] = $documento->store('documentos','public');
        }
        // Guardamos el mensaje en la BBDD
        \App\Interaccion::create([
            "user" => $this->user,
            "detalle" => $this->detalle,
            "observacion" => $this->observacion,
            "documento" => $this->documento,
        ]);

        // Este evento es para que lo reciba el componente
        // por Javascript y muestre el ALERT BOOSTRAP de "enviado"
        session()->flash('message', 'File uploaded.');
    }
}
