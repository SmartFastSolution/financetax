@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card author-box">
                        <div class="card-body">
                            <div class="author-box-center">
                                @if (Auth::user()->image)
                                <img src="{{url(Auth::user()->image)}}" border="1" alt="avatar"width="100px" height="100px">
                                @endif
                                                            
                                                           
                                <div class="clearfix"></div>
                                <div class="author-box-name">
                                    <a href="#">{{ Auth::user()->name }}</a>
                                </div>
                                <div class="author-box-job">{{ Auth::user()->roles[0]->name }}</div>
                            </div>
                            <div class="text-center">
                                <div class="author-box-description">
                                    {{-- texto para detalle --}}
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Detalles Personales</h4>
                        </div>
                        <div class="card-body">
                            <div class="py-4">
                                <p class="clearfix">
                                    <span class="float-left">
                                        Fecha Nacimiento
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ Auth::user()->fecha_n }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Telefóno
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ Auth::user()->telefono }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Correo
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ Auth::user()->email }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Ciudad
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ Auth::user()->ciudad }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-8">
                    <div class="card">
                        <div class="padding-20">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#datos-personales"
                                        role="tab" aria-selected="true">Datos Personales</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#password" role="tab"
                                        aria-selected="false">Contraseña</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#foto-perfil" role="tab"
                                        aria-selected="false">Foto Perfil</a>
                                </li>
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade show active" id="datos-personales" role="tabpanel"
                                    aria-labelledby="home-tab2">
                                    @livewire('admin.user.datos-personales')
                                </div>

                                <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="profile-tab2">
                                    @livewire('admin.user.contrasena')
                                </div>
                                <div class="tab-pane fade" id="foto-perfil" role="tabpanel" aria-labelledby="profile-tab3">
                                    @livewire('admin.user.foto-perfile')
                                </div>      
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
