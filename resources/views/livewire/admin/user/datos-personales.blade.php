<div>
    <form method="post" class="needs-validation">
        <div class="card-header">
            <h4>Editar Datos Personales</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6 col-12">
                    <label>Nombres</label>
                    <input type="text" disabled="" class="form-control" value="{{ $user->name }}">
                </div>
                <div class="form-group col-md-6 col-12">
                    <label>Correo Electrónico</label>
                    <input type="text" class="form-control text-dark" disabled="" value="{{ $user->email }}">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6 col-12">
                    <label>Telefóno</label>
                    <input type="tel" class="form-control" min="0" wire:model.defer="telefono">

                </div>
                <div class="form-group col-md-6 col-12">
                    <label>Ciudad</label>
                    <input type="text" class="form-control" wire:model.defer="ciudad">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-12">
                    <label>Domicilio</label>
                    <input type="text" class="form-control" wire:model.defer="domicilio">
                </div>
            </div>
            <div class="row">
                <div class="form-group mb-0 col-12">
                    <label>Fecha Nacimiento</label>
                    <input type="date" class="form-control" wire:model.defer="fecha_n">
                </div>
            </div>     
        </div>
        <div class="card-footer text-center">
            <button class="btn btn-primary" wire:click.prevent="ActualizarDatos">Actualizar</button>
        </div>
    </form>
</div>
