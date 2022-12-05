<div wire:ignore.self class="modal fade bd-example-modal-lg" id="modalInteraccion" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="myLargeModalLabel">Enviar Mensaje</h5>


                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <label>Especialista</label>
                        <input disabled type="text" class="form-control  wire:model.defer=" especialista_id" placeholder="{{ $compra->especialista->name }}">

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
                        <textarea class="form-control" wire:model.defer="observacion" class="form-control @error('detalle') is-invalid @enderror" id="" cols="30" rows="5"></textarea>
                        @error('observacion')
                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label class="font-weight-bold text-dark" for="inputPassword4">Documentos</label>
                        <input type="file" wire:model.defer="documentos" multiple>
                        @error('documentos')
                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="modal-footer br">

                <button type="submit"  @if ($createMode) disabled @endif wire:click="enviarMensaje" class="btn btn-success">Enviar Mensaje</button>
            </div>
        </div>
    </div>
</div>
