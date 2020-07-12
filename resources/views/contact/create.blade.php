@extends('layouts.app')

@section('content')
<div class="container mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card p-4">
                <h1>We're Here For You</h1>
                <p>Questions? Suggestions? Feedback? Whatever is on your mind, we'd love to hear from you.</p>
                <form action="{{route('contact_store')}}" method="POST" >
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="name">Name</label>
                            <div class="position-relative">
                                <input type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" id="name" name="name"  value="{{old('name')}}">
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
                                <input type="text" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" id="email" name="email"  value="{{old('email')}}">
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
