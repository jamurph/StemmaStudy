<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @if(App::environment('production') || App::environment('staging'))
    {{-- Google Analytics --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-173526157-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-173526157-1');
    </script>
    @endif
    @if(App::environment('production'))
    {{-- Facebook Pixel --}}
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '854950435339757');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=854950435339757&ev=PageView&noscript=1"
    /></noscript>
    @endif

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{asset('/image/icon.png')}}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <script src="{{ asset('js/app.js') }}"></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
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
