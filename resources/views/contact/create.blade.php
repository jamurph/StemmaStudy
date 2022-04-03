@extends('layouts.app')

@section('title', 'Contact | StemmaStudy')

@section('header')
<meta name="description" content="Questions? Suggestions? Feedback? Whatever is on your mind, we'd love to hear from you.">
<meta property="og:title" content="Contact | StemmaStudy">
<meta property="og:description" content="Questions? Suggestions? Feedback? Whatever is on your mind, we'd love to hear from you.">
<meta property="og:image" content="{{asset('/image/ConcentrateYourEffort.png')}}">
<meta property="og:url" content="{{route('contact_create')}}">
<meta name="twitter:card" content="summary_large_image">

<script src="https://www.google.com/recaptcha/api.js"></script>
@endsection

@section('content')
<div class="container mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card p-4">
                <h1>What's on your mind?</h1>
                <p>Questions? Suggestions? Feedback? Let us know below.</p>
                <form id="contactForm" action="{{route('contact_store')}}" method="POST" >
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="name">Name</label>
                            <div class="position-relative">
                                <input type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" id="name" name="name"  value="{{old('name')}}" autocomplete="off">
                                @error('name')
                                <div class="invalid-tooltip">
                                    {{$errors->first('name')}}
                                </div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">What your momma calls you.</small>
                        </div>
                        <div class="col-lg-6">
                            <label for="email">Email</label>
                            <div class="position-relative">
                                <input type="text" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" id="email" name="email"  value="{{old('email')}}" autocomplete="off">
                                @error('email')
                                <div class="invalid-tooltip">
                                    {{$errors->first('email')}}
                                </div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">How can we reach you?</small>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="message">Message</label>
                        <div class="position-relative"> 
                            <textarea class="form-control  {{$errors->has('message') ? 'is-invalid' : ''}}" id="message" name="message" rows="3">{{old('message')}}</textarea>
                            @error('message')
                            <div class="invalid-tooltip">
                                {{$errors->first('message')}}
                            </div>
                            @enderror
                        </div>
                        <small class="form-text text-muted">Say what you need to say.</small>
                    </div>
                    <input type="hidden" id="recaptcha" name="recaptcha" value="" />
                    <button class="g-recaptcha btn btn-primary" 
                    data-sitekey="{{config('services.recaptcha.sitekey')}}" 
                    data-callback='onContactSubmit' 
                    data-action='contact'>Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function onContactSubmit(token){
        $('#recaptcha').val(token);
        $('#contactForm').submit();
    }
</script>
@endsection