@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between">
            <h1 class="m-0">My Sets</h1>
            <a href="{{route('set_create')}}" class="btn btn-primary ml-3 new-btn"><i class="fas fa-plus"></i> New</a>
        </div>
        <div class="mt-4"></div>
        @foreach ($sets as $set)
            <div class="set shadow-sm mb-3">
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
                                @if ($set->countDueCards() > 0)
                                    <span class="badge badge-pill badge-danger ml-2">{{$set->countDueCards()}}</span>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
        @endforeach
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