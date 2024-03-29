@extends('layouts.app')

@section('title', 'StemmaStudy | My Sets')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
        @if ($sets->count() > 0)
            <div class="d-flex align-items-center justify-content-between">
                <h1 class="m-0">My Sets</h1>
                @if (Auth::user()->onTrialOrSubscribed())
                    <a href="{{route('set_create')}}" class="btn btn-primary ml-3 new-btn"><i class="fas fa-plus"></i> New Set</a>
                @endif
            </div>
            @if (!Auth::user()->onTrialOrSubscribed())
                <div class="alert alert-info">
                    Your subscription has run out. <a href="{{route('subscribe')}}">Subscribe</a> to create new sets.
                </div>
            @endif
            <div class="mt-4"></div>
            @foreach ($sets as $set)
                <div class="set shadow-sm mb-3 break-word">
                    <span class="more-options dropdown dropleft">
                        <a class="" href="#" role="button" id="dropdownMenuLink{{$set->id}}" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu shadow">
                        <a class="dropdown-item" href="{{route('set_edit', $set)}}">Edit</a>
                        <a class="dropdown-item text-danger" href="{{route('set_destroy', $set)}}" onclick="event.preventDefault();deleteModal('#destroy-{{$set->id}}')">Delete</a>
                                <form id="destroy-{{$set->id}}" method="POST" action="{{route('set_destroy', $set)}}" style="display: none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                        </div>
                    </span>
                    <h3>{{ $set->title }}</h3>
                    @if (!empty($set->description))
                        <p class="text-muted has-newlines">{{$set->description}}</p>
                    @endif
                    
                    <div class="container mb-2 p-0">
                        <div class="row">
                            <div class="col-md-4 justify-content-center mt-2">
                                <a href="{{ route('cards_in_set', $set->id) }}" class="set-btn">
                                    <i class="fas fa-list-alt green"></i>
                                    <span class="pl-2">List</span>
                                </a>
                            </div>
                            <div class="col-md-4 justify-content-center mt-2">
                                <a href="{{route('set_network', $set->id)}}" class="set-btn">
                                    <i class="fas fa-project-diagram green"></i>
                                    <span class="pl-2">Network</span>
                                </a>
                            </div>
                            <div class="col-md-4 justify-content-center mt-2">
                                <a href="{{route('set_review', $set->id)}}" class="set-btn">
                                    <i class="fas fa-question-circle green"></i>
                                    <span class="pl-2">Review</span>
                                    @if ($set->countDueCards() > 0 && $set->notify == true)
                                        <span class="badge badge-pill badge-danger ml-2">{{$set->countDueCards()}}</span>
                                    @elseif ($set->notify == false)
                                        <span class="badge badge-pill badge-light ml-2 dropleft"><i class="fas fa-bell-slash" title="Review notifications snoozed. Edit set to enable."></i></span>
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
            @endforeach
        @else
            @if (!Auth::user()->onTrialOrSubscribed())
            <div class="alert alert-info">
                Your subscription has run out. <a href="{{route('subscribe')}}">Subscribe</a> to create new sets.
            </div>
            @else
            <div class="raised-box p-4">
                <h2 class="break-word mt-3"><i class="green fas fa-graduation-cap mr-2"></i>Welcome to StemmaStudy!</h2>
                <p class="mt-3">There is no such thing as effortless learning. Effective learning is hard &ndash; and it's often made harder when we use ineffective strategies. 
                    StemmaStudy is designed to integrate several different strategies that each contribute to more effective learning. 
                    Before you start using StemmaStudy, it would be helpful to take just a couple of minutes to get to know some of the forces behind how StemmaStudy works:</p>
                <p class="mt-4">
                    <ul>
                        <li><a target="_blank" href="{{route('learn')}}">How to Learn More</a> &mdash; Get some practical study tips and learn about some of the most impactful principles of good learning.</li>
                        <li><a target="_blank" href="{{route('tutorial')}}">StemmaStudy Tutorial</a> &mdash; Get a short overview of what StemmaStudy is and how it works.</li>
                    </ul>
                </p>
                <p class="mt-4 text-center"><b>Ready to begin?</b></p>
                <div class="text-center mb-3">
                    <a href="{{route('set_create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> New Set</a>
                </div>
            </div>
            @endif
        @endif
    </div>
</div>

<div class="modal fade" id="reallyDelete" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Really Delete?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Do you really want to delete this set and all of its contents? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button id="deleteButton" type="button" class="btn btn-danger">Delete</button>
        </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function deleteModal(str){
        $('#deleteButton').off('click');
        $('#deleteButton').click(function(){
            $(str).submit();
        });
        $('.modal').modal();
    }
</script>
@endsection