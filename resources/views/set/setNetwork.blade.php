@extends('layouts.blank')

@section('header')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{mix('js/setNetwork.js')}}"></script>
@endsection

@section('content')

<a href="{{route('user_sets')}}" class="btn btn-secondary btn-sm" style="position: absolute; top: 10px; left: 10px; z-index:10000;"><i class="fas fa-arrow-left"></i> Back</a>
<div id="network" style="width: 100%; height: 100vh;background:white;"></div>
</div>

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
        ];
</script>
@endsection