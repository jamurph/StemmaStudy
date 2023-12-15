<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{asset('/image/icon.png')}}"/>
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title> 
    <script src="{{ asset('js/app.js') }}"></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://kit.fontawesome.com/31490b0d2f.js" crossorigin="anonymous"></script>
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @yield('header')
</head>
<body>
    <header>
       
    </header>
    <main>
        @yield('content')
    </main>
    <footer>

        <div class="text-left text-md-right mt-3 copyright">Copyright &copy; {{ now()->year }} StemmaStudy, LLC. &nbsp; <br class="d-block d-sm-none" /><a href="{{route('terms')}}" class="text-decoration-none">Terms of Service</a> &nbsp; <a href="{{route('privacy')}}" class="text-decoration-none">Privacy Policy</a></div>
    </footer>
    @yield('scripts')
</body>
</html>
