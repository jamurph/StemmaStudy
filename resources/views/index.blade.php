@extends('layouts.app')

@section('header')
<script src="http://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<style>

    #particles-js { 
        position:absolute; 
        width: 100%; 
        height: 100%;
        background: linear-gradient(#f8fafc, #ffffff);
    }

    .btn-outline-primary {
        background: #f8fafc;
    }

    .home-head {
        z-index: 1;
        flex: 0 0 100%;
        max-width: 700px;
        width: 100%;
    }

    .home-learning {
        background: var(--light-acc);
        width: 100%;
        text-align: center;
    }

    .you-are {
        flex: 0 0 100%;
        max-width: 700px;
        width: 100%;
    }

    .you-are-container {
        background: var(--light-acc);
    }

</style>
@endsection

@section('content')
<div class="position-relative">
    <!-- Particles.js background to mimic network view? -->
    <div id="particles-js"></div>
    <div class="d-flex justify-content-center p-2">
        <div class="home-head">
            <h1 class="px-2 mt-5"><b>Forget Flashcards as You Know Them</b></h1>
            <h4 class="px-2 mt-4">Learn and remember more by connecting ideas, discovering gaps in your understanding, and efficiently reviewing the concepts you struggle with the most.</h4>
            <div class="px-2 mt-4 mb-5">
                <a href="#" class="btn btn-primary">Free Trial</a>
                <a href="#" class="btn btn-outline-primary">Watch the Tutorial</a>
            </div>
            <div class="pt-5"></div>
        </div>
    </div>
</div>

<div class="home-learning px-3 py-5">
    <h2>
        Understand More.<br class="d-md-none" /> Forget Less.
    </h2>
    <a href="#" class="btn-light btn mt-2">How To Study Smarter <i class="fas fa-angle-double-right"></i></a>
</div>

<div class="container">
    <div class="row py-5">
        <div class="col-lg-6">
            <h2>Connect the Dots.</h2>
            <p>Discover the big picture &ndash; one connection at a time. Creating connections helps you:</p>
            <p><ul>
                <li>Integrate new items into your existing knowledge.</li>
                <li>Find and bridge gaps in your understanding.</li>
                <li>Gain top-down understanding from bottom-up facts.</li>
                <li>Create mental "hooks" to help remember concepts.</li>    
            </ul></p>
        </div>
        <div class="col-lg-6">
        </div>
    </div>
    <div class="row py-5">
        <div class="col-lg-6">
        </div>
        <div class="col-lg-6">
            <h2>Maintain Strong Memories.</h2>
            <p>StemmaStudy uses the tried-and-true method of Spaced Repetition to help you:</p>
            <p><ul>
                <li>Study the concepts you find most difficult more often.</li>
                <li>Efficiently space study to take advantage of your brain's natural memory processes.</li>
                <li>Maximize memory retention over the long-term.</li>
            </ul></p>
        </div>
    </div>
    <div class="row py-5">
        <div class="col-lg-6">
            <h2>Concentrate Your Effort Where It Matters</h2>
            <p>StemmaStudy Assessments help you:</p>
            <p><ul>
                <li>See your performance on each card in context of the big picture.</li>
                <li>Focus on poor-performing cards related to the cards you know well.</li>
                <li>Plan your future learning efforts based on the results.</li>
            </ul></p>
        </div>
        <div class="col-lg-6">
        </div>
    </div>
    <div class="mb-5"></div>
</div>

<div class="d-flex justify-content-center py-5 px-3 you-are-container">
    <div class="you-are text-center">
        <h1>You Are What You Remember</h1>
        <h4>Don't study just to pass a test.<br class="d-lg-none"/> Study to become unforgettable.</h4>
        <a href="#" class="btn btn-light mt-3">Start Free Trial <i class="fas fa-angle-double-right"></i></a>
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