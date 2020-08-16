<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="shortcut icon" href="{{URL::asset('imgs/cars_128.png')}}">
        <link rel="apple-touch-icon-precomposed" sizes="256x256" href="{{URL::asset('imgs/cars_256.png')}}">
        <link rel="apple-touch-icon-precomposed" sizes="180x180" href="{{URL::asset('imgs/cars_180.png')}}">
        <link rel="apple-touch-icon-precomposed" sizes="128x128" href="{{URL::asset('imgs/cars_128.png')}}">
        <!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="{{URL::asset('favicon.ico')}}" /><![endif]-->
        <link rel="icon" href="{{URL::asset('imgs/cars_32.png')}}" sizes="32x32" type="image/png">
        <link rel="icon" href="{{URL::asset('imgs/cars_48.png')}}" sizes="48x48" type="image/png">
        <link rel="icon" href="{{URL::asset('imgs/cars_96.png')}}" sizes="96x96" type="image/png">
        <link rel="icon" href="{{URL::asset('imgs/cars_144.png')}}" sizes="144x144" type="image/png">

        <title>{{config('app.name')}} @yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        {{Html::style('css/app.css')}}
        {{Html::style('css/more.css')}}
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    
    </head>
    <body>
        <div class="container flex-center position-ref">
            @yield('content')
            <div class="version">
                <p style="font-style:italic;">Les fichiers ne sont pas stockés sur le serveur et restent en cache 1 heure maximum.</p>
                <p style="text-decoration:underline;">Version 3</p>
            </div>
        </div>
    @stack('scripts')
    </body>
</html>