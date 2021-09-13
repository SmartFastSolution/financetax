<?php

namespace App\Http\Livewire\Cliente;

use Livewire\Component;
use App\Tienda\Shop;
class Interaccion extends Component
{
    public $compra='';

    public function mount(Shop $compra){

        $this->compra = $compra;
    }
    public function render()
    {


        return view('livewire.cliente.interaccion');
    }
}
