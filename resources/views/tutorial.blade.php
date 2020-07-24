@extends('layouts.app')

@section('title', 'StemmaStudy Tutorial')

@section('header')
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
            <p>StemmaStudy makes the learning process better. Here's how to use it!</p>

            <hr>

            <h2>Create a Set</h2>
            <p>Sets hold the flashcards you create. Every flashcard on StemmaStudy belongs to a Set. Think of them as a stack or deck of related cards. You might have one Set for each class you are taking or book you are reading.</p>
            <p>To create a new Set, click "My Sets" in the site navigation. Then, click the "New" button at the top right of the page.</p>
            <img src="/image/tutorial/NewSet.png" class="tut-img shadow" />
            <p>Enter in a good title, typically your class name or the topic of study, and a short description. Click "Create."</p>
            <hr>

            <h2>Add Cards to the Set</h2>
            <p>From your "My Sets" page, click the "List" button on a Set. Once you have added some cards, this page will show them.</p>
            <img src="/image/tutorial/SetBoxList.png" class="tut-img shadow" />
            <p>Click the "New" button at the top right to create a new card.</p>
            <img src="/image/tutorial/NewCard.png" class="tut-img shadow" />
            <p>Enter in a good, distinct title for the thing you are trying to remember (like "George Washington" or "Mitochondria") as well as a short definition. If you find yourself creating a long card, try splitting it up into multiple cards and connecting them.</p>
            <hr>

            <h2>Connect Cards Together</h2>
            <p>Once you have added a couple of cards to a Set, you can start connecting them.</p>
            <p>Connections are a way to show relationships between cards. For example, you can connect a card about a person to cards about their discoveries or connect events to their causes and effects.</p>
            <p>To create a connection, navigate to one of the cards you want to connect. You can get there by clicking "View Details" from the List page. Click the gray "New" button.</p>
            <img src="/image/tutorial/NewConnection.png" class="tut-img shadow" />
            <p>Specify the direction of the connection and the other card to connect to. Then, give a title for the relationship and, optionally, provide any information about it that you might need to remember.</p>
            <hr>

            <h2>View the Big Picture</h2>
            <p>From the My Sets page, click "Network" to see a birds-eye view of your cards and how they are connected.</p>
            <img src="/image/tutorial/BigPicture.png" class="tut-img shadow" />
            <p>Click the title of a card or the connections to see more details.</p>
            <p>Click and drag to move the cards around if you want to arrange them on the screen.</p>
            <hr>

            <h2>Maintain Strong Memories</h2>
            <p>StemmaStudy optimizes your review for you so that you remember things long-term. When cards are due for review, you'll see a red number in the "Review" button on the My Sets page like this:</p>
            <img src="/image/tutorial/DueForReview.png" class="tut-img shadow" style="width: auto;" />
            <p>Click that button!</p>
            <p>Then, click the link in the "Memory Maintenance" box to begin self-test reviewing.</p>
            <img src="/image/tutorial/ReviewMaintenance.png" class="tut-img shadow" />
            <hr>

            <h2>Discover Your Memory Weaknesses</h2>
            <p>Sometimes you might want to do more review than normal memory maintenance, such as when you have a big test coming up. For these times, you should try an Assessment.</p>
            <p>On the Review page, click the "New" button in the Assessment box.</p>
            <img src="/image/tutorial/ReviewAssessment.png" class="tut-img shadow" />
            <p>This will take you through a self-test of all the cards in your set.</p>
            <p>Once the Assessment is over, you'll be able to see your scores on each card in the context of the Network view.</p>
            <img src="/image/tutorial/AssessmentResult.png" class="tut-img shadow" />
            <hr>
        </div>
    </div>
</div>

@guest
<div class="d-flex justify-content-center py-5 px-3 mt-5 you-are-container">
    <div class="you-are text-center">
        <h1>Ready to Begin?</h1>
        <h4 class="text-body">Try StemmaStudy free for 30 days and start understanding and remembering more.</h4>
        <a href="/learn" class="btn btn-light mt-3">Start my Free Trial <i class="fas fa-angle-double-right"></i></a>
    </div>
</div>
@else
<div class="d-flex justify-content-center py-5 px-3 mt-5 you-are-container">
    <div class="you-are text-center">
        <h1>Ready to Begin?</h1>
        <a href="/learn" class="btn btn-light mt-3">Go to My Sets <i class="fas fa-angle-double-right"></i></a>
    </div>
</div>
@endguest



@endsection

@section('scripts')

@endsection