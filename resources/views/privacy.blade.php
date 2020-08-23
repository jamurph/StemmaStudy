@extends('layouts.app')

@section('title', 'Privacy Policy | StemmaStudy')

@section('header')
<meta name="description" content="See how StemmaStudy uses the information you provide.">
<meta property="og:title" content="Privacy Policy | StemmaStudy">
<meta property="og:description" content="See how StemmaStudy uses the information you provide.">
<meta property="og:image" content="{{asset('/image/ConnectTheDots.png')}}">
<meta property="og:url" content="{{route('privacy')}}">
<meta name="twitter:card" content="summary_large_image">

@endsection

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="mb-0">Privacy Policy</h1>
            <p>...</p>
        </div>
    </div>
</div>
@endsection

