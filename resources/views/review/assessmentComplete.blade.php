@extends('layouts.blank')

@section('title', 'StemmaStudy | Assessment Results')

@section('header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/rangeslider.js/2.3.3/rangeslider.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rangeslider.js/2.3.3/rangeslider.min.js"></script>
    <style>
        
        #scoring {
            max-width: 400px;
            margin:auto;
        }

    </style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 mt-4 text-center">
            <h1>Assessment Complete</h1>
            <p># of Cards Assessed: {{ $assessment->assessmentCards->count() }}<p>
            <p>Average Score: <br/><span style="font-size: 70px; font-weight: bold;" class="score_color_{{ round( $assessment->score / 5 ) * 5 }}">{{ $assessment->score }}</span></p>
            <div>
                <a href="{{route('user_sets')}}" class="btn btn-link text-decoration-none"><i class="fas fa-arrow-left"></i> Back to My Sets</a>
                <a href="{{route('assessment_network', [$assessment->set, $assessment])}}" class="btn btn-primary">View Details <i class="fas fa-angle-double-right"></i></a>
            </div>
        </div>
    </div>
</div>
@endsection