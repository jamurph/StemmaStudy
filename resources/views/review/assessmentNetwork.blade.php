@extends('layouts.blank')

@section('title', 'StemmaStudy | Assessment Results')

@section('header')

<script src="{{asset('js/assessmentNetwork.js')}}"></script>
@endsection

@section('content')

<a href="{{route('set_review', [$set])}}" class="btn btn-secondary btn-sm" style="position: absolute; top: 10px; left: 10px; z-index:10000;"><i class="fas fa-arrow-left"></i> Back</a>
<div id="network" style="width: 100%; height: 100vh;background:var(--light);"></div>


@endsection

@section('scripts')
<script>
    set_id = '{{$set->id}}';
    network_elements = [
            @foreach ($set->cards as $card)
                {
                    data: { 
                            id: 'card-{{$card->id}}', 
                            label: {!! json_encode($card->title) !!}, 
                            definition: {!! json_encode($card->definition) !!}, 
                            card_id : '{{$card->id}}',
                            score : {{$assessment->assessmentCardScore($card->id)}},
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