<div>
   <div class="card">
      <div class="card-body">

          <div class="row mb-4 justify-content-between">
              <div class="col-lg-4 form-inline">
                  Por Pagina: &nbsp;
                  <select wire:model="perPage" class="form-control form-control-sm">
                      <option>10</option>
                      <option>15</option>
                      <option>25</option>
                  </select>
              </div>

              <div class="col-lg-3">
                  <input wire:model="search" class="form-control" type="text" placeholder="Buscar Subservicio...">
              </div>
          </div>

          <div class="row table-responsive">
              <table class="table table-striped">
                  <thead>
                      <tr>
                          <th class="px-4 py-2 text-center ">
                              Especialista
                              <a class="text-primary" wire:click.prevent="sortBy('especialista')" role="button">

                                  @include('includes._sort-icon', ['field' => 'especialista'])
                              </a>
                          </th>
                          <th class="px-4 py-2 text-center ">
                              SubServicio
                              <a class="text-primary" wire:click.prevent="sortBy('sub')" role="button">

                                  @include('includes._sort-icon', ['field' => 'sub'])
                              </a>
                          </th>
                          <th class="px-4 py-2 text-center ">
                              Tipo Plan
                              <a class="text-primary" wire:click.prevent="sortBy('tipoplan')" role="button">

                                  @include('includes._sort-icon', ['field' => 'tipoplan'])
                              </a>
                          </th>
                          <th class="px-4 py-2 text-center">Costo</th>
                          <th class="px-4 py-2 text-center">Estado</th>
                          <th class="px-4 py-2 text-center" colspan="3">Acción</th>
                      </tr>
                  </thead>
                  <tbody>
                      @if ($data->isNotEmpty())
                            @foreach ($dataEmpresas as $info => $empresa)
                            <tr>
                                <td class="text-center " colspan="8" style="background: aliceblue;"><b>{{ strtoupper($info) }}</b></td>
                            </tr>
                            @foreach ($empresa as $compra)
                                <tr>
                                  <td class="text-center ">{{ $compra->especialista }}</td>
                                  <td class="text-center ">{{ $compra->sub }}</td>
                                  <td class="text-center ">{{ $compra->tipoplan }}</td>
                                  <td class="text-center ">${{ $compra->costo }}</td>

                                    @switch($compra->estado)
                                        @case("pendiente")badge  badge-succes
                                            <td class="text-center "><span class="badge badge-primary">{{ ucfirst($compra->estado) }}</span></td>
                                        @break

                                        @case("aprobada")
                                            <td class="text-center "><span class="badge badge-success">{{ ucfirst($compra->estado) }}</span></td>
                                        @break

                                        @case("en proceso")
                                            <td class="text-center "><span class="badge badge-warning">{{ ucfirst($compra->estado) }}</span></td>
                                        @break
                                    @endswitch

                                  <td width="10px">
                                      <button class="btn btn-icon icon-left btn-primary" data-toggle="modal"
                                          data-target="#Show" wire:click.prevent="Show({{ $compra->id }})">
                                          <i class="fas fa-eye"></i>

                                      </button>
                                  </td>
                                  <td width="10px">
                                  <button class="btn btn-icon icon-left btn-primary"
                                           wire:click.prevent="Interaccion({{ $compra->id }})">
                                          <i class="fas fa-inbox"></i>
                                      </button>
                                  </td>
                                  <td width="50px">
                               
                                  <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Servicios
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @isset($acciones[$compra->id])
                                        @foreach ($acciones[$compra->id] as $accion)
                                            @if($accion == "/admin/ingreso_facturas/sri")
                                                <a class="dropdown-item" href="{{ $accion }}/{{ $compra->id_subservice }}/{{ $compra->id_tipoplan }}/{{ $compra->userEmpresa }}">{{$rutasNombre[$accion]}}</a>
                                            @else
                                                <a class="dropdown-item" href="{{ $accion }}/{{ $compra->id_subservice }}/{{ $compra->id_tipoplan }}/{{ $compra->userEmpresa }}">{{$rutasNombre[$accion]}}</a>
                                            @endif
                                        @endforeach
                                    @endisset
                                    </div>
                                    </div>
                                   
                                  </td>
                                  </tr>
                            @endforeach
                            
                            @endforeach
                      @else
                          <tr>
                              <td colspan="10">
                                  <p class="text-center">No hay resultado para la busqueda
                                      <strong>{{ $search }}</strong> en la pagina
                                      <strong>{{ $page }}</strong> al mostrar
                                      <strong>{{ $perPage }} </strong> por pagina
                                  </p>
                              </td>
                          </tr>
                      @endif
                  </tbody>
              </table>
          </div>
          <div class="row">
              <div class="col">
                  {{ $data->links() }}
              </div>
              <div class="col text-right text-muted">
                  Mostrar {{ $data->firstItem() }} a {{ $data->lastItem() }} de
                  {{ $data->total() }} registros
              </div>
          </div>
      </div>
  </div>
</div>
