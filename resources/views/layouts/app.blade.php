<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/statictop.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="{{ url('/') }}">One Stop Click</a>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">               
                @if (Auth::guest())
                    <li  class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                    <li  class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                @else        
                    <!-- <li>
                        <a href="#" data-toggle="modal" data-target="#cartModal"><i class="fa fa-shopping-cart" style="color:#fff;font-size:1.7em"></i><span class="badge badge-danger" id="totalCart"></span></a>
                    </li> -->
                    <li class="nav-item">
                    
                    <div class="dropdown show">
                    <a class="btn btn-secondary dropdown-toggle" href="#" id="userlink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu" aria-labelledby="userlink">
                        <a class="dropdown-item" href="#">Setting</a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">Logout</a>
                    
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                
                    </div>
                    </div>
                    
                @endif
                </ul>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                   @yield('menu')
                </div>
                <div class="col-md-10">
                    @yield('content')
                </div>
            </div>
        </div>
        
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
