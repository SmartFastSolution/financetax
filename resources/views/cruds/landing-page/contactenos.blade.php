@extends('layouts.digital.digital')


@section('header')
    <div class="row">
        <div class="col-md-12">
            <div class="header-carousal owl-carousel owl-theme">
                <div class="item">

                    <h2>CONTACTENOS</h2>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('content')

<section class="contact-area">
    <h2>CONTACTOS</h2>
    <div class="about-icon">
        <img src="img/section-icon.jpg" alt="">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-4">
                <div class="contact-part">
                    <h4><i class="fa fa-map-marker" aria-hidden="true"></i>NUESTRA DIRECCIÓN</h4>
                    <P>AV. 9 de Octubre xxx</P>
                    <P>Padre losano y xxx</P>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="contact-part">
                    <h4><i class="fa fa-phone" aria-hidden="true"></i>LLAMANOS AL </h4>
                    <p>+593 XXXXXXXX</p>
                    <p>+593 XXXXXXXX</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="contact-part">
                    <h4><i class="fa fa-envelope" aria-hidden="true"></i>CONTACTANOS AL CORREO:</h4>
                    <p>solutionfinacetax@gmail.com</p>
                    <p>solutionfinance@gmail.com</p>
                    <p></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="contact-form">
                    <h2>FORMULARIO</h2>
                    <form action="#" method="post">
                        <input type="text" placeholder="Nombres">
                        <input type="email" placeholder="Correo Electronico">
                        <textarea placeholder="Mensaje"></textarea>
                        <input type="submit" value="Enviar">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection