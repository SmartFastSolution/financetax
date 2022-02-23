@extends('layouts.app')

@section('content')

<h1 class="text-center font-weight-bold">Lista de Servicios</h1>

<div class="row">
    @if ($data->isNotEmpty())
    @foreach ($data as $p)
    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
      <article class="article article-style-b">
        <div class="article-header">
          <div class="article-image" data-background="">
            @isset($p->documento->archivo)
            <img class="article-image" src="{{$p->documento->archivo}}" alt="">
            @endisset 
          </div>
          <div class="article-badge">
         
          </div>
        </div>
        <div class="article-details" style="height: 250px;">
          <div class="article-title">
            <h2><b><a href="{{route('subservicios', $p->slug)}}">{{$p->nombre}}</a></b></h2>
          </div>
          <p>
            {!!htmlspecialchars_decode($p->descripcion)!!}
          </p>
          <div class="article-cta article-bottom">
            <a class="btn btn-outline-primary" role="button" aria-pressed="true" href="{{route('subservicios', $p->slug)}}">
              Mostrar Subservicios&nbsp;<i class="fas fa-arrow-right"></i>
            </a>
          </div>
        </div>
      </article>
    </div>
    @endforeach
    @endif
</div>
<div class="row">
    <div class="col-center">
        {{ $data->links() }}
    </div>
    <div class="col text-right text-muted">
        Mostrar {{ $data->firstItem() }} a {{ $data->lastItem() }} de
        {{ $data->total() }} registros
    </div>
</div>




@endsection