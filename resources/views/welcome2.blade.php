<!DOCTYPE html>
<html lang="es">
<!-- Copied from http://radixtouch.in/templates/admin/aegis/source/light/carousel.html by Cyotek WebCopy 1.7.0.600, Saturday, September 21, 2019, 2:51:57 AM -->

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>INICIO</title>
    <!-- General CSS Files -->
    @laravelPWA
    <link rel="stylesheet" href=" {{ asset('aegis/source/light/assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('aegis/source/light/assets/css/style.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('aegis/source/light/assets/img/icono.ico') }}">
    <style type="text/css">
        a {
        color: inherit;
        }

        .menu-icon{
            font-size: 25px;
            padding-top: 10px;
        }

        .menu-text{
            font-size: 0.65rem;
        }

        .menu-item,
        .menu-open-button {
        background: black;
        border-radius: 100%;
        width: 80px;
        height: 80px;
        margin-left: -40px;
        position: absolute;
        color: #FFFFFF;
        text-align: center;
        line-height: 80px;
        -webkit-transform: translate3d(0, 0, 0);
        transform: translate3d(0, 0, 0);
        -webkit-transition: -webkit-transform ease-out 200ms;
        transition: -webkit-transform ease-out 200ms;
        transition: transform ease-out 200ms;
        transition: transform ease-out 200ms, -webkit-transform ease-out 200ms;
        }

        .menu-open {
        display: none;
        }

        .lines {
        width: 25px;
        height: 3px;
        background: lightgray;
        display: block;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-left: -12.5px;
        margin-top: -1.5px;
        -webkit-transition: -webkit-transform 200ms;
        transition: -webkit-transform 200ms;
        transition: transform 200ms;
        transition: transform 200ms, -webkit-transform 200ms;
        }

        .line-1 {
        -webkit-transform: translate3d(0, -8px, 0);
        transform: translate3d(0, -8px, 0);
        }

        .line-2 {
        -webkit-transform: translate3d(0, 0, 0);
        transform: translate3d(0, 0, 0);
        }

        .line-3 {
        -webkit-transform: translate3d(0, 8px, 0);
        transform: translate3d(0, 8px, 0);
        }

        .menu-open:checked + .menu-open-button .line-1 {
        -webkit-transform: translate3d(0, 0, 0) rotate(45deg);
        transform: translate3d(0, 0, 0) rotate(45deg);
        }

        .menu-open:checked + .menu-open-button .line-2 {
        -webkit-transform: translate3d(0, 0, 0) scale(0.1, 1);
        transform: translate3d(0, 0, 0) scale(0.1, 1);
        }

        .menu-open:checked + .menu-open-button .line-3 {
        -webkit-transform: translate3d(0, 0, 0) rotate(-45deg);
        transform: translate3d(0, 0, 0) rotate(-45deg);
        }

        .menu {
        margin: auto;
        /*position: absolute;*/
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        width: 80px;
        height: 80px;
        text-align: center;
        box-sizing: border-box;
        font-size: 26px;
        }


        /* .menu-item {
        transition: all 0.1s ease 0s;
        } */

        .menu-item:hover {
        background: #EEEEEE;
        color: #3290B1;
        }

        .menu-item:nth-child(3) {
        -webkit-transition-duration: 180ms;
        transition-duration: 180ms;
        }

        .menu-item:nth-child(4) {
        -webkit-transition-duration: 180ms;
        transition-duration: 180ms;
        }

        .menu-item:nth-child(5) {
        -webkit-transition-duration: 180ms;
        transition-duration: 180ms;
        }

        .menu-item:nth-child(6) {
        -webkit-transition-duration: 180ms;
        transition-duration: 180ms;
        }

        .menu-item:nth-child(7) {
        -webkit-transition-duration: 180ms;
        transition-duration: 180ms;
        }

        .menu-item:nth-child(8) {
        -webkit-transition-duration: 180ms;
        transition-duration: 180ms;
        }

        .menu-item:nth-child(9) {
        -webkit-transition-duration: 180ms;
        transition-duration: 180ms;
        }

        .menu-open-button {
        z-index: 2;
        -webkit-transition-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transition-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1.275);
        -webkit-transition-duration: 400ms;
        transition-duration: 400ms;
        -webkit-transform: scale(1.1, 1.1) translate3d(0, 0, 0);
        transform: scale(1.1, 1.1) translate3d(0, 0, 0);
        cursor: pointer;
        box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.14);
        }

        .menu-open-button:hover {
        -webkit-transform: scale(1.2, 1.2) translate3d(0, 0, 0);
        transform: scale(1.2, 1.2) translate3d(0, 0, 0);
        }

        .menu-open:checked + .menu-open-button {
        -webkit-transition-timing-function: linear;
        transition-timing-function: linear;
        -webkit-transition-duration: 200ms;
        transition-duration: 200ms;
        -webkit-transform: scale(0.8, 0.8) translate3d(0, 0, 0);
        transform: scale(0.8, 0.8) translate3d(0, 0, 0);
        }

        .menu-open:checked ~ .menu-item {
        -webkit-transition-timing-function: cubic-bezier(0.935, 0, 0.34, 1.33);
        transition-timing-function: cubic-bezier(0.935, 0, 0.34, 1.33);
        }

        .menu-open:checked ~ .menu-item:nth-child(3) {
        transition-duration: 180ms;
        -webkit-transition-duration: 180ms;
        -webkit-transform: translate3d(0.08361px, -104.99997px, 0);
        transform: translate3d(0.08361px, -104.99997px, 0);
        }

        .menu-open:checked ~ .menu-item:nth-child(4) {
        transition-duration: 280ms;
        -webkit-transition-duration: 280ms;
        -webkit-transform: translate3d(90.9466px, -52.47586px, 0);
        transform: translate3d(90.9466px, -52.47586px, 0);
        }

        .menu-open:checked ~ .menu-item:nth-child(5) {
        transition-duration: 380ms;
        -webkit-transition-duration: 380ms;
        -webkit-transform: translate3d(90.9466px, 52.47586px, 0);
        transform: translate3d(90.9466px, 52.47586px, 0);
        }

        .menu-open:checked ~ .menu-item:nth-child(6) {
        transition-duration: 480ms;
        -webkit-transition-duration: 480ms;
        -webkit-transform: translate3d(0.08361px, 104.99997px, 0);
        transform: translate3d(0.08361px, 104.99997px, 0);
        }

        .menu-open:checked ~ .menu-item:nth-child(7) {
        transition-duration: 580ms;
        -webkit-transition-duration: 580ms;
        -webkit-transform: translate3d(-90.86291px, 52.62064px, 0);
        transform: translate3d(-90.86291px, 52.62064px, 0);
        }

        .menu-open:checked ~ .menu-item:nth-child(8) {
        transition-duration: 680ms;
        -webkit-transition-duration: 680ms;
        -webkit-transform: translate3d(-91.03006px, -52.33095px, 0);
        transform: translate3d(-91.03006px, -52.33095px, 0);
        }

        .menu-open:checked ~ .menu-item:nth-child(9) {
        transition-duration: 780ms;
        -webkit-transition-duration: 780ms;
        -webkit-transform: translate3d(-0.25084px, -104.9997px, 0);
        transform: translate3d(-0.25084px, -104.9997px, 0);
        }

        .blue {
        background-color: #669AE1;
        box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.14);
        text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.12);
        }

        .blue:hover {
        color: #669AE1;
        text-shadow: none;
        }

        .green {
        background-color: #70CC72;
        box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.14);
        text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.12);
        }

        .green:hover {
        color: #70CC72;
        text-shadow: none;
        }

        .red {
        background-color: #FE4365;
        box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.14);
        text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.12);
        }

        .red:hover {
        color: #FE4365;
        text-shadow: none;
        }

        .purple {
        background-color: #C49CDE;
        box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.14);
        text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.12);
        }

        .purple:hover {
        color: #C49CDE;
        text-shadow: none;
        }

        .orange {
        background-color: #FC913A;
        box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.14);
        text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.12);
        }

        .orange:hover {
        color: #FC913A;
        text-shadow: none;
        }

        .lightblue {
        background-color: #62C2E4;
        box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.14);
        text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.12);
        }

        .lightblue:hover {
        color: #62C2E4;
        text-shadow: none;
        }

        .credit {
        margin: 24px 20px 120px 0;
        text-align: right;
        color: #EEEEEE;
        }

        .credit a {
        padding: 8px 0;
        color: #C49CDE;
        text-decoration: none;
        transition: all 0.3s ease 0s;
        }

        .credit a:hover {
        text-decoration: underline;
        }

        #videoInicio {
            object-fit: cover;
            width: 100%;
            height: 100vh;
        }

        @media (max-width: 600px) {
            #videoInicio {
                height: 30vh;
            }
        }

        .switch-button {
        background: rgba(255, 255, 255, 0.56);
        border-radius: 30px;
        overflow: hidden;
        width: 200px;
        text-align: center;
        font-size: 13px;
        font-weight: bold;
        color: #155FFF;
        position: relative;
        padding-right: 110px;
        position: relative;

        position: absolute;
        top: 20px;
        right: 20px;
        height: 40px;
        }
        .switch-button:before {
        content: "AUDIO ON";
        position: absolute;
        top: 0;
        bottom: 0;
        right: 0;
        width: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 3;
        pointer-events: none;
        }
        .switch-button-checkbox {
        cursor: pointer;
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        z-index: 2;
        }
        .switch-button-checkbox:checked + .switch-button-label:before {
        transform: translateX(110px);
        transition: transform 300ms linear;
        }
        .switch-button-checkbox + .switch-button-label {
        position: relative;
        padding: 10px 0;
        display: block;
        user-select: none;
        pointer-events: none;
        }
        .switch-button-checkbox + .switch-button-label:before {
        content: "";
        background: #fff;
        height: 100%;
        width: 100%;
        position: absolute;
        left: 0;
        top: 0;
        border-radius: 30px;
        transform: translateX(0);
        transition: transform 300ms;
        }
        .switch-button-checkbox + .switch-button-label .switch-button-label-span {
        position: relative;
        }

    </style>
  
</head>

<body>
    <header>
           
                <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active video-container">
                            <video class="embed-responsive-item " height="" id="videoInicio" loop="" autoplay muted>
                                <source src="digital/mp4/video.mp4" type="video/mp4">
                                Su navegador no soporta este elemento.
                            </video>
                            <div class="switch-button">
                                <input class="switch-button-checkbox" type="checkbox" id="input-audio-video"></input>
                                <label class="switch-button-label" for=""><span class="switch-button-label-span">AUDIO OFF</span></label>
                            </div>


                    
                            {{--<div class="carousel-caption d-none d-md-block">
                                <h5>SOLUTIONFINANCETAX</h5>
                                <a href="{{ url('/page') }}" class="btn btn-dark btn-lg btn-block" role="button"
                                aria-pressed="true">EMPIEZA AHORA</a>
                            </div>
                            --}}
                        </div>
                    </div>
                </div>
            
    </header>

    <section class="my-5">
        <div class="container-sm">
            <br>
            <br>
            <nav class="menu">
                <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open" />
                <label class="menu-open-button" for="menu-open">
                    <span class="lines line-1"></span>
                    <span class="lines line-2"></span>
                    <span class="lines line-3"></span>
                </label>

                <a href="/page#services" class="menu-item" style="background-color: #4e555a;"><i class="fas fa-chart-bar menu-icon" aria-hidden="true"><br><span class="menu-text"><b>FINANZAS</b></span></i></a>
                <a href="/page#services" class="menu-item" style="background-color: #4e555a;"><i class="fa fa-desktop menu-icon"><br><span class="menu-text"><b>WEB</b></span></i></a>
                <a href="/page#services" class="menu-item" style="background-color: #4e555a;"><i class="far fa-money-bill-alt menu-icon"><br><span class="menu-text"><b>IMPUESTOS</b></span></i></a>
                <a href="/page#services" class="menu-item" style="background-color: #4e555a;"><i class="fas fa-address-card menu-icon"><br><span class="menu-text"><b>CONTABLES</b></span></i></a>
                <a href="/page#services" class="menu-item" style="background-color: #4e555a;"><i class="fas fa-chart-line menu-icon"><br><span class="menu-text"><b>INDICADORES</b></span></i></a>
                <a href="/page#services" class="menu-item" style="background-color: #4e555a;"><i class="fas fa-file-alt menu-icon"><br><span class="menu-text"><b>CONTRATOS</b></span></i></a>
            </nav>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="d-grid gap-2 col-6 mx-auto">
            {{-- <h5 align="center">
                    SOLUTIONFINANCETAX
                </h5>
            --}}
                 <a href="{{ url('/page') }}" class="btn btn-dark btn-lg btn-block" role="button"
                    aria-pressed="true">EMPIEZA AHORA</a>
            </div>
        </div>
    </section>

    {{-- <section>
        <div class="card">
            <div class="card-body">
                <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <video class="embed-responsive-item w-100 " height="" autoplay loop>
                                <source src="digital/mp4/video.mp4" type="video/mp4">
                            </video>
                            <div class="carousel-caption d-none d-md-block">
                                <h5>SOLUTIONFINANCETAX</h5>
                                <a href="{{ url('/page') }}" class="btn btn-dark btn-lg btn-block" role="button"
                                aria-pressed="true">EMPIEZA AHORA</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- General JS Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script>

        document.getElementById("input-audio-video")
        .addEventListener("click", function(event) {
            var vid = document.getElementById("videoInicio");
            if(vid.muted){
                vid.muted = false;
            }else{
                vid.muted = true;
            }
        });
    </script>
</body>


</html>
