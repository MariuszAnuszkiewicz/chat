<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Chat') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/getUserProfile.js') }}" defer></script>
    <script src="{{ asset('js/navbar.js') }}" defer></script>
    <script src="{{ asset('js/InsertDataChat.js') }}" defer></script>
    <script src="{{ asset('js/loadMessages.js') }}" defer></script>
    <script src="{{ asset('js/settingFontSize.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @if (preg_match('/Firefox/', $_SERVER['HTTP_USER_AGENT']))
        <link href="{{ asset('css/styleFirefox.css') }}" rel="stylesheet">
    @elseif (preg_match('/Chrome/', $_SERVER['HTTP_USER_AGENT']))
        <link href="{{ asset('css/styleChrome.css') }}" rel="stylesheet">
    @endif

    <link href="{{ asset('css/errors.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include('nav.navigation')
        <div class="container">
            <div class="flash col-sm-5">
                @if ($message = Session::get('logged'))
                    <div class="alert alert-info">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                @if ($message = session('status'))
                    <div class="alert alert-success" role="alert">
                        <p>{{ $message }}</p>
                    </div>
                @endif
            </div>
        </div>
        @yield('content')
    </div>
</body>
</html>
