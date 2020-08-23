<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{asset('/image/icon.png')}}"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
    :root {
        --light: #EFF3F4;
        --light-acc: #6ec4be;
        --main: #28aa80;
        --dark-acc: #6e8789;
        --dark: #192332;
    }

    .blue {
        color: var(--light-acc);
    }

    .green {
        color: var(--main);
    }

    body {
        display: flex;
        min-height: 100vh;
        flex-direction: column;
    }

    main {
        flex: 1;
    }

    footer {
        background: var(--dark);
        color: var(--dark-acc);
        border-top: 3px solid var(--light-acc);
        padding: 30px 20px;
    }

    footer h5 {
        color: white;
    }

    footer a {
        display: block;
        color: var(--dark-acc);
    }

    footer a:hover {
        color: white;
    }

    </style>

    <script src="https://kit.fontawesome.com/31490b0d2f.js" crossorigin="anonymous"></script>
    @yield('header')
</head>
<body>
    <main>
        @yield('content')
    </main>
    @yield('scripts')
</body>
</html>
