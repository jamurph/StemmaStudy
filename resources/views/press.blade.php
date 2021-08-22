@extends('layouts.app')

@section('title', 'Press Kit | StemmaStudy')

@section('header')
<meta name="description" content="Connected Flashcards help make the learning process better. Here's how to create them!">

<style>
    .info-section {
        border-left: 5px solid var(--light-acc);
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        background: white;
    }

    .expander:hover {
        background:rgba(0, 0, 0, 0.075);
        cursor: pointer;
    }

    .info-content {
        padding: 20px;
    }

    .quote {
        padding: 10px;
        margin-left: 10px;
        border: 3px solid var(--light);
        margin-right: 10px;
    }
    
    .example-image {
        display: inline-block;
        margin: 10px 15px 40px 15px;
        border: 2px solid var(--dark-acc);
    }
    
</style>
@endsection

@section('content')
<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="text-center">Press Kit</h1>
            <p class="text-center text-muted">Help Us Spread Good Learning Strategies</p>
            <div class="info-section mt-4">
                <h3 class="text-center pt-3 px-1"><i class="green fas fa-info-circle mr-2"></i><br> About StemmaStudy<br><small class="text-muted">Company Background</small></h3>
                <div id="bus-info" class="collapse">
                    <div class="info-content">
                        <h5><b>What is StemmaStudy?</b></h5>
                        <p>
                            StemmaStudy is an <b>online learning tool</b> that helps users build and retain strong memories by creating networks of <b>Connected Flashcards</b>.
                            Flashcards are a time-tested and research-affirmed method of study. StemmaStudy is a modern rethinking of this classic study method. 
                            <br/>
                            <br/>
                            Real knowledge is interconnected. Inventions have inventors. Events have consequences. Concepts have exemplars. Definitions alone do not capture 
                            all there is to know about a topic. It is important to <b>understand how things relate</b>. Understanding relationships between concepts also makes
                            those concepts <b>easier to remember</b>. Thus, StemmaStudy allows you to create connections between flashcards and <b>study the relations</b> between concepts
                            along with their definitions.
                        </p>
                        <h5><b>Why was StemmaStudy created?</b></h5>
                        <div class="quote">
                            <p>
                                <i class="fas fa-quote-left green"></i>
                                I looked at a long list of completed audiobooks and a shelf full of books I knew I had read. I remembered how well-written some of them were.
                                I remembered how valuable I had thought the material was at the time of reading it. Yet, I couldn't recall any of their
                                main ideas.
                                <br/><br/>
                                I remember wondering what use the time was if I couldn't so much as summarize what I had read. I thought something was wrong with me.
                                <br/><br/>
                                I decided to learn about learning. I discovered that there wasn't anything wrong with me, at all &ndash; I just had really bad learning methods. 
                                In fact, my experience seemed to be the norm. 
                                <br/><br/>
                                Being a software developer, I knew that I could create technology to help guide learning and promote better learning methods. So, in the late summer of 2020, I began working on
                                StemmaStudy.
                            </p>
                            <b>Jacob Murphy</b>, Founder
                        </div>
                        <p>
                            <br/>
                            Expending a lot of effort to study using bad methods, such as simply rereading a textbook, will waste a lot of time while creating weak memories.
                            StemmaStudy was created to <b>make it easier to study using good methods</b> that take advantage of the brain's natural memory processes, leading to strong, long-lasting memories.
                            <br/><br/>
                            There are many great learning tools out there that each take advantage of some basic principle of learning. Unfortunately, very few make any attempt at integrating 
                            multiple of these principles into one system. This is exactly what StemmaStudy was designed to do.
                        </p>
                        <h5><b>What does the future hold for StemmaStudy?</b></h5>
                        <p>
                            No learning system will ever be perfect for all applications at all times for all people. StemmaStudy is not complete.
                            <br/><br/>
                            We know we can improve. As we learn about how StemmaStudy is used, we will improve around that use. As we learn more about the brain and the principles driving
                            strong memory formation, we will add features to take advantage of them.
                            <br/><br/>
                            The best promise we can make to you about the future of StemmaStudy is this: <b>We will always be learning</b>.
                        </p>
                    </div>
                </div>
                <div data-toggle="collapse" data-target="#bus-info" class="expander text-center py-2 text-muted"><i class="fas fa-angle-down mr-2"></i>Expand<i class="fas fa-angle-down ml-2"></i></div>
            </div>
            <div class="info-section mt-4">
                <h3 class="text-center pt-3 px-1"><i class="green fas fa-sitemap mr-2"></i><br> Connected Flashcards Fact Sheet<br><small class="text-muted">Features and Benefits</small></h3>
                <div id="about-cf" class="collapse">
                    <div class="info-content">
                        <p>Here's the gist of StemmaStudy:</p>
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Sets</h4>
                                <ul>
                                    <li>Stay organized by grouping cards by subject.</li>
                                    <li>View all cards in the set in a simple list or from the top-down network view.</li>
                                    <li>Study all the set's cards together on the Review page.</li>
                                </ul>
                                <a class="example-image" href="{{asset('image/press/ExampleMySets.png')}}"><img src="{{asset('image/press/ExampleMySets.png')}}" /></a>
                            </div>
                            <div class="col-md-6">
                                <h4>Cards</h4>
                                <ul>
                                    <li>Enrich your learning by including up to 5 images on each card.</li>
                                    <li>Do more with your card's text by italicizing, bolding, adding links, and more.</li>
                                    <li>Easily format your cards by adding lists, code segments, quotes, and indentations.</li>
                                </ul>
                                <a class="example-image" href="{{asset('image/press/ExampleCard.png')}}"><img src="{{asset('image/press/ExampleCard.png')}}" /></a>
                            </div>
                            <div class="col-md-6">
                                <h4>Connections</h4>
                                <ul>
                                    <li>Connections allow you to state the relationships between concepts.</li>
                                    <li>When reviewing a card, the card's connections are studied alongside the definition.</li>
                                    <li>Each connection creates a visual link on the set's Network View.</li>
                                </ul>
                                <a class="example-image" href="{{asset('image/press/ExampleConnection.png')}}"><img src="{{asset('image/press/ExampleConnection.png')}}" /></a>
                            </div>
                            <div class="col-md-6">
                                <h4>Network View</h4>
                                <ul>
                                    <li>Visually organize the cards in a set.</li>
                                    <li>See how cards cluster based on the connections between them to build "big-picture" understanding.</li>
                                    <li>Find where there are gaps in your understanding and fill them.</li>
                                </ul>
                                <a class="example-image" href="{{asset('image/press/ExampleNetwork.png')}}"><img src="{{asset('image/press/ExampleNetwork.png')}}" /></a>
                            </div>
                            <div class="col-md-6">
                                <h4>Review</h4>
                                <ul>
                                    <li>StemmaStudy utilizes a Spaced Repetition Algorithm to schedule your reviews.</li>
                                    <li>Receive email notifications when you have cards due for review.</li>
                                    <li>The algorithm will help you study the concepts you find most difficult more often, while easier concepts will show up less frequently.</li>
                                </ul>
                                <a class="example-image" href="{{asset('image/press/ExampleReview.png')}}"><img src="{{asset('image/press/ExampleReview.png')}}" /></a>
                            </div>
                            <div class="col-md-6">
                                <h4>Assessments</h4>
                                <ul>
                                    <li>A self-test of all cards in a set.</li>
                                    <li>Visualized assessment results from the network view showing colors on cards based on scores.</li>
                                    <li>Plan further review and see useful patterns in the concepts you find difficult.</li>
                                </ul>
                                <a class="example-image" href="{{asset('image/press/ExampleAssessment.png')}}"><img src="{{asset('image/press/ExampleAssessment.png')}}" /></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-toggle="collapse" data-target="#about-cf" class="expander text-center py-2 text-muted"><i class="fas fa-angle-down mr-2"></i>Expand<i class="fas fa-angle-down ml-2"></i></div>
            </div>
            <div class="info-section mt-4">
                <h3 class="text-center pt-3 px-1"><i class="green fas fa-brain mr-2"></i><br> Learning Science Fact Sheet<br><small class="text-muted">Impactful Information About Learning</small></h3>
                <div id="learning-science" class="collapse">
                    <div class="info-content">
                        <p>Spacing, Testing, Structure, and Production principles introduction and justification</p>
                        <p>(add a quote from me about StemmaStudy combining principles)</p>
                        <p>Mindset and Motivation</p>
                    </div>
                </div>
                <div data-toggle="collapse" data-target="#learning-science" class="expander text-center py-2 text-muted"><i class="fas fa-angle-down mr-2"></i>Expand<i class="fas fa-angle-down ml-2"></i></div>
            </div>
            <div class="info-section mt-4">
                <h3 class="text-center pt-3 px-1"><i class="green fas fa-quote-left mr-2"></i><br> Quote Sheet<br><small class="text-muted">Ready To Use Quotes</small></h3>
                <div id="quote-sheet" class="collapse">
                    <div class="info-content">
                        <p>Full Quotes from Roediger and Kornell</p>
                        <p>Questions and Answers from me of expected FAQ's</p>
                        <ul>
                            <li>Some question that allows me to say StemmaStudy combines several learning principles.</li>
                            <li>quote about my own journey; a lot of information that I have gone through, but no retrievability. The truth is that if we want to be able
                                to retrieve something at a later time, the best thing we can do is <em>practice</em> retrieving it.
                            </li>
                            <li></li>
                        </ul>
                    </div>
                </div>
                <div data-toggle="collapse" data-target="#quote-sheet" class="expander text-center py-2 text-muted"><i class="fas fa-angle-down mr-2"></i>Expand<i class="fas fa-angle-down ml-2"></i></div>
            </div>
            <div class="info-section mt-4">
                <h3 class="text-center pt-3 px-1"><i class="green fas fa-image mr-2"></i><br> StemmaStudy Brand Info<br><small class="text-muted">Name, Images, and Colors</small></h3>
                <div id="brand-images" class="collapse">
                    <div class="info-content">
                        <p>Black and White Logo, Color logo</p>
                        <p>Color Swatches for Green, Blue, and Dark</p>
                        <ul>
                            <li>Green: #28aa80</li>
                            <li>Light Blue: #6ec4be</li>
                            <li>Dark Blue: #192332</li>
                        </ul>
                    </div>
                </div>
                <div data-toggle="collapse" data-target="#brand-images" class="expander text-center py-2 text-muted"><i class="fas fa-angle-down mr-2"></i>Expand<i class="fas fa-angle-down ml-2"></i></div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center py-5 px-3 you-are-container">
    <div class="you-are text-center">
        <h1>Questions Left Unanswered?</h1>
        <h4>Don't let that stop your story.</h4>
        <a href="/contact" class="btn btn-light mt-3">Contact Us <i class="fas fa-angle-double-right"></i></a>
    </div>
</div>
@endsection

@section('scripts')
<script>

    $(document).ready(function(){
        $('.collapse').on('hide.bs.collapse',function(){
            var ele = $(this).parent().find('.expander');
            ele.html('<i class="fas fa-angle-down mr-2"></i>Expand<i class="fas fa-angle-down ml-2"></i>');
        });
        $('.collapse').on('show.bs.collapse',function(){
            var ele = $(this).parent().find('.expander');
            ele.html('<i class="fas fa-angle-up mr-2"></i>Collapse<i class="fas fa-angle-up ml-2"></i>');
        });
    });

</script>
@endsection