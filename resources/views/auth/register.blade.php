@extends('layouts.app')

@section('title', 'Register | StemmaStudy')

@section('header')
<meta name="description" content="Sign up for StemmaStudy and start creating Connected Flashcards.">
<meta property="og:title" content="Register | StemmaStudy">
<meta property="og:description" content="Sign up for StemmaStudy and start creating Connected Flashcards.">
<meta property="og:image" content="{{asset('/image/ConnectTheDots.png')}}">
<meta property="og:url" content="{{route('register')}}">
<meta name="twitter:card" content="summary_large_image">

<script src="https://www.google.com/recaptcha/api.js"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center mt-3"><i class="fas fa-brain green mr-2"></i> You're Building a Better Brain</div>

                <div class="card-body mb-3">
                    <form id="registerForm" method="POST" action="{{ route('register') }}">
                        @csrf

                        @php
                            use App\SpecialRegistration;
                            use Illuminate\Support\Carbon;
                            $code = request()->get('code');
                            $specReg = null;
                            if(!empty($code)){
                                $specReg = SpecialRegistration::where('route', $code)->whereDate('expires', '>', Carbon::today()->toDateString())->first();
                            }
                        @endphp
                        @if (!empty($code))
                            @if (!is_null($specReg))
                                <div class="alert alert-success"><b>Thank you!</b><br> You're signing up using a special registration link (code: {{$code}}). Please enjoy your extended free trial!</div>
                            @else
                                <div class="alert alert-warning"><b>Sorry...</b><br> The special registration link used has either expired or no longer exists (code: {{$code}}). <br><br>You may continue registering, but no special offers will be applied.</div>
                            @endif
                        @endif
                        <input type="hidden" name="route" id="route" value="{{$code}}" />
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                <small class="form-text text-muted">The name for your account.</small>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                            
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                <small class="form-text text-muted">We'll send an account verification link to this email address.</small>
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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <small class="form-text text-muted">Passwords must be at least 12 characters long.</small>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <input type="hidden" id="recaptcha" name="recaptcha" value="" />
                                <button class="g-recaptcha btn btn-primary" 
                                data-sitekey="{{config('services.recaptcha.sitekey')}}" 
                                data-callback='onRegisterSubmit' 
                                data-action='register'>
                                    {{ __('Register') }}
                                </button>
                                <p class="mt-2"><small>Already have an account? <a href="{{route('login')}}">Login</a></small></p>
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
    function onRegisterSubmit(token){
        $('#recaptcha').val(token);
        $('#registerForm').submit();
    }
</script>
@endsection