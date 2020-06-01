@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between">
            <h1 class="m-0">My Sets</h1>
            <a href="#" class="btn btn-primary ml-3 new-btn"><i class="fas fa-plus"></i> New</a>
        </div>
        <div class="mt-4"></div>
        @foreach (auth()->user()->sets as $item)
            <div class="set shadow-sm mb-3">
                <span class="more-options dropdown dropleft">
                    <a class="" href="#" role="button" id="dropdownMenuLink{{$item->id}}" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                      </a>
                      <div class="dropdown-menu shadow">
                        <a class="dropdown-item" href="#">Edit</a>
                      </div>
                </span>
                <h3>{{ $item->title }}</h3>
                @if (!empty($item->description))
                    <p class="text-muted">{{$item->description}}</p>
                @endif
                
                <div class="container mb-2">
                    <div class="row">
                        <div class="col-md-4 justify-content-center mt-2">
                            <a href="{{ route('cards_in_set', $item->id) }}" class="set-btn">
                                <i class="fas fa-list-alt green"></i>
                                <span class="pl-2">List</span>
                            </a>
                        </div>
                        <div class="col-md-4 justify-content-center mt-2">
                            <a href="{{route('set_network', $item->id)}}" class="set-btn">
                                <i class="fas fa-project-diagram green"></i>
                                <span class="pl-2">Network</span>
                            </a>
                        </div>
                        <div class="col-md-4 justify-content-center mt-2">
                            <a href="#" class="set-btn">
                                <i class="fas fa-question-circle green"></i>
                                <span class="pl-2">Review</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
        @endforeach
    </div>
</div>
@endsection
