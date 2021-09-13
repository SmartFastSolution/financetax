<!-- <div>
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="enviarMensaje" method="POST" enctype="multipart/form-data" class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" class="form-control" placeholder=" {{$compra->especialista->name}}" disabled aria-label="First name" />
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="periodo" class="col-sm-2 col-form-label">Día</label>
                                    <div class="col-sm-10">
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
                                        <label  class="form-label">Observación</label>
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
 -->

 <h2> Interaccion </h2>
