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
            <div class="image-title">
                <h3>About StemmaStudy</h3>
                <img src="{{asset('/image/Brain.png')}}" />
            </div>
            <h1 class="mt-4">Technology-Empowered Learning</h1>
            <p>
                Learning makes us who we are. Whether we strive to become doctors, lawyers, programmers, CEOs, or just general masterminds, learning is what gets us there. 
                Learning is the process by which we all make something of ourselves.
            </p>
            <p>
                Yet, the ability to learn effectively is too often taken for granted. The easiest methods of study &ndash; such as rereading your notes &ndash; are often 
                the absolute <em>worst</em> when it comes to making long-lasting memories. 
                The truth is that real, worthwhile learning that lasts a lifetime is difficult to engage in.
            </p>
            <p>
                We believe technology can empower us to engage in more effective learning by structuring our study and guiding our focus where we need it most. 
                So, we're developing the tools you need to understand more, forget less, and become the best at whatever you're striving to become.
            </p>

            <hr class="my-5">
            <h1 class="mt-5">Memory: Rethinking It</h1>
            <p>
                Our minds don't work like computers, so the way we study should be more than an attempt to merely absorb information. Effective learning isn't like a download process.
                Instead, our approach to studying should be based on scientifically proven principles of learning.
            </p>
            <p>
                There are a number of proven principles of learning, such as the Testing Effect, the Spacing Effect, Structure, Self-Explanation, and more. 
            </p>
            <div class="mt-5 mb-5 text-center">
                <p class="mb-3"><b>Want to learn more about a few of the most important principles of learning?</b></p>
                <a href="{{route('learn')}}" class="btn btn-primary">How to Study Smarter</a>
            </div>
            <p>
                Every learning tool out there attempts to take advantage of some basic principle of learning. 
                Unfortunately for our brains, very few make any attempt at integrating multiple principles into one cohesive system. 
                This is exactly what StemmaStudy is designed to do &ndash; and we're nerding out about it every day!
            </p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="raised-box">
                <div class="quote-container text-left">
                    <i class="fas fa-quote-left green shadow"></i>
                    <p class="quote">I have never seen any other platform that does what StemmaStudy does in using flashcards in an organized way that will permit students to develop a schema for the material.</p>
                    <p class="reference"><span class="green">&mdash;</span> <b>Henry L. Roediger III</b></p>
                    <p class="reference-description">Coauthor of <em>Make It Stick</em>, Professor of Psychological and Brain Sciences at Washington University in St. Louis</p>
                </div>
                <div class="quote-container text-left">
                    <i class="fas fa-quote-left green shadow"></i>
                    <p class="quote">From the perspective of helping people learn, this seems like a great way to do it. I've seen a lot of smart flashcard apps and this is the first time I remember seeing one where you can map out the relationships between topics/cards.</p>
                    <p class="reference"><span class="green">&mdash;</span> <b>Nate Kornell</b></p>
                    <p class="reference-description">Professor of Psychology, Chair of Cognitive Science Program at Williams College</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <hr class="my-5">
            <h1 class="mt-5">We're Still Learning</h1>        
            <p>
                We know that there is still so much more we can do to improve learning and to improve your experience using StemmaStudy.
                If you have feedback as to how StemmaStudy has helped your learning or suggestions for how we can make StemmaStudy better, we would love to hear from you!
            </p>
            <div class="mb-4 text-center">
                <a href="{{route('contact_create')}}" class="btn btn-secondary">Contact Us</a>
            </div>
        </div>
    </div>
</div>

@guest
<div class="d-flex justify-content-center py-5 px-3 mt-5 you-are-container">
    <div class="you-are text-center">
        <h1>Forget Flashcards as You Know Them</h1>
        <h4 class="text-body">Try StemmaStudy free for 30 days and start understanding and remembering more.</h4>
        <a href="{{route('register')}}" class="btn btn-light mt-3">Start my Free Trial</a>
    </div>
</div>
@endguest

@endsection

@section('scripts')

@endsection