<?php

namespace App\Http\Livewire\Indicador;

use App\Imports\RazoncorrienteImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class RazonCorriente extends Component
{
    use WithFileUploads;

    public $documento;

    public function render()
    {
        return view('livewire.indicador.razon-corriente');
    }

    public function ImportarRazonCorriente(){

        $this->validate([
            'documento'          =>'max:154000|mimes:xlx,xls,xlsx'
        ],[
            'documento.required'                     => 'Seleccione un Archivo Excel ',
        ]);

        //dd($this->documento);
        Excel::import(new RazoncorrienteImport, $this->documento);
        session()->flash('message', 'Datos Importado Correctamente.');
    }


}
