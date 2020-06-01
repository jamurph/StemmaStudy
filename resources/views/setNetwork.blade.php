@extends('layouts.app')

@section('header')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{mix('js/setNetwork.js')}}"></script>
@endsection

@section('content')
<div class="container">
<a href="{{route('user_sets')}}" class="text-decoration-none mb-3 d-inline-block"><i class="fas fa-arrow-left"></i> Back to My Sets</a>
</div>
<div id="network" style="width: 100%; height: 80vh;background:white;"></div>

@endsection

@section('scripts')
<script>
    
    network_elements = [
            @foreach ($cards as $card)
                { // node b
                data: { id: 'card-{{$card->id}}', label: '{{$card->title}}' }
                },
            @endforeach
            @foreach ($connections as $connection)
                { // edge ab
                    data: { id: 'connection-{{$connection->id}}', label: "{{$connection->title}}", source: 'card-{{$connection->fromCard->id}}', target: 'card-{{$connection->toCard->id}}' }
                },
            @endforeach

        ]
</script>
@endsection