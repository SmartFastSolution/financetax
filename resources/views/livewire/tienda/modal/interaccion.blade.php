<div wire:ignore.self class="modal fade" id="modalInteraccion" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalPermisosLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h3 class="modal-title"> Modal Interacción </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-10">
                            <div class="card">
                                <div class="card-body">
                                    <form wire:submit.prevent="enviarMensaje" enctype="multipart/form-data" class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                            <input type="text" class="form-control" disabled aria-label="First name" />

                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="periodo" class="col-sm-4 col-form-label">Día</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control form-control-sm" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Detalle</label>
                                                    <textarea class="form-control" wire:model="detalle" rows="3"></textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <div class="mb-3">
                                                        <label class="form-label">Observación</label>
                                                        <textarea class="form-control" wire:model="observacion" rows="3"></textarea>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <div class="mb-3">
                                                        <label for="filename"> Elegir Documentos</label>
                                                        <input type="file" wire:model="documento" multiple class="form-control">
                                                        @error('documento') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-12 text-center">
                                                    <button class="btn btn-success" type="submit">Enviar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer br">
        </div>
    </div>
</div>
</div>
