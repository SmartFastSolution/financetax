@extends('layouts.app')
@section('content')
<div id="app">
    <h1 class="text-center font-weight-bold">Comprobantes Electr&oacute;nicos</h1>
    <h5 class="text-center"><b>Empresa:</b>&nbsp;{{$razonSocial}}&nbsp;&nbsp;&nbsp;<b>RUC:</b>&nbsp;{{$ruc}}</h5>
    <input type="text" id="inputTipoPlan" name="inputTipoPlan" hidden>
    <input type="text" id="inputSubservicio" name="inputSubservicio" hidden>
    <input type="text" id="inputUsuarioEmpresa" name="inputUsuarioEmpresa" hidden>
    <comprobantesri-component />
</div>
<script>
    const urlArray = window.location.href.split("/");
    var tipoPlan = urlArray[urlArray.length - 2];
    var subservicio = urlArray[urlArray.length - 3];
    var usuarioEmpresa = urlArray[urlArray.length - 1];

    document.getElementById('inputTipoPlan').value=tipoPlan;
    document.getElementById('inputSubservicio').value=subservicio;
    document.getElementById('inputUsuarioEmpresa').value=usuarioEmpresa;
</script>
@endsection
