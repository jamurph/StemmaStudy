@extends('layouts.blank')

@section('title', 'StemmaStudy | Memory Maintenance')

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
                <a href="{{route('set_review', [$set])}}" class="text-decoration-none"><i class="fas fa-arrow-left"></i> Exit Maintenance</a>
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
            @if ($card->connectionsIn->count() > 0 || $card->connectionsOut->count() > 0)
            <div id="connections" style="display:none;">
                <h3 class="mt-5 mb-2">Connections</h3>
                @foreach ($card->connectionsIn as $in)
                <div class="card-connection shadow-sm mb-3">
                    <h4><i class="fas fa-arrow-left"></i> {{ $in->fromCard->title }}</h4>
                    <h5 class="m-0"><i class="fas fa-angle-double-right"></i> <b>{{$in->title}}</b> <i class="fas fa-angle-double-right"></i></h5>
                    @if (!empty($in->description))
                    <p class="text-muted has-newlines">{{$in->description}}</p>
                    @endif
                </div>
                @endforeach
                @foreach ($card->connectionsOut as $out)
                <div class="card-connection shadow-sm mb-3">
                    <h5 class="m-0"><i class="fas fa-angle-double-right"></i> <b>{{$out->title}}</b> <i class="fas fa-angle-double-right"></i></h5>
                    @if (!empty($out->description))
                    <p class="text-muted has-newlines">{{$out->description}}</p>
                    @endif
                    <div class="text-right">
                       <h4 class="mt-2 mb-0">{{ $out->toCard->title }} <i class="fas fa-arrow-right"></i></h4>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            <div id="scoring" class="mb-5" style="display: none; min-height: 170px;">
                <h3 class="text-center">How did you do?</h3>
                <form class="mt-4" method="POST" action="{{route('set_maintenance_put', [$set])}}">
                    @csrf
                    @method('PUT')
                    <input name="card_id" type="hidden" value="{{$card->id}}" >
                    <div class="form-group">
                        <input name="score" type="range" min="0" max="100" class="form-control-range" id="score">
                        <small class="form-text text-muted" id="score-num">50</small>
                    </div>
                    <button id="nextBtn" type="submit" class="btn btn-block btn-outline-primary mt-4 d-none">Next</a>
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
            $('#connections').show();
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