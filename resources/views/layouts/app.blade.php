<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @if(App::environment('production') || App::environment('staging'))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-WGF9C7R0BC"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-WGF9C7R0BC', {
    @auth
        'user_id': '{{Auth::user()->id}}'
    @endauth 
    });
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
    {{-- CSRF Token --}}
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
        border-top: 5px solid var(--light-acc);
        padding: 30px 20px 5px 20px;
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

    .copyright {
        color: var(--dark-acc);
        font-size: 12px;
    }

    .copyright a {
        display: inline-block;
    }

    @media screen and (max-width: 767px){
        #menu-dropdown {
            box-shadow: none !important;
        }
    }

    .you-are-container {
        margin-bottom: -1.5rem !important;
    }

    .navbar-toggler-icon {
        width: 20px;
        height: 20px;
    }

    </style>

    <script src="https://kit.fontawesome.com/31490b0d2f.js" crossorigin="anonymous"></script>
    @yield('header')
</head>
<body>
    <header>
        <nav style="border-bottom: 4px solid var(--light-acc); padding: 10px;" class="navbar navbar-expand-md navbar-light bg-white">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="logo" src="{{asset('/image/logo.svg')}}"/>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <small style="font-size:65%;">Menu</small> <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse mt-4 mt-md-0" id="navbarSupportedContent">
                    {{--<!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">{{ __('Explore') }}</a>
                        </li>
                    </ul>
                    <!-- Right Side Of Navbar -->
                --}}
                    <ul class="navbar-nav ml-auto">
                        @guest
                            @if (Request::url() != url('/register'))
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-primary" id="register-btn" href="{{ route('register') }}">{{ __('Create an Account') }}<i class="fas fa-angle-right ml-2"></i></a>
                                </li>
                            @endif
                            @if (Request::url() != url('/login'))
                                <li class="nav-item">
                                    <a class="nav-link ml-md-3 mt-2 mt-md-0 btn btn-light" href="{{ route('login') }}">{{ __('Login') }} <i class="fas fa-user"></i></a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user_sets') }}">{{ __('My Sets') }}</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Str::limit(Auth::user()->name, 15) }} <span class="caret"></span>
                                </a>

                                <div id="menu-dropdown" class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('settings') }}">
                                        {{ __('Settings') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="{!! (Request::url() == url('/') || Request::url() == url('/about') || Request::url() == url('/tutorial') || Request::url() == url('/press') ) ? '' : 'py-4' !!}">
        @yield('content')
    </main>
    <footer>
        <div class="container">
            <div class="row flex-column flex-md-row justify-content-md-around justify-content-left">
                <div class="mb-4">
                    <h5>Learn</h5>
                    <a href="{{route('tutorial')}}" class="text-decoration-none">StemmaStudy Tutorial</a>
                    <a href="{{route('learn')}}" class="text-decoration-none">How to Learn More</a>
                </div>
                <div class="mb-4">
                    <h5>StemmaStudy</h5>
                    <a href="{{route('about')}}" class="text-decoration-none">About</a>
                    <a href="{{route('contact_create')}}" class="text-decoration-none">Contact</a>
                    {{--<a href="{{route('press')}}" class="text-decoration-none">Press</a>--}}
                </div>
            </div>
        </div>

        <div class="text-left text-md-right mt-3 copyright">Copyright &copy; {{ now()->year }} StemmaStudy, LLC. &nbsp; <br class="d-block d-sm-none" /><a href="{{route('terms')}}" class="text-decoration-none">Terms of Service</a> &nbsp; <a href="{{route('privacy')}}" class="text-decoration-none">Privacy Policy</a></div>
    </footer>
    @yield('scripts')
</body>
</html>
