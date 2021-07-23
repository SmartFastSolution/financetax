<div>
    <div>
        <div class="card">
        </div>
        <div class="card">
            <div class="card-header">
                <h2>Lista de Usuarios</h2>
            </div>
            <div class="card-body">
                <table class="table table-hover ">
                    <h5>Asignar Rol a Usuarios</h5>
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre(s)</th>
                            <th>Email</th>
                            <th colspan="3">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $c)
                        <tr>
                            <td>{{$c->id}}</td>
                            <td>{{$c->name}}</td>
                            <td>{{$c->email}}</td>
                            <td width="10px">
                                <button wire:click="edit({{$c->id}})" class="btn btn-primary">
                                    Editar
                                </button>
                            </td>
                            <!-- modal para livewire prueba  -->
                            <td width="10px">
                                <!-- <button wire:click.prevent="edit({{$c->id}})" type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#exampleModal">Edit</button> -->
                                <button wire:click.prevent="edit({{$c->id}})" type="button"
                                    class="btn btn-success">Edit</button>
                            </td>
                            <td width="10px">
                                <button wire:click="destroy({{$c->id}})" class="btn btn-danger">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>


<!-- en pausa lo del modal de usuario   -->


<!-- modal para livewire prueba  -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModal">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="">
                    <div class="form-group">
                        <label>Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" placeholder="Email" name="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </div>
                            </div>
                            <input type="password" class="form-control" placeholder="Password" name="password">
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="remember" class="custom-control-input" id="remember-me">
                            <label class="custom-control-label" for="remember-me">Remember Me</label>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary m-t-15 waves-effect">LOGIN</button>
                </form>
            </div>
        </div>
    </div>
</div>