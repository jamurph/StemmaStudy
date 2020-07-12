@extends('layouts.app')

@section('content')
<div class="container mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center card p-4">
            <h1>Uh oh. That's an error.</h1>
            <hr>
            <h3>Error @yield('code')</h3>
            <p>@yield('message')</p>
        </div>
    </div>
</div>
@endsection