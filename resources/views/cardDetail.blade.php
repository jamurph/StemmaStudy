@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
        
            
            <a class="text-decoration-none mb-3 d-block" href="{{route('cards_in_set', $set->id)}}"><i class="fas fa-arrow-left"></i> Back to {{$set->title}}</a>
                
        
            <div class="card-detail shadow-sm mb-4">
                <h1 class="m-0">{{ $card->title }}</h1>
                <hr>
                <p>{{$card->definition}}</p>
            </div>

            @if (count($card->connectionsIn) > 0)
                <div class="d-flex mt-5 mb-2 align-items-center justify-content-between">
                    <h3 class="m-0">Connected From</h1>
                    <a href="#" class="btn btn-secondary ml-3 new-btn"><i class="fas fa-plus"></i> New</a>
                </div>
                @foreach ($card->connectionsIn as $in)
                <div class="card-connection shadow-sm mb-3">
                    <a href="{{ route('user_card', $in->fromCard->id)}}" class="text-decoration-none"><h4><i class="fas fa-arrow-left"></i> {{ $in->fromCard->title }}</h4></a>
                    <h5 class="m-0"><i class="fas fa-angle-double-right"></i> <b>{{$in->title}}</b> <i class="fas fa-angle-double-right"></i></h5>
                    @if (!empty($in->description))
                    <p class="text-muted">{{$in->description}}</p>
                    @endif
                </div>
                @endforeach
            @endif
            
            @if (count($card->connectionsOut) > 0)
                <div class="d-flex mt-5 mb-2 align-items-center justify-content-between">
                    <h3 class="m-0">Connected To</h1>
                    <a href="#" class="btn btn-secondary ml-3 new-btn"><i class="fas fa-plus"></i> New</a>
                </div>
                @foreach ($card->connectionsOut as $out)
                <div class="card-connection shadow-sm mb-3">
                    <h5 class="m-0"><i class="fas fa-angle-double-right"></i> <b>{{$out->title}}</b> <i class="fas fa-angle-double-right"></i></h5>
                    @if (!empty($out->description))
                    <p class="text-muted">{{$out->description}}</p>
                    @endif
                    <a href="{{ route('user_card', $out->toCard->id)}}" class="text-decoration-none"><h4 class="text-right">{{ $out->toCard->title }} <i class="fas fa-arrow-right"></i></h4></a>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
