<div>
        @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
         @endif
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-0 col-12">
                    <label>Seleccionar Documento &nbsp;</label>
                    <input type="file" class="form-control" min="0" wire:model.defer="documento">
                    @error('documento') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>  
            <div class=" text-center">
                <button type="button" class="btn btn-outline-dark" wire:click.prevent="ImportarRazonCorriente()" >Importar Documento</button>
            </div>
        </div>
    </div>
    

</div>
