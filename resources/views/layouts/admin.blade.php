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
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <header>
            @include('layouts.partials.navbar')
        </header>     
        <div class="container-fluid">   
            <div class="row">
                @include('layouts.partials.sidenav')         
                <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">                    
                    @yield('content')                       
                </main>
            </div>
        </div>   
         
    </div>
    @include('layouts.partials.scripts')
</body>    
</html>