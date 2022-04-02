@extends('layouts.app')

@section('title', 'Connected Flashcards | StemmaStudy')

@section('header')
<meta name="description" content="Learn and remember more by connecting ideas, discovering gaps in your understanding, and efficiently reviewing the concepts you struggle with the most.">
<meta property="og:title" content="Connected Flashcards | StemmaStudy">
<meta property="og:description" content="Learn and remember more by connecting ideas, discovering gaps in your understanding, and efficiently reviewing the concepts you struggle with the most.">
<meta property="og:image" content="{{asset('/image/ConnectTheDots.png')}}">
<meta property="og:url" content="{{route('home')}}">
<meta name="twitter:card" content="summary_large_image">

<style>
    p {
        font-size: 18px;
    }

    ul {
        font-size: 18px;
    }

    .big-brain-container {
        position: relative;
        padding-bottom: 62.5%;
    }

    .big-brain-time {
        position: absolute;
        width: 100%;
        height: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        color: var(--dark);
        width: 100%;
    }

    .big-brain-time h1 {
        font-size: 35px;
    }

    .big-brain {
        position: absolute;
        width: 100%;
        z-index: -1;
    }

    .big-brain-message {
        max-width: 600px;
        text-align: center;
    }

    @media screen and (max-width: 768px){
        .big-brain-container {
            padding: 15px;
        }
        
        .big-brain-time {
            position: unset;
        }
        
        .big-brain {
            position: unset;
            width: 70%;
            margin-bottom: 15px;
        }

        .big-brain-message {
            max-width: 410px;
        }
    }

</style>
@endsection

@section('content')
<div class="home-banner">
    <div class="container py-5">
        <div class="row justify-content-center big-brain-container">
            <div class="big-brain-time">
                <img class="big-brain" src="https://stemmastudy.test/image/Brain.png" />
                <div class="big-brain-message">
                    <h1 class="mt-0 mb-4"><b>Study The Way Your Brain Likes It</b></h1>
                    <h4 class="mb-4">StemmaStudy's Connected Flashcards help your brain make better memories by integrating several tried-and-true techniques of effective learning.</h4>
                    <div>
                        <a href="https://stemmastudy.test/register" class="btn btn-primary">Try It Free For 30 Days</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 text-right">
            
        </div>
    </div>
</div>

<div class="container">
    <hr>
    <h2 class="text-center mt-5 mb-4"><span class="green">&mdash;</span> How it Works <span class="green">&mdash;</span></h2>
    <div class="row py-5">
        <div class="col-lg-6">
            <h3>Create &amp; Connect Flashcards</h3>
            <p>
                Traditional flashcards are great, but they're lonely. Information is easier to remember when it is interconnected, 
                so StemmaStudy allows you to form networks of Connected Flashcards.
            </p>
            <ul>
                <li>Find and bridge gaps in your initial understanding.</li>
                <li>Integrate new concepts more easily into your existing knowledge.</li>
                <li>Organize your Connected Flashcards, creating a helpful visualization of the material.</li>
            </ul>
        </div>
        <div class="col-lg-6">
            <img src="{{asset('/image/ConnectTheDots.png')}}" class="img w-100" />
        </div>
    </div>
    <div class="row py-5">
        <div class="col-lg-6 order-lg-1 order-2">
            <img src="{{asset('/image/MaintainStrongMemories.png')}}" class="img w-100" />
        </div>
        <div class="col-lg-6 order-lg-2 order-1">
            <h3>Maximize Your Review</h3>
            <p>
                StemmaStudy uses a "Spaced Repetition Algorithm" to optimally schedule reviews of your flashcards based on how well you know them.
                Plus, you review not only what your concepts are, but also how they relate to others. 
            </p>
            <ul>
                <li>Systematically eradicate the weaker parts of your memory.</li>
                <li>Efficiently space study to take advantage of your brain's natural memory processes.</li>
                <li>Get more meaningful studying done in less time.</li>
            </ul>
        </div>
    </div>
    <div class="row py-5">
        <div class="col-lg-6 ">
            <h3>Concentrate Your Efforts</h3>
            <p>
                Crush your exams with confidence by taking a StemmaStudy Assessment. Assessment results show how well you did on each flashcard 
                within the network structure you created, which helps to inform your study.
            </p>
            <ul>
                <li>See your performance on each concept in context of the big picture.</li>
                <li>Focus on poor-performing concepts related to the concepts you know well.</li>
                <li>Plan your future learning efforts based on the results.</li>
            </ul>
        </div>
        <div class="col-lg-6">
            <img src="{{asset('/image/ConcentrateYourEffort.png')}}" class="img w-100" />
        </div>
    </div>
    <div class="mb-5"></div>
