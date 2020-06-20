@extends('layouts.blank')

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
        <div class="col-lg-8 mt-4">
            <div class="p-2">
                <a href="{{route('set_review', [$set])}}" class="text-decoration-none"><i class="fas fa-arrow-left"></i> Exit Assessment</a>
                <span class="float-right"><small>{{$assessment->assessmentCards->count() + 1}}/{{$set->cards->count()}}</small></span>
                <p><small>Attempt to recall the details of this card. Then, click "Show" and rate how well you did.</small></p>
            </div>
            <div class="card-detail shadow-sm mb-4">
                <h1 class="m-0">{{ $card->title }}</h1>
                <hr>
                <div style="min-height: 27px">
                    <div style="display: none" class="" id="definition">
                        <div>
                            {!! $card->trixRender('content') !!}
                        </div>
                    </div>
                    <div class="show-button text-center mouse-over green"><i class="fas fa-angle-down"></i> Show <i class="fas fa-angle-down"></i></div>
                </div>
            </div>
            <div id="scoring" class="mt-6" style="display: none;">
                <h3 class="text-center">How did you do?</h3>
                <form class="mt-4" method="POST" action="{{route('assessment_card_store', [$set,$assessment])}}">
                    @csrf
                    <input name="card_id" type="hidden" value="{{$card->id}}" >
                    <div class="form-group">
                        <input name="score" type="range" min="0" max="100" class="form-control-range" id="score">
                        <small class="form-text text-muted" id="score-num"></small>
                    </div>
                    <button id="nextBtn" type="submit" class="btn btn-block btn-outline-primary mt-4 mb-5 d-none">Next</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('.show-button').click(function(){
            $(this).hide();
            $('#definition').show();
            $('#scoring').show();
        });

        $('#score').rangeslider({
            polyfill: false,
        });

        $('#score').on('change input propertychange', function(){
            $('#score-num').text($('#score').val());
            if($('#nextBtn').hasClass('d-none')){
                $('#nextBtn').removeClass('d-none');
            }
        });


    });
</script>
@endsection