@extends('layouts.app')

@section('title', 'About StemmaStudy')

@section('header')
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
            <p>Despite all our varied interests, passions, and dreams, we all have one thing in common. Whether we strive to be Doctors, Lawyers, Programmers, or CEOs, learning is what gets us there. It is the process by which we all can make something of ourselves.</p>
            <p>We believe that technology can help us make this process better. So, we're developing tools that help you understand more, forget less, and reach even your most ambitious goals.</p>
            <hr>
            <h2>Making Ideas Come Together</h2>
            <p>Ideas don't exist by themselves. We can't say we truly understand something until we know how each concept fits into the overall big-picture.</p>
            <p>StemmaStudy Connected Flashcards help you connect the dots. Linking flashcards together helps make sense of what you are learning so that you remember more. Then, leveraging the proven power of spaced repetition and the testing effect, we help make sure you never forget it.</p>
            <hr>
            <h2>Always Improving</h2>
            <p>We're not resting on our laurels. We're here to continue making learning work better for you.</p>
            <p>Here are some ways we are looking to improve:</p>
            <ul>
                <li>More ways to sort, search, and filter to find the cards you want to see.</li>
                <li>Tagging to help you organize and label similar cards.</li>
                <li>Improvements to the network view to allow more interaction with your cards and connections.</li>
                <li>The ability to save the network view the way you want it to be laid out.</li>
                <li>Share your sets with your friends and the world.</li>
                <li>Add images to cards.</li>
            </ul>
            <p>If you have feedback or suggestions for how we can make StemmaStudy better, please <a href="{{route('contact_create')}}">let us know</a>.</p>
        </div>
    </div>
</div>

@guest
<div class="d-flex justify-content-center py-5 px-3 mt-5 you-are-container">
    <div class="you-are text-center">
        <h1>Forget Flashcards as You Know Them</h1>
        <h4 class="text-body">Try StemmaStudy free for 30 days and start understanding and remembering more.</h4>
        <a href="/learn" class="btn btn-light mt-3">Start my Free Trial <i class="fas fa-angle-double-right"></i></a>
    </div>
</div>
@endguest

@endsection

@section('scripts')

@endsection