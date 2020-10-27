@extends('layouts.app')

@section('title', 'Connected Flashcards | StemmaStudy')

@section('header')
<meta name="description" content="Learn and remember more by connecting ideas, discovering gaps in your understanding, and efficiently reviewing the concepts you struggle with the most.">
<meta property="og:title" content="Connected Flashcards | StemmaStudy">
<meta property="og:description" content="Learn and remember more by connecting ideas, discovering gaps in your understanding, and efficiently reviewing the concepts you struggle with the most.">
<meta property="og:image" content="{{asset('/image/ConnectTheDots.png')}}">
<meta property="og:url" content="{{route('home')}}">
<meta name="twitter:card" content="summary_large_image">

<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<style>
    p {
        font-size: 18px;
    }

    ul {
        font-size: 18px;
    }
</style>
@endsection

@section('content')
<div class="position-relative">
    <div id="particles-js"></div>
    <div class="particle-cover"></div>
    <div class="d-flex justify-content-center p-2">
        <div class="home-head">
            <h1 class="px-2"><b>You Can Do Better</b></h1>
            <h4 class="px-2 mt-4">Forget flashcards as you know them. Connected Flashcards help you learn and remember by connecting ideas, discovering gaps in your understanding, and efficiently reviewing the concepts you struggle with the most.</h4>
            <div class="px-2 mt-4 mb-3">
                <a href="{{route('register')}}" class="btn btn-primary">Free Trial <i class="fas fa-angle-double-right"></i></a>
                <a href="{{route('tutorial')}}" class="btn btn-outline-primary">View the Tutorial</a>
            </div>
        </div>
    </div>
</div>

<div class="home-learning px-3 py-5">
    <h2>
        Understand More.<br class="d-md-none" /> Forget Less.
    </h2>
    <a href="{{route('learn')}}" class="btn-light btn mt-2">How To Study Smarter <i class="fas fa-angle-double-right"></i></a>
</div>

<div class="container">
    <div class="row py-5">
        <div class="col-lg-6">
            <h2>Connect the Dots.</h2>
            <p>Discover the big picture &ndash; one connection at a time. Creating connections helps you:</p>
            <ul>
                <li>Find and bridge gaps in your understanding.</li>
                <li>Integrate new concepts into your existing knowledge.</li>
                <li>Gain top-down understanding from bottom-up facts.</li>
                <li>Create mental "hooks" to help remember concepts.</li>    
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
            <h2>Maintain Strong Memories.</h2>
            <p>StemmaStudy uses the tried-and-true method of Spaced Repetition to help you:</p>
            <ul>
                <li>Study the concepts you find most difficult more often.</li>
                <li>Efficiently space study to take advantage of your brain's natural memory processes.</li>
                <li>Maximize memory retention over the long-term.</li>
            </ul>
        </div>
    </div>
    <div class="row py-5">
        <div class="col-lg-6 ">
            <h2>Concentrate Your Effort Where It Matters.</h2>
            <p>StemmaStudy Assessments help you:</p>
            <ul>
                <li>See your performance on each card in context of the big picture.</li>
                <li>Focus on poor-performing cards related to the cards you know well.</li>
                <li>Plan your future learning efforts based on the results.</li>
            </ul>
        </div>
        <div class="col-lg-6">
            <img src="{{asset('/image/ConcentrateYourEffort.png')}}" class="img w-100" />
        </div>
    </div>
    <div class="mb-5"></div>
</div>

<div class="container mb-5">
    <hr/>
    <h2 class="text-center mt-5 mb-4">Pricing</h2>
    <div class="price-box shadow" style="">
        <div class="text-center"><span class="price green"><small class="text-dark text-muted">$</small>4<sup>.99</sup><small class="text-dark text-muted">/mo</small></span></div>
        <div class="text-center text-muted">Make better memories for the price of your morning coffee. <span style="font-size: 120%">&#x2615;</span></div>
        <div class="text-center mt-3">
            Try it free for 30 days &ndash; no strings attached &ndash; and see how much more you remember!
        </div>
        <div class="mt-4 mb-4 text-center">
            <a href="{{route('register')}}" class="btn btn-primary">Start Free Trial <i class="fa fa-angle-double-right"></i></a>
        </div>
    </div>
</div>


<div class="d-flex justify-content-center py-5 px-3 you-are-container">
    <div class="you-are text-center">
        <h1>You Are What You Remember</h1>
        <h4>Don't study just to pass a test.<br class="d-lg-none"/> Study to make strong memories.</h4>
        <a href="{{route('learn')}}" class="btn btn-light mt-3">How to Remember More <i class="fas fa-angle-double-right"></i></a>
    </div>
</div>


@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        particlesJS("particles-js", 
        {
            "particles":{
                "number":{
                    "value":40,
                    "density":{
                        "enable":true,
                        "value_area":800
                    }
                },
                "color":{
                    "value":"#ffffff"
                },
                "shape":{
                    "type":"polygon",
                    "stroke":{
                        "width":4,
                        "color":"#28aa80"
                    },
                    "polygon":{
                        "nb_sides":4
                    }
                },
                "opacity":{
                    "value":1,
                    "random":false
                },
                "size":{
                    "value":10,
                    "random":false,
                },
                "line_linked":{
                    "enable":true,
                    "distance":170,
                    "color":"#192332",
                    "opacity":1,
                    "width":1
                },
                "move":{
                    "enable":true,
                    "speed":3.5,
                    "direction":"none",
                    "random":false,
                    "straight":false,
                    "out_mode":"out",
                    "bounce":false,
                    "attract":{
                        "enable":false,
                        "rotateX":600,
                        "rotateY":1200
                    }
                }
            },
            "interactivity":{
                "detect_on":"canvas",
                "events":{
                    "onhover":{
                        "enable":false,
                        "mode":"grab"
                    },
                    "onclick":{
                        "enable":false,
                        "mode":"push"
                    },
                    "resize":true
                },
                "modes":{
                    "grab":{
                        "distance":400,
                        "line_linked":{
                        "opacity":1
                        }
                    },
                    "bubble":{
                        "distance":400,
                        "size":40,
                        "duration":2,
                        "opacity":8,
                        "speed":3
                    },
                    "repulse":{
                        "distance":200,
                        "duration":0.4
                    },
                    "push":{
                        "particles_nb":4
                    },
                    "remove":{
                        "particles_nb":2
                    }
                }
            },
            "retina_detect":true
            }
        );  
    });
</script>
@endsection