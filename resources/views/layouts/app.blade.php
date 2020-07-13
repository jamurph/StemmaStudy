<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
    <header>
        <nav style="border-bottom: 3px solid var(--light-acc);" class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fab fa-pagelines green"></i> Stemma<span class="green">Study</span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
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
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
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

                                <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="navbarDropdown">
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
    <main class="{!! (Request::url() == url('/')) ? '' : 'py-4' !!}">
        @yield('content')
    </main>
    <footer>
        <div class="container">
            <div class="row flex-column flex-md-row justify-content-md-around justify-content-left">
                <div class="mb-4">
                    <h5>StemmaStudy</h5>
                    <a href="#" class="text-decoration-none">About</a>
                    <a href="{{route('contact_create')}}" class="text-decoration-none">Contact</a>
                </div>
                <div class="mb-4">
                    <h5>Learn</h5>
                    <a href="#" class="text-decoration-none">StemmaStudy Tutorial</a>
                    <a href="#" class="text-decoration-none">How to Study Smarter</a>
                </div>
                <div class="mb-4">
                    <h5>Legal</h5>
                    <a href="#" class="text-decoration-none">Privacy Policy</a>
                    <a href="#" class="text-decoration-none">Terms of Use</a>
                </div>
            </div>
        </div>
    </footer>
    @yield('scripts')
</body>
</html>
