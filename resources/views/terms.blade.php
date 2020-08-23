@extends('layouts.app')

@section('title', 'Terms of Service | StemmaStudy')

@section('header')
<meta name="description" content="View the Terms of Service for StemmaStudy.">
<meta property="og:title" content="Terms of Service | StemmaStudy">
<meta property="og:description" content="View the Terms of Service for StemmaStudy.">
<meta property="og:image" content="{{asset('/image/ConnectTheDots.png')}}">
<meta property="og:url" content="{{route('terms')}}">
<meta name="twitter:card" content="summary_large_image">

@endsection

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="mb-0">Terms of Service</h1>
            <p>...</p>
        </div>
    </div>
</div>
@endsection

