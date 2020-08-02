@extends('layouts.app')

@section('title', 'StemmaStudy | ' . $set->title)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <a class="text-decoration-none mb-3 d-inline-block" href="{{route('user_sets')}}"><i class="fas fa-arrow-left"></i> Back to My Sets</a>
            <h1 class="m-0 mb-2">{{ $set->title }}</h1>
            @if (Auth::user()->onTrialOrSubscribed() || $set->cards->count() >= 1000)
                <div class="text-right">
                    <a href="{{route('card_create', $set)}}" class="btn btn-primary new-btn"><i class="fas fa-plus"></i> New</a>
                </div>
            @endif
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
            <div class="mt-4"></div>
            @foreach ($set->cards->sortBy('created_at') as $card)
                <div class="ss-card shadow-sm mb-3">
                    <h3 class="mb-0"><a class="unlink" href="{{ route('user_card', [$set->id, $card->id]) }}">{{ $card->title }}</a></h3>
                    {{-- Excluded for initial prototype --}}
                    {{-- @foreach ($card->tags as $tag)
                        <a href="#" class="badge badge-pill ml-2" style="background-color: {{$tag->color}}; color: white;">{{$tag->title}}</a>
                    @endforeach --}}
                    <div class="text-muted card-definition">{!! $card->definition !!}</div>
                    
                    <div class="text-right">
                    <a class="btn btn-link ss-card-btn" href="{{ route('user_card', [$set->id, $card->id]) }}">
                            <span class="pr-2">View Details</span>
                            <i class="fas fa-angle-double-right"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
