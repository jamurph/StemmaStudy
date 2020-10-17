@extends('layouts.blank')

@section('title', 'StemmaStudy | Set Network')

@section('header')
<script src="{{asset('js/setNetwork.js')}}"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endsection

@section('content')
<style>

    .select2-dropdown {
        z-index: 10003;
    }
</style>

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
            <div class="raised-box p-3" style="max-width: 600px; display: inline-block;">
            <h2>It's pretty empty here, right now.</h2>
            <p>First, create some cards. Then, use this page to create connections and organize your cards to see how everything comes together.</p>
            <a href="{{route('card_create', $set->id)}}" class="btn btn-primary"><i class="fas fa-plus"></i> New Card</a>
            </div>
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
    <div class="connection-container">
        <div class="connection-box shadow-lg">
            <h2 id="connection-box-title">Add Connection</h2>
            <h5 id="card-name" class="green">Edward Thorndike</h5>
            <input id="mode" type="hidden" value="" />
            <input id="newConnectionCard" type="hidden" value="" />
            <input id="editConnectionId" type="hidden" value="" />
            <div class="form-group">
                    <div class="form-check form-check-inline">
                        <span class="pr-2">Connect</span>
                        <input class="form-check-input" type="radio" name="newDirection" id="newFrom" value="from">
                        <label class="form-check-label" for="newFrom">
                            From
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="newDirection" id="newTo" checked value="to">
                    <label class="form-check-label" for="newTo">
                        To
                    </label>
                </div>
                <select id="newSelect" style="width: 300px; max-width: 100%;">
                    <option selected value=""></option>
                    @foreach ($set->cards as $setCard)
                        <option value="{{$setCard->id}}">{{$setCard->title}}</option>
                    @endforeach
                </select>
                <small class="form-text text-muted">What are you connecting to this card?</small>
            </div>
            <div class="form-group position-relative">
                <label for="new-title">Relationship</label>
                <div class="position-relative">
                    <input type="text" class="form-control" id="new-title" name="new-title"  value="">
                    <div class="invalid-tooltip">Please enter a longer title.</div>
                </div>
                <small class="form-text text-muted">What is a good name for this connection?</small>
            </div>
            <div class="form-group">
                <label for="new-description">Description <small>(Optional)</small></label>
                <div class="position-relative"> 
                    <textarea class="form-control" id="new-description" name="new-description" rows="3"></textarea>
                    <div class="invalid-tooltip">Descriptions must contain fewer than 500 characters.</div>
                </div>
                <small class="form-text text-muted">Anything you should remember about this connection?</small>
            </div>
            <button id="newConnectionSubmit" class="btn btn-primary" type="button">Create</button>
            <button class="btn btn-link connection-cancel" type="button">Cancel</button>
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
                connection_id: '{{$connection->id}}',
            }
        },
        @endforeach
    ];

</script>
@endsection