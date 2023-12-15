@extends('layouts.app')
@section('title', 'Login | StemmaStudy')

@section('header')
<meta name="description" content="Log in to StemmaStudy and start creating Connected Flashcards.">
<meta property="og:title" content="Login | StemmaStudy">
<meta property="og:description" content="Log in to StemmaStudy and start creating Connected Flashcards.">
<meta property="og:image" content="{{asset('/image/ConnectTheDots.png')}}">
<meta property="og:url" content="{{route('login')}}">
<meta name="twitter:card" content="summary_large_image">

<script src="https://www.google.com/recaptcha/api.js"></script>
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form id="loginForm" method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                @error('credentials')
                                    <div class="alert alert-danger">
                                        {{$message}}
                                    </div>
                                @enderror
                                <input type="hidden" id="recaptcha" name="recaptcha" value="" />
                                <button class="g-recaptcha btn btn-primary" 
                                data-sitekey="{{config('services.recaptcha.sitekey')}}" 
                                data-callback='onLoginSubmit' 
                                data-action='login'>
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                                <p class="mt-3"><small>Need an account? <a href="{{route('register')}}">Get Started</a></small></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function onLoginSubmit(token){
        $('#recaptcha').val(token);
        $('#loginForm').submit();
    }
</script>
@endsection