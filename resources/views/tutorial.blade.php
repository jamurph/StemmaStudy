@extends('layouts.app')

@section('title', 'StemmaStudy Tutorial | How to Create Connected Flashcards')

@section('header')
<meta name="description" content="Connected Flashcards help make the learning process better. Here's how to create them!">
<meta property="og:title" content="StemmaStudy Tutorial | How to Create Connected Flashcards">
<meta property="og:description" content="Connected Flashcards help make the learning process better. Here's how to create them!">
<meta property="og:image" content="{{asset('/image/MaintainStrongMemories.png')}}">
<meta property="og:url" content="{{route('tutorial')}}">
<meta name="twitter:card" content="summary_large_image">

<style>
    
    p, .about li{
        font-size: 18px;
    }

    .tut-img {
        display: block;
        max-width: 100%;
        width: 500px;
        margin: auto;
        border: 5px solid white;
        margin-top: 15px;
        margin-bottom: 15px;
    }

</style>
@endsection

@section('content')
<div class="container mt-4 about">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <h1>StemmaStudy Tutorial</h1>
            <p>StemmaStudy Connected Flashcards are made to help you <b>understand more</b> and <b>forget less</b>.</p>
            <p>We can't say we truly understand something until we know how it fits into the big-picture. 
                For this reason, StemmaStudy lets you <b>connect flashcards to form a network</b> that you can visualize. 
                This makes it easy to <b>find gaps in your understanding</b> by finding flashcards that are disconnected. 
                Then, when studying your flashcards, you study not only <b>what the concepts are</b> but also <b>how they relate</b> to each other.
            </p>
            <p>To help you forget less of the material on your Connected Flashcards, StemmaStudy makes use of <b>Spaced Repetition</b>. 
                Spaced Repetition helps <b>grow and maintain strong memories</b> by automatically scheduling reviews of flashcards based on how well you know them. 
                It is a system that <b>optimizes your review</b> for long-term memory retention.</p>
            <p>This tutorial will show you <b>how to use Connected Flashcards</b> on StemmaStudy.</p>

            <hr class="my-4">

            <h2>Create a Set</h2>
            <p>Sets hold the flashcards you create. Every flashcard on StemmaStudy belongs to a Set. Think of them as a stack or deck of <b>related cards</b>. You might choose to have one Set for each class you are taking or book you are reading.</p>
            <p>To create a new Set, click <b>My Sets</b> in the site navigation. Then, click the <b>New</b> button at the top right of the page.</p>
            <img src="{{ asset('/image/tutorial/NewSet.png')}}" class="tut-img shadow" />
            <p>Enter in a good title, typically your class name or the topic of study, and a short description. Click <b>Create</b>.</p>
            <hr class="my-4">

            <h2>Add Cards to the Set</h2>
            <p>Once you have created a set, it is time to start adding some cards. Each set can hold up to <b>1000 cards</b>.</p>
            <p>From your <b>My Sets</b> page, click the <b>List</b> button on a Set.</p>
            <img src="{{ asset('/image/tutorial/SetBoxList.png')}}" class="tut-img shadow" />
            <p>Once you have added some cards, this page will show them. Click the <b>New</b> button at the top right to create a new card, which will show a form like this:</p>
            <img src="{{ asset('/image/tutorial/NewCard.png')}}" class="tut-img shadow" />
            <p>Enter in a good, <b>distinct title</b> for the thing you are trying to remember (like "George Washington" or "Mitochondria") as well as a short definition. 
                Definitions are more likely to be remembered if they are <b>your own words</b>, rather than copied from a textbook or website.
            </p>
            <p>If you find yourself creating a long card, consider splitting it up into multiple cards, if possible.</p>
            <hr class="my-4">

            <h2>Connect Cards Together</h2>
            <p>Once you have added a couple of cards to a Set, you can <b>start connecting them</b>.</p>
            <p>Connections are a way to <b>show relationships between cards</b>. For example, you can connect a card about a person to cards about their discoveries or connect events to their causes and effects. </p>
            <p>To create a connection, navigate to one of the cards you want to connect. You can get there by clicking <b>View Details</b> from the List page. Click the gray <b>New</b> button.</p>
            <img src="{{ asset('/image/tutorial/NewConnection.png')}}" class="tut-img shadow" />
            <p>Specify the direction of the connection and the other card to connect to. Then, give a name for the relationship and, optionally, provide any information about it that you might need to remember.</p>
            <p>You can also create connections from the <b>Network</b> page, as you will see in the next section.</p>
            <div class="p-3 raised-box">
                <h4><b>Heads up!</b></h4>
                <p>When first starting, you might know two flashcards are connected in some way, but struggle to come up with a name for the relationship. 
                    This is perfectly normal. You'll get the hang of it with time as you discover patterns.</p>
                <p>If one starts giving you too much trouble, then put something there as a placeholder and come back to it once you've had some time to study more of the material.</p>
            </div>
            <hr class="my-4">

            <h2>View the Big Picture</h2>
            <p>From the <b>My Sets</b> page, click <b>Network</b> to see a birds-eye view of your cards and how they are connected.</p>
            <img src="{{ asset('/image/tutorial/BigPicture.png')}}" class="tut-img shadow" />
            <p>Click the title of a card or the connections to <b>see more details</b>.</p>
            <p>Click and drag to move the cards around if you want to <b>arrange them on the screen</b>. Positions of the cards are saved. However, when returning to the Network after creating new cards, it will shift to automatically incorporate the new cards.</p>
            <p>The <b>Network</b> page will help you gain a deeper understanding of how concepts are related as you add connections and arrange the cards.</p>
            <hr class="my-4">

            <h2>Maintain Strong Memories</h2>
            <p>StemmaStudy <b>optimizes your review</b> for you so that you remember things long-term. When cards are due for review, you'll see a red number in the <b>Review</b> button on the <b>My Sets</b> page like this:</p>
            <img src="{{ asset('/image/tutorial/DueForReview.png')}}" class="tut-img shadow" style="width: auto;" />
            <p>Click that button to go to the <b>Review</b> page.</p>
            <p>Then, click the link in the <b>Memory Maintenance</b> box to begin self-test reviewing.</p>
            <img src="{{ asset('/image/tutorial/ReviewMaintenance.png')}}" class="tut-img shadow" />
            <div class="p-3 mt-5 raised-box">
                <h4><b>How to Self-Test Review</b></h4>
                <p>The review will start by showing you the title of a card. 
                    Try calling to mind every detail about that card &ndash; the definition, what it is related to, and any information you'd need to know about the relationships. 
                    Then, click <b>Show</b> to see the details of the card. 
                </p>
                <p>At the bottom, you'll be asked to rate how well you think you did remembering the card on a sliding scale. Be brutally honest! This score helps StemmaStudy to automatically schedule your review. </p>
                <p>Generally, you should score yourself along these lines:
                    <ul>
                        <li><span class="score_color_100"><b>Green</b></span>: You recalled everything well.</li>
                        <li><span class="score_color_50"><b>Yellow</b></span>: You recalled most of the details with difficulty.</li>
                        <li><span class="score_color_0"><b>Red</b></span>: You recalled very little of the details.</li>
                    </ul>
                </p>
            </div>
            <hr class="my-4">

            <h2>Discover Your Memory Weaknesses</h2>
            <p>Sometimes you might want to do more review than normal memory maintenance, such as when you have a big test coming up. For these times, you should try an <b>Assessment</b>.</p>
            <p>On the <b>Review</b> page, click the <b>New</b> button in the Assessment box.</p>
            <img src="{{ asset('/image/tutorial/ReviewAssessment.png')}}" class="tut-img shadow" />
            <p>This will take you through a self-test of all the cards in your set.</p>
            <p>Once the Assessment is over, you'll be able to see your scores on each card in the context of the <b>Network</b> view. 
                This can be a great way to study as you can <b>focus on poor-performing cards</b> related to the cards you know well.
                You might even <b>find clusters</b> of poor-performing cards which could prompt you to re-examine entire sections of your coursework related to those cards.
            </p>
            <img src="{{ asset('/image/tutorial/AssessmentResult.png')}}" class="tut-img shadow" />
            <hr class="my-4">

            <h2>Essential Study Techniques</h2>
            <p>While StemmaStudy was made to help you understand more and forget less, there are many <b>other things you can do to improve</b> your learning!</p>
            <p>We've written a small (5 minute read) guide to some of the <b>most effective and practical principles</b> to improve your studying so that you can understand, remember, and achieve more.</p>
            <div class="text-center">
                <a href="{{route('learn')}}" class="btn btn-primary">Read the Guide <i class="fas fa-angle-double-right"></i></a>
            </div>
        </div>
    </div>
</div>

@guest
<div class="d-flex justify-content-center py-5 px-3 mt-5 you-are-container">
    <div class="you-are text-center">
        <h1>Ready to Begin?</h1>
        <h4 class="text-body">Try StemmaStudy free for 30 days and start understanding and remembering more.</h4>
        <a href="{{route('register')}}" class="btn btn-light mt-3">Start my Free Trial <i class="fas fa-angle-double-right"></i></a>
    </div>
</div>
@else
<div class="d-flex justify-content-center py-5 px-3 mt-5 you-are-container">
    <div class="you-are text-center">
        <h1>Ready to Begin?</h1>
        <a href="{{route('user_sets')}}" class="btn btn-light mt-3">Go to My Sets <i class="fas fa-angle-double-right"></i></a>
    </div>
</div>
@endguest



@endsection

@section('scripts')

@endsection