@extends('layouts.blank')

@section('title', 'StemmaStudy | Set Network')

@section('header')
<script src="{{asset('js/setNetwork.js')}}"></script>
@endsection

@section('content')


<div class="menu-btn"><i class="fas fa-bars green"></i> Menu</div>
<div class="side-menu">
    <div class="menu-button-container">
        <div class="close-menu"><i class="fas fa-angle-double-left green" style="font-size: 26px;"></i></div>
        @if ($cards->count() != 0)
            <div class="search"><i class="fas fa-search green" style="font-size: 26px;"></i></div>
        @endif
    </div>
    <hr>
    <a class="unlink side-link" href="{{route('user_sets')}}"><i class="fas fa-home green pr-4"></i> My Sets</a>
    <a class="unlink side-link" href="{{route('cards_in_set', $set->id)}}"><i class="fas fa-list-alt green pr-4"></i> View Card List</a>
    <a class="unlink side-link" href="{{route('card_create', $set->id)}}"><i class="fas fa-plus green pr-4"></i> Add New Card</a>
</div>
<div id="network" style="width: 100%; height: 100vh;background:var(--light);">
    @if ($cards->count() == 0)
        <div class="text-center" style="padding: 10px; padding-top: 70px;">
            <h2>It's pretty empty here, right now.</h2>
            <p>First, create some cards and connections. Then, use this page to see how everything comes together.</p>
            <a href="{{route('card_create', $set->id)}}" class="btn btn-primary"><i class="fas fa-plus"></i> New Card</a>
        </div>
    @endif
</div>
@if ($cards->count() != 0)
    <div id="loader" class="spinner-container">
        <div class="shadow-lg spinner-box">
            <div class="spinner-border text-primary"></div>
            <img src="{{asset('/image/icon500.png')}}" class="spinner-icon">
            <p id="loader-message" class="mt-5 text-muted">Initializing...</p>
        </div>
    </div>
    <div class="search-container">
        <div class="search-box shadow-lg">
            <div class="search-input">
                <input id="search-text"  type="text" class="form-control" placeholder="Search"/>
                <div class="close-search text-secondary">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="scroll-container">
                <div class="search-result">
                    @foreach ($cards as $card)
                        <div data-card="{{$card->id}}">{{$card->title}}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
@endsection

@section('scripts')
<script>
    set_id = '{{$set->id}}';
    has_new_cards = {{ ($cards->contains('is_new', true)) ? "true" : "false"  }};
    network_elements = [
        @foreach ($cards as $card)
        {
            data: { 
                id: 'card-{{$card->id}}', 
                label: {!! json_encode($card->title) !!}, 
                definition: {!! json_encode($card->definition) !!}, 
                card_id : '{{$card->id}}', 
            },
            position: {
                x: {{$card->position_x}},
                y: {{$card->position_y}}
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