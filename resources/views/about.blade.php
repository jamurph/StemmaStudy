@extends('layouts.app')

@section('title', 'About StemmaStudy')

@section('header')
<meta name="description" content="Learning is the process by which we make something of ourselves. We believe technology can help us make this process better.">
<meta property="og:title" content="About StemmaStudy">
<meta property="og:description" content="Learning is the process by which we make something of ourselves. We believe technology can help us make this process better.">
<meta property="og:image" content="{{asset('/image/ConnectTheDots.png')}}">
<meta property="og:url" content="{{route('about')}}">
<meta name="twitter:card" content="summary_large_image">

<style>
    
    p, .about li{
        font-size: 18px;
    }

</style>
@endsection

@section('content')
<div class="container mt-4 about">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1>Learning Makes Us Who We Are</h1>
            <p>Despite all our varied interests, passions, and dreams, we all have one thing in common. Whether we strive to be Doctors, Lawyers, Programmers, or CEOs, <b>learning is what gets us there</b>. It is the process by which we all can make something of ourselves.</p>
            <p>We believe that <b>technology can help us</b> make this process better. So, we're developing tools that help you understand more, forget less, and reach even your most ambitious goals.</p>
            <img src="{{asset('/image/ConnectTheDots.png')}}" class="img w-100" />
            <h2>Making Ideas Come Together</h2>
            <p>Ideas don't exist by themselves. We can't say we truly understand something until we <b>know how each concept fits</b> into the overall big-picture.</p>
            <p>StemmaStudy Connected Flashcards help you connect the dots. <b>Linking flashcards</b> together helps make sense of what you are learning so that you remember more. Then, leveraging the proven power of <b>spaced repetition</b> and the <b>testing effect</b>, we make sure you never forget it.</p>
            <hr>
            <h2>What's Next?</h2>
            <p>We're not resting on our laurels. <b>We're here to improve learning</b>.</p>
            <p>Here are some ways we are looking to improve:</p>
            <ul>
                <li><b>Add images</b> to cards. Visuals can often aid memory. We want to make sure you can leverage this in your study.</li>
                <li>More ways to <b>sort, search, and filter</b> to find the cards you want to see.</li>
                <li>Learn together. We want to enable you to <b>share your sets</b> with your friends and the world.</li>
                <li><b>User interface and process improvements</b> to make StemmaStudy easier to use.</li>
            </ul>
            <p><b>If you have feedback or suggestions</b> for how we can make StemmaStudy better, please <a href="{{route('contact_create')}}">let us know</a>.</p>
        </div>
    </div>
</div>

@guest
<div class="d-flex justify-content-center py-5 px-3 mt-5 you-are-container">
    <div class="you-are text-center">
        <h1>Forget Flashcards as You Know Them</h1>
        <h4 class="text-body">Try StemmaStudy free for 30 days and start understanding and remembering more.</h4>
        <a href="{{route('register')}}" class="btn btn-light mt-3">Start my Free Trial <i class="fas fa-angle-double-right"></i></a>
    </div>
</div>
@endguest

@endsection

@section('scripts')

@endsection