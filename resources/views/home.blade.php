@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="jumbotron text-center" id="jumbotron-home">
            <br>
            <h3>{{ __('Bienvenido') }} {{$usuario->name}}</h3>
            <p>&Uacute;ltima sesi&oacute;n:&nbsp;{{date_format(date_create($usuario->access_at),"d/m/Y H:i")}}</p>
        </div>
            {{--<div class="card">
                <div class="card-header"><b></b></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
                </div>--}}
        </div>
    </div>
@endsection
