@extends('layouts.blank')

@section('title', 'StemmaStudy | Assessment Results')

@section('header')

<script src="{{asset('js/assessmentNetwork.js')}}"></script>
@endsection

@section('content')

<a href="{{route('set_review', [$set])}}" class="btn btn-secondary btn-sm" style="position: absolute; top: 10px; left: 10px; z-index:10000;"><i class="fas fa-arrow-left"></i> Back</a>
<div id="network" style="width: 100%; height: 100vh;background:var(--light);"></div>

<div id="loader" class="spinner-container">
    <div class="shadow-lg spinner-box">
        <div class="spinner-border text-primary"></div>
        <img src="{{asset('/image/icon500.png')}}" class="spinner-icon">
        <p id="loader-message" class="mt-5 text-muted">Initializing...</p>
    </div>
</div>
@endsection

@section('scripts')
<script>
    set_id = '{{$set->id}}';
    has_new_cards = {{ ($set->cards->contains('is_new', true)) ? "true" : "false"  }};
    network_elements = [
            @foreach ($set->cards as $card)
                {
                    data: { 
                            id: 'card-{{$card->id}}', 
                            label: {!! json_encode($card->title) !!}, 
                            definition: {!! json_encode($card->definition) !!}, 
                            card_id : '{{$card->id}}',
                            score : {{$assessment->assessmentCardScore($card->id)}},
                        },
                        position: {
                            x : {{$card->position_x}},
                            y : {{$card->position_y}}
                        } 
                },
            @endforeach
            @foreach ($connections as $connection)
                {
                    data: { 
                        id: 'connection-{{$connection->id}}', 
                        label: {!! json_encode($connection->title) !!}, 
                        description: {!! json_encode($connection->description) !!}, 
                        source: 'card-{{$connection->fromCard->id}}', 
                        target: 'card-{{$connection->toCard->id}}',
                    }
                },
            @endforeach
        ];
</script>
@endsection