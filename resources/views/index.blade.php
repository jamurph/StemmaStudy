@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @auth
            <h1>Welcome to StemmaStudy, {{ auth()->user()->name }}</h1>
        @else
            <h1>Welcome to StemmaStudy</h1>
        @endauth
    </div>
</div>
@endsection
