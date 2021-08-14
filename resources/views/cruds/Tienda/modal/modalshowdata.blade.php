<div wire:ignore.self class="modal fade" id="Show" tabindex="-1" data-backdrop="static" data-keyboard="false"
    role="dialog" aria-labelledby="createPostLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="exampleModalLabel">Datos de Compra</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>Costo</label>
                    <input wire:model.defer="costo" type="text" class="form-control" disabled>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
        </div>
    </div>
</div>