</div>

<div class="container mb-5 text-center">
    <hr>
    <h2 class="mt-5 mb-4"><span class="green">&mdash;</span> Features <span class="green">&mdash;</span></h2>
    <div class="row">
        <div class="col-md-6 p-3">
            <h4><i class="fas fa-boxes green mr-3"></i>Create Sets</h4>
            <p class="text-muted">Stay organized by splitting your flashcards for study into groups by topic, class, book, or chapter. </p>
        </div>
        <div class="col-md-6 p-3">
            <h4><i class="fas fa-project-diagram green mr-3"></i>Link Flashcards Together</h4>
            <p class="text-muted">No concept exists on its own &ndash; link each one to others to learn the relationships, as well.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 p-3">
            <h4><i class="fas fa-calendar-day green mr-3"></i>Spaced Repetition</h4>
            <p class="text-muted">StemmaStudy automatically schedules your review of concepts based on how well you know them.</p>
        </div>
        <div class="col-md-6 p-3">
            <h4><i class="fas fa-envelope-open-text green mr-3"></i>Get Notifications to Review</h4>
            <p class="text-muted">Never forget with optional reminders to review sent straight to your inbox.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 p-3">
            <h4><i class="fas fa-sitemap green mr-3"></i>See the Big Picture</h4>
            <p class="text-muted">Organize your flashcards in a diagram that helps you gain deeper understanding of the material.</p>
        </div>
        <div class="col-md-6 p-3">
            <h4><i class="fas fa-pencil-alt green mr-3"></i>Visualize your Knowledge</h4>
            <p class="text-muted">Take assessments and view how concepts you missed are related to concepts you know.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 p-3">
            <h4><i class="fas fa-paragraph green mr-3"></i>Use Rich Text</h4>
            <p class="text-muted">Add bold, bullet points, italics, links, and more to your flashcards as you see fit.</p>
        </div>
        <div class="col-md-6 p-3">
            <h4><i class="fas fa-images green mr-3"></i>Use Images</h4>
            <p class="text-muted">Attach images within the text of your flashcards to show examples or learn visual concepts.</p>
        </div>
    </div>
</div>

<div class="container mb-5">
    <hr/>
    <h2 class="text-center mt-5 mb-4"><span class="green">&mdash;</span> Pricing <span class="green">&mdash;</span></h2>
    <div class="price-box shadow" style="">
        <div class="text-center"><span class="price green"><small class="text-dark text-muted">$</small>4<sup>.99</sup><small class="text-dark text-muted">/mo</small></span></div>
        <div class="text-center text-muted">Make better memories for the price of one morning coffee. <span style="font-size: 120%">&#x2615;</span></div>
        <div class="text-center mt-3">
            Try it totally free for 30 days &ndash; no strings attached &ndash; and see how much more you remember!
        </div>
        <div class="mt-4 mb-4 text-center">
            <a href="{{route('register')}}" class="btn btn-primary">Start Free Trial</a>
        </div>
    </div>
</div>

<div class="container mt-5">
    <hr/>
    <div class="row justify-content-center">
        <div class="col-md-6 quote-container">
            <i class="fas fa-quote-left green shadow"></i>
            <p class="quote">I have never seen any other platform that does what StemmaStudy does in using flashcards in an organized way that will permit students to develop a schema for the material.</p>
            <p class="reference"><span class="green">&mdash;</span> <b>Henry L. Roediger III</b></p>
            <p class="reference-description">coauthor of <em>Make It Stick</em>, Professor of Psychological and Brain Sciences at Washington University in St. Louis</p>
        </div>
        <div class="col-md-6 quote-container">
            <i class="fas fa-quote-left green shadow"></i>
            <p class="quote">From the perspective of helping people learn, this seems like a great way to do it. I've seen a lot of smart flashcard apps and this is the first time I remember seeing one where you can map out the relationships between topics/cards.</p>
            <p class="reference"><span class="green">&mdash;</span> <b>Nate Kornell</b></p>
            <p class="reference-description">Professor of Psychology, Chair of Cognitive Science Program at Williams College</p>
        </div>
    </div>
    <div class="mb-5"></div>
</div>
<div class="d-flex justify-content-center py-5 px-3 you-are-container">
    <div class="you-are text-center">
        <h1>You Are What You Remember</h1>
        <h4>Don't study just to pass a test.<br class="d-lg-none"/> Study to make strong memories.</h4>
        <a href="{{route("learn")}}" class="btn btn-light mt-3">How to Remember More</a>
    </div>
</div>


@endsection

@section('scripts')

@endsection