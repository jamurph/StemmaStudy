@extends('layouts.blank')

@section('title', 'StemmaStudy | Set Network')

@section('header')
@if ($cards->count() != 0)
<script src="{{asset('js/setNetwork.js')}}"></script>
@endif
@endsection

@section('content')
<style>
    
    .side-menu {
        position: absolute;
        left:0;
        top:0;
        width: 300px;
        background: white;
        height: 100vh;
        transform: translate(-100%,0);
        transition: transform .5s ease-in-out, box-shadow .5s ease-in-out;
        z-index: 10001;
        padding: 15px;
        overflow: auto;
    }

    .menu-button-container {
        height: 50px;
    }

    .close-menu {
        display: inline-block;
        float: right;
        width: 50px;
        height: 50px;
        text-align: center;
        padding-top: 11px;
        border: 1px solid rgba(0,0,0,0.1);
        border-radius: 50%;
        cursor: pointer;
    }

    .close-menu:hover {
        border: 1px solid rgba(0,0,0,0.3);
    }

    .search {
        display: inline-block;
        float: left;
        width: 50px;
        height: 50px;
        text-align: center;
        padding-top: 11px;
        border: 1px solid rgba(0,0,0,0.1);
        border-radius: 50%;
        cursor: pointer;
    }

    .search:hover {
        border: 1px solid rgba(0,0,0,0.3);
    }

    .side-link.unlink {
        display: block;
        color: #6e8789;
        margin-top: 30px;
        font-size: 25px;
    }

    .side-link:hover {
        color: #192332;
    }

</style>

<div class="menu-btn"><i class="fas fa-bars green"></i> Menu</div>
<div class="side-menu">
    <div class="menu-button-container">
        <div class="close-menu"><i class="fas fa-angle-double-left green" style="font-size: 26px;"></i></div>
        <div class="search"><i class="fas fa-search green" style="font-size: 26px;"></i></div>
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
    <style>
        .spinner-container {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            text-align: center;
            background: rgba(255,255,255,0.8);
        }

        .spinner-box {
            text-align: center;
            background: white;
            width: 250px;
            display: inline-block;
            padding: 25px;
            padding-top: 40px;
            margin-top: 25vh;
            position: relative;
        }

        .spinner-border {
            width: 100px;
            height: 100px;
        }

        .spinner-icon {
            position: absolute;
            width: 50px;
            margin: 25px;
            left: 75px;
        }

    </style>

    <div id="loader" class="spinner-container">
        <div class="shadow-lg spinner-box">
            <div class="spinner-border text-primary"></div>
            <img src="/image/icon500.png" class="spinner-icon">
            <p id="loader-message" class="mt-5 text-muted">Initializing...</p>
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
<script>
    $(function(){
        $('.menu-btn').click(function(){
            $('.side-menu').css({"transform": "translate(0,0)"});
            $('.side-menu').addClass('shadow-lg');
        });
        $('.close-menu').click(function(){
            $('.side-menu').css({"transform": "translate(-100%,0)"});
            $('.side-menu').removeClass('shadow-lg');
        });
    });
</script>
@endsection