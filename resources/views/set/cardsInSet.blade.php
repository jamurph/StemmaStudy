@extends('layouts.app')

@section('title', 'StemmaStudy | ' . $set->title)

@section('header')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.css">
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <a class="text-decoration-none mb-3 d-inline-block" href="{{route('user_sets')}}"><i class="fas fa-arrow-left"></i> Back to My Sets</a>
            <h1 class="m-0 mb-2 break-word">{{ $set->title }}</h1>
            @if (!Auth::user()->onTrialOrSubscribed())
                <div class="alert alert-info">
                    Your subscription has run out. <a href="{{route('subscribe')}}">Subscribe</a> to create new cards.
                </div>
            @endif
            @if ($set->cards->count() >= 1000)
                <div class="alert alert-info">
                    This set has reached the limit of 1000 cards.
                </div>
            @endif
            @if ($set->cards->count() > 0)
                <div class="row">
                    <div class="col-6">
                        <div class="text-left">
                            <a class="navigation-btn" href="{{route('set_network', $set->id)}}"><i class="fas fa-project-diagram green"></i> Network</a>
                        </div>
                    </div>
                    @if (Auth::user()->onTrialOrSubscribed() && $set->cards->count() < 1000)
                    <div class="col-6">
                        <div class="text-right">
                            <a href="{{route('card_create', $set)}}" class="btn btn-primary new-btn"><i class="fas fa-plus"></i> New Card</a>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="mt-4"></div>
                @foreach ($set->cards->sortBy('created_at') as $card)
                    <div class="ss-card d-sm-flex shadow-sm mb-3">
                        <h3 class="mb-0 mt-0 mr-1 flex-grow-1"><a class="unlink" href="{{ route('user_card', [$set->id, $card->id]) }}">{{ $card->title }}</a></h3>

                        {{-- <div class="text-muted card-definition trix-content">{!! $card->definition !!}</div> --}}
                        
                        <div class="text-right">
                            <a class="ss-card-btn" href="{{ route('user_card', [$set->id, $card->id]) }}">
                                <span class="pr-2">View Details</span>
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
            <div class="raised-box p-3">
                <p>This page will show a <em>list</em> of the cards in this set. Click the button below to start adding cards. </p>
                <p>Once you have added at least one card, try visiting the network view to add more cards, connect them together, or organize them visually.</p>
                <div class="text-center">
                    <a href="{{route('card_create', $set)}}" class="btn btn-primary"><i class="fas fa-plus"></i> New Card</a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
