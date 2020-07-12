@extends('layouts.blank')

@section('header')
@if ($cards->count() != 0)
<script src="{{mix('js/setNetwork.js')}}"></script>
@endif
@endsection

@section('content')
<a href="{{route('user_sets')}}" class="btn btn-secondary btn-sm" style="position: absolute; top: 10px; left: 10px; z-index:10000;"><i class="fas fa-arrow-left"></i> Back</a>
<div id="network" style="width: 100%; height: 100vh;background:var(--light);">
    @if ($cards->count() == 0)
        <div class="text-center" style="padding: 10px; padding-top: 70px;">
            <h2>It's pretty empty here, right now.</h2>
            <p>First, create some cards and connections. Then, use this page to see how everything comes together.</p>
            <a href="{{route('card_create', $set->id)}}" class="btn btn-primary"><i class="fas fa-plus"></i> New Card</a>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    set_id = '{{$set->id}}';
    network_elements = [
            @foreach ($cards as $card)
                {
                    data: { 
                            id: 'card-{{$card->id}}', 
                            label: {!! json_encode($card->title) !!}, 
                            definition: {!! json_encode($card->definition) !!}, 
                            card_id : '{{$card->id}}' 
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