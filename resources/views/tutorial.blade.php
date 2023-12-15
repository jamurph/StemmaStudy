@extends('layouts.app')

@section('title', 'StemmaStudy Tutorial | What is StemmaStudy?')

@section('header')
<meta name="description" content="StemmaStudy is a study tool designed to help you make the most of your study time by creating and reviewing Connected Flashcards.">
<meta property="og:title" content="StemmaStudy Tutorial | What is StemmaStudy? ">
<meta property="og:description" content="StemmaStudy is a study tool designed to help you make the most of your study time by creating and reviewing Connected Flashcards.">
<meta property="og:image" content="{{asset('/image/MaintainStrongMemories.png')}}">
<meta property="og:url" content="{{route('tutorial')}}">
<meta name="twitter:card" content="summary_large_image">

<style>
    
    p, li {
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
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="image-title">
                <h3>StemmaStudy Tutorial</h3>
                <img src="{{asset('/image/Brain.png')}}" />
            </div>
            <h1 class="mt-5">What Is StemmaStudy?</h1>
            <p>
                StemmaStudy is a study tool designed to help you make the most of your study time. Expending a lot of effort to study using bad methods, such as 
                simply rereading a textbook, will waste a lot of time while creating fragile and short-lived memories. 
                StemmaStudy is designed to make it easier to study using better methods that take advantage of the brain's natural memory processes &ndash; leading to strong,
                well-integrated, and long-lasting memories.
            </p>
            <p>
                That being said, meaningful learning is hard. Just as no exercise machine can remove the burning sensation in your muscles, 
                StemmaStudy won't make your learning effortless. 
                Rather, StemmaStudy is designed to make your study more effortful where &ndash; and when &ndash;  that extra effort can make the most difference.
            </p>
            <p>
                So, with a little discipline and persistence, StemmaStudy will help you build and maintain some massive memory muscles!
            </p>
            <div class="mt-5 mb-5 text-center">
                <p class="mb-3"><b>Want to learn more about what can make your learning efforts more effective?</b></p>
                <a target="_blank" href="{{route('learn')}}" class="btn btn-primary">How to Study Smarter</a>
            </div>
            <hr class="my-5">
            <h1 class="mt-5">How Does StemmaStudy Work?</h1>
            <p>Using StemmaStudy isn't complicated. Here's what you do:</p>
            <ul>
                <li>Create Flashcards.</li>
                <li>Connect Flashcards.</li>
                <li>Review Connected Flashcards.</li>
            </ul>
            <p>
                Let's unpack each of these a bit.
            </p>
            
            <h3 class="mt-5">Create Flashcards</h3>
            <p>
                Flashcards are a tried-and-true staple of good studying. You might be familiar with traditional paper flashcards &ndash;  where you write the title of a key 
                vocabulary term on one side of a small card and its description on the other. 
                Well, StemmaStudy's Connected Flashcards are similar. 
                Each digital flashcard is composed of a title and a description.
            </p>
            <p>On StemmaStudy, descriptions can be more than just plain text &ndash; 
                consider sprucing them up by adding images as well as formatting to make the main ideas more obvious.
            </p>
            <div class="raised-box p-4 mb-3">
                <h4>A word of advice:</h4>
                <p>To get the most out of your flashcards, write the descriptions in your own words and write them as if someone unfamiliar with the material 
                    was going to learn it from your flashcards. Don't let the descriptions get too large! 
                    Flashcards are meant to help you split your study material into smaller chunks, so copy-pasting large portions of paragraph text won't help you as much. 
                    If you feel like a description is getting too large, find a way to split the card and &ndash; as you will see in the next section &ndash; connect those cards!
                </p>
            </div>
            <p>
                Just like you might keep traditional paper flashcards separated by class or chapter, 
                every flashcard you create on StemmaStudy belongs to a Set. Sets can be pretty big: up to 1000 cards each!
            </p>

            <h3 class="mt-5">Connect Flashcards</h3>
            <p>
                Real knowledge is interconnected. Inventions have inventors. Events have consequences. Systems have structure. 
                Term definitions do not capture all there is to know about a topic &ndash; it is also crucially important to understand how the concepts you learn are related.
            </p>
            <p>
                Additionally, knowing the way concepts relate to each other makes it easier to remember those concepts! 
                It's like creating mental pathways &ndash; if an idea you need to remember is connected to others, you'll be more likely to find your way to it.
            </p>
            <p>
                StemmaStudy is designed to help you tap into this principle by connecting flashcards to each other &ndash; forming a network. 
                You can view this network and organize your flashcards based on the way they relate. This forms a useful top-down visualization of the material 
                you are learning that helps you build "big-picture" understanding and see where you have gaps in your understanding.
            </p>
            <p>
                You can think of the network as creating a map for your mind. It's much harder for your mind to get lost when you have it!
            </p>
            <img style="display: block; width: 50%; margin:auto;" src="{{asset('/image/tutorial/NetworkConcept.png')}}" />

            <h3 class="mt-5">Review Connected Flashcards</h3>
            <p>
                If you want to be a good writer, you practice writing. 
                If you want to be good at your favorite sport, you practice that sport. 
                Similarly, if you want to be able to remember something long-term, the best thing you can do is practice remembering it. 
                This means testing yourself and trying to remember the material without looking at it.
            </p>
            <p>
                StemmaStudy guides you through this process of self-test reviewing. 
                You'll be given a title of a card and asked to recall all of the details of that card and how it is connected to others. 
                Once you've recalled all that you can muster, you'll be shown the details of the card and asked to rate how well you did. 
            </p>
            <p>
                It's important to be brutally honest about how much you recalled when reviewing &ndash; the score you provide is fed into what is known as a "Spaced Repetition" algorithm. 
                This algorithm's job is to determine when it is most useful to review each card. Hard cards will be reviewed more often. Easy cards will be reviewed less and less. 
                By using this method, your study time is optimized to be as meaningful as possible.
            </p>
            <div class="raised-box p-4 mb-3">
                <h4>Assessments</h4>
                <p>
                    While the Spaced Repetition algorithm is designed to spread review out over time to maximize long-term memory, 
                    at times you may want a more immediate snapshot of your understanding &ndash; such as when you've got a big test coming up. 
                    For these times, try taking an Assessment.
                </p>
                <p>
                    Assessments are straightforward: the system takes you through a self-test of every card in the set. 
                    Of course, this is useful in itself as a method of review, but the real magic of assessments is the visualization of the results. 
                    Once you complete an assessment, you'll see a visualization of how well you did within the network structure you created. 
                    This can help inform your study. For example, if you see clusters of connected cards that you performed poorly on, 
                    you might consider revisiting the source material for that section.
                </p>
                <img style="display: block; width: 50%; margin:auto;" src="{{asset('/image/tutorial/AssessmentConcept.png')}}" />
            </div>

            <hr class="mt-5">
            <h1 class="mt-5">You Are What You Remember</h1>
            <p>
                Whether you're learning to become a doctor, historian, lawyer, CEO, or just a general mastermind, StemmaStudy is here to help you become a better one. 
            </p>
            <p>
                Success is addicting. We're confident that if you challenge yourself to use StemmaStudy persistently for just 1 month you'll be able to feel the difference 
                it makes in your memory. 
            </p>
        </div>
    </div>
</div>

@guest
<div class="d-flex justify-content-center py-5 px-3 mt-5 you-are-container">
    <div class="you-are text-center">
        <h1>Ready to Begin?</h1>
        <h4 class="text-body">Try StemmaStudy free for 30 days and start understanding and remembering more.</h4>
        <a href="{{route('register')}}" class="btn btn-light mt-3">Start Free Trial</a>
    </div>
</div>
@else
<div class="d-flex justify-content-center py-5 px-3 mt-5 you-are-container">
    <div class="you-are text-center">
        <h1>Ready to Begin?</h1>
        <a href="{{route('user_sets')}}" class="btn btn-light mt-3">Go to My Sets</a>
    </div>
</div>
@endguest



@endsection

@section('scripts')

@endsection