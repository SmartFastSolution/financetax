<div wire:ignore.self class="modal fade bd-example-modal-lg" id="modalInteraccionEspecialista" tabindex="-1" data-keyboard="false" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Enviar Mensaje - Especialista</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <label>Cliente</label>
                        <input disabled type="text" wire:model.defer="especialista_id" placeholder="{{ $compra->cliente->name }}" class="form-control @error('especialista_id') is-invalid @enderror">

                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-8">
                        <label>Detalle</label>
                        <input type="text" wire:model.defer="detalle" class="form-control @error('detalle') is-invalid @enderror" placeholder="Detalle">
                        @error('detalle')
                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label class="font-weight-bold text-dark" for="inputPassword4">Observaci&oacute;n</label>
                        <textarea class="form-control" name="" wire:model.defer="observacion" id="" cols="30" rows="5" placeholder="Observacion"></textarea>
                        @error('observacion')
                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group col-md-12">
                        <label class="font-weight-bold text-dark" for="inputPassword4">Documentos</label>
                        <input type="file" wire:model.defer="documentos" multiple>
                        @error('documentos')
                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>


            </div>
            <div class="modal-footer br">
            <button type="submit" wire:click="enviarMensaje" class="btn btn-success">Enviar Mensaje</button>

            </div>
        </div>
    </div>
</div>
