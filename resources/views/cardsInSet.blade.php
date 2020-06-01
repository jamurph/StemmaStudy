@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <a class="text-decoration-none mb-3 d-block" href="{{route('user_sets')}}"><i class="fas fa-arrow-left"></i> Back to My Sets</a>
            <h1 class="m-0 mb-2">{{ $set->title }}</h1>
            <div class="text-right">
                <a href="#" class="btn btn-primary new-btn"><i class="fas fa-plus"></i> New</a>
            </div>
            <div class="mt-4"></div>
            @foreach ($set->cards as $card)
                <div class="ss-card shadow-sm mb-3">
                    <h3 class="mb-0">{{ $card->title }}</h3>
                    @foreach ($card->tags as $tag)
                        <a href="#" class="badge badge-pill ml-2" style="background-color: {{$tag->color}}; color: white;">{{$tag->title}}</a>
                    @endforeach
                    @if (!empty($card->definition))
                        <p class="text-muted">{{$card->definition}}</p>
                    @endif
                    <div class="text-right">
                    <a class="btn btn-link ss-card-btn" href="{{ route('user_card', $card->id) }}">
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
