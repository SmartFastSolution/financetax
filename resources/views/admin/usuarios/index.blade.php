@extends('layouts.app')

@section('content')
<h1 class="text-center font-weight-bold">Administración de Usuarios</h1>


<div class="card">
    <div class="card-header">
      <h4>Lista de Usuarios</h4>
    </div>      
    @livewire('admin.usuario')
    
</div> 



@endsection