<!DOCTYPE html>
<html lang="es">
<!-- Copied from http://radixtouch.in/templates/admin/aegis/source/light/index.html by Cyotek WebCopy 1.7.0.600, Saturday, September 21, 2019, 2:51:57 AM -->

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SOLUTIONFINANCETAX</title>
    <!-- General CSS Files -->

    <link rel="stylesheet" href=" {{ asset('aegis/source/light/assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('aegis/source/light/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('aegis/source/light/assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('aegis/source/light/assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('aegis/source/light/assets/bundles/izitoast/css/iziToast.min.css') }}">
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <!-- Template CSS -->
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('aegis/source/light/assets/img/icono.ico') }}">
   
    @yield('style')

    @livewireStyles
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                {{-- <nav class="navbar navbar-expand-lg main-navbar" style="background-color: rgba(225, 51, 152, 0.912)"> --}}
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
                        collapse-btn"> <i data-feather="align-justify"></i></a></li>
                        <form class="form-inline mr-auto">
                        </form>
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right " >
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                            class="nav-link notification-toggle nav-link-lg"><i data-feather="bell"></i>
                            <span class="badge headerBadge2">
                                3 </span> </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                            <div class="dropdown-header">
                                Notifications
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>
                            <div class="dropdown-list-content dropdown-list-icons">
                                <a href="#" class="dropdown-item dropdown-item-unread"> <span
                                        class="dropdown-item-icon bg-primary text-white"> <i class="fas
                                                          fa-code"></i>
                                    </span> <span class="dropdown-item-desc"> Template update is
                                        available now! <span class="time">2 Min
                                            Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-icon bg-info text-white"> <i class="far
                                                          fa-user"></i>
                                    </span> <span class="dropdown-item-desc"> <b>You</b> and <b>Dedik
                                            Sugiharto</b> are now friends <span class="time">10 Hours
                                            Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-icon bg-success text-white"> <i class="fas
                                                          fa-check"></i>
                                    </span> <span class="dropdown-item-desc"> <b>Kusnaedi</b> has
                                        moved task <b>Fix bug header</b> to <b>Done</b> <span class="time">12
                                            Hours
                                            Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-icon bg-danger text-white"> <i
                                            class="fas fa-exclamation-triangle"></i>
                                    </span> <span class="dropdown-item-desc"> Low disk space. Let's
                                        clean it! <span class="time">17 Hours Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-icon bg-info text-white"> <i class="fas
                                                          fa-bell"></i>
                                    </span> <span class="dropdown-item-desc"> Welcome to Aegis
                                        template! <span class="time">Yesterday</span>
                                    </span>
                                </a>
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @else
                        <li class="dropdown"><a href="#" data-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <i data-feather="settings"></i>
                                <span class="d-sm-none d-lg-inline-block"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right pullDown">
                                <div class="dropdown-title"> {{ Auth::user()->name }}</div>
                                <div class="dropdown-divider">{{ Auth::user()->roles[0]->name }}</div>
                                <a href="{{ url('/admin/mi-perfil') }}" class="dropdown-item has-icon"> <i class="far
                                            fa-user"></i> Perfil
                                </a>
                                <a href="{{ url('/admin/mis-empresas') }}" class="dropdown-item has-icon"> <i class="fas fa-building"></i>
                                    Mis Empresas
                                   
                                  </a> 
                                  <a href="{{ url('/admin/mis-tarjetas-credito') }}"  class="dropdown-item has-icon"> <i class="fas fa-money-check"></i>
                                    Tarjeta Credito
                                  </a>
                                  <a href="" class="dropdown-item has-icon"> <i class="fas fa-gem"></i>
                                   Mis Planes
                                  </a>
                                  <div class="dropdown-divider"></div>
                                <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
                                    onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i>
                                    {{ __('Cerrar Sesión') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper" >
                    <div class="sidebar-brand">
                        <a href="{{ url('/') }}"> <img alt="image"
                                src="{{ asset('aegis/source/light/assets/img/logoo.png') }}" class="header-logo">
                            <span class="logo-name"><font SIZE=1>SOLUTIONFINANCETAX</font></span>
                        </a>
                    </div>
                    <div class="sidebar-user">
                        <div class="sidebar-user-picture">
                            @if (Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" class="img-fluid mr-2" alt="avatar">
                            @else
                                <img alt="image" src="{{ Avatar::create(Auth::user()->name)->setChars(2) }}">
                            @endif

                        </div>
                        <div class="sidebar-user-details">
                            <div class="user-name"> {{ Auth::user()->name }}</div>
                            <div class="user-role">{{ Auth::user()->roles[0]->name }}</div>
                        </div>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">MENU</li>
                     
                        {{-- aqui MENU JSON --}}                   
                            @foreach ($menuData[0]->menu as $menu)
                            @include('layouts.panels.menuVertical',['menu' => $menu])
                            @endforeach
                    </ul>
                </aside>
            </div>
            <!-- Main Content -->
            <div class="main-content">

                @yield('content')

            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2019 <div class="bullet"></div> Design By <a href="#">Redstar</a>
                </div>
                <div class="footer-right">
                </div>
            </footer>
        </div>
    </div>
    <!-- General JS Scripts -->
    <script src="{{ asset('aegis/source/light/assets/js/app.min.js') }}"></script>
    <script src="{{ asset('aegis/source/light/assets/js/scripts.js') }}"></script>

    @livewireScripts
    <!-- Evento de Modales -->
    <script src="{{ asset('js/eventos.js') }}"></script>
    <!-- Custom JS File -->
    <script src="{{ asset('aegis/source/light/assets/js/custom.js') }}"></script>
    <script src="{{ asset('aegis/source/light/assets/bundles/izitoast/js/iziToast.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('aegis/source/light/assets/bundles/upload-preview/assets/js/jquery.uploadPreview.min.js') }}">
    </script>

</body>

</html>
