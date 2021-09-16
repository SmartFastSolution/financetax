<div>
    <div>
        <h2> </h2>
        <div class="card">
            <div class="card-body">
                <div class="row table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-center ">
                                    Detalle
                                </th>
                                <th class="px-4 py-2 text-center ">
                                    Observacion
                                </th>
                                <th class="px-4 py-2 text-center ">
                                    Fecha
                                </th>
                                <th class="px-4 py-2 text-center" colspan="3">Descarga</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data as $p)
                            <tr>
                                <td class="text-center">{{ $p->detalle }}</td>
                                <td class="text-center" >{{ $p->observacion }}</td>
                                <td class="text-center" >{{ $p->fecha }}</td>

                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
