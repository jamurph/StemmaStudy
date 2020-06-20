{{--

    This code sucks, but it works. Works > pretty. 

    I'm sorry. :(
    
--}}

@extends('layouts.app')

@section('header')
<style>
    #newBtn i {
        transition: all .3s ease-in-out;
    }

    .rotate45 {
        transform: rotate(45deg);
    }

</style>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
        
            
            <a class="text-decoration-none mb-3 d-inline-block" href="{{route('cards_in_set', $set->id)}}"><i class="fas fa-arrow-left"></i> {{$set->title}}</a>
                
        
            <div class="card-detail shadow-sm mb-4">
                <span class="more-options dropdown dropleft">
                    <a class="" href="#" role="button" id="dropdownMenuLink{{$card->id}}" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                      </a>
                      <div class="dropdown-menu shadow">
                      <a class="dropdown-item" href="{{route('card_edit', [$set, $card])}}">Edit</a>
                      <a class="dropdown-item text-danger" href="{{route('card_destroy', [$set, $card])}}" onclick="event.preventDefault();deleteModal('#destroy-{{$card->id}}')">Delete</a>
                            <form id="destroy-{{$card->id}}" method="POST" action="{{route('card_destroy', [$set, $card])}}" style="display: none">
                                @csrf
                                @method('DELETE')
                            </form>
                      </div>
                </span>
                <h1 class="m-0">{{ $card->title }}</h1>
                <hr>
                <div>
                    {!! $card->trixRender('content') !!}
                </div>
            </div>


            @if ($set->cards->count() < 2)
                <div class="text-center">
                    <h3>Add more cards to create connections!</h3>
                    <a class="btn btn-primary" href="{{route('card_create', $set)}}"><i class="fas fa-plus"></i> New Card</a>
                </div>
            @else
                <div id="connections" class="d-flex mt-5 mb-2 align-items-center justify-content-between">
                    <h3 class="m-0">Connections</h1>
                    <a data-toggle="collapse" href="#collapseNewConnection" id="newBtn" role="button" class="btn btn-secondary ml-3 new-btn"><i class="fas fa-plus"></i> New</a>
                </div>
                <div class="collapse" id="collapseNewConnection">
                    <div class="NewConnection mb-3">
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
                                    @if ($setCard->id !== $card->id)
                                        <option value="{{$setCard->id}}">{{$setCard->title}}</option>                                
                                    @endif
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
                        <button id="newSubmit" class="btn btn-primary" type="button">Create</button>
                        <button class="btn btn-link cancel" type="button">Cancel</button>
                    </div>
                </div>
                <div class="collapse" id="collapseUpdateConnection">
                    <div class="UpdateConnection mb-3">
                        <input type="hidden" name="updateConnectionId" id="updateConnectionId" value="">
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <span class="pr-2">Connect</span>
                                <input class="form-check-input disabled" type="radio" name="updateDirection" id="updateFrom" disabled value="from">
                                <label class="form-check-label" for="updateFrom">
                                    From
                                </label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input disabled" type="radio" name="updateDirection" id="updateTo" disabled checked value="to">
                                <label class="form-check-label" for="updateTo">
                                    To
                                </label>
                            </div>
                            <select id="updateSelect" style="width: 300px; max-width: 100%;"  class="disabled" disabled>
                                <option selected value=""></option>
                                @foreach ($set->cards as $setCard)
                                    @if ($setCard->id !== $card->id)
                                        <option value="{{$setCard->id}}">{{$setCard->title}}</option>                                
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group position-relative">
                            <label for="update-title">Relationship</label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="update-title" name="update-title"  value="">
                                <div class="invalid-tooltip">Please enter a longer title.</div>
                            </div>
                            <small class="form-text text-muted">How are these cards connected?</small>
                        </div>
                        <div class="form-group">
                            <label for="update-description">Description <small>(Optional)</small></label>
                            <div class="position-relative"> 
                                <textarea class="form-control" id="update-description" name="update-description" rows="3"></textarea>
                                <div class="invalid-tooltip">Descriptions must contain fewer than 500 characters.</div>
                            </div>
                            <small class="form-text text-muted">Anything you should remember about this connection?</small>
                        </div>
                        <button id="updateSubmit" class="btn btn-primary" type="button">Update</button>
                        <button class="btn btn-link cancel" type="button">Cancel</button>
                    </div>
                </div>
                @foreach ($card->connectionsIn as $in)
                <div class="card-connection shadow-sm mb-3" data-id="{{$in->id}}" data-direction="from" data-card="{{$in->fromCard->id}}" data-title="{{$in->title}}" data-description="{{$in->description}}">
                    <span class="more-options dropdown dropleft">
                        <a class="" href="#" role="button" id="dropdownMenuLinkConnection{{$in->id}}" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v text-secondary"></i>
                        </a>
                        <div class="dropdown-menu shadow">
                            <a class="dropdown-item connection-update" href="#">Edit</a>
                            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault();deleteModal('#destroy-connection-{{$in->id}}')">Delete</a>
                            <form id="destroy-connection-{{$in->id}}" method="POST" action="{{route('connection_destroy', [$set,$card, $in])}}" style="display: none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </span>
                    <a href="{{ route('user_card', [$set->id,$in->fromCard->id])}}" class="text-decoration-none d-inline-block"><h4><i class="fas fa-arrow-left"></i> {{ $in->fromCard->title }}</h4></a>
                    <h5 class="m-0"><i class="fas fa-angle-double-right"></i> <b>{{$in->title}}</b> <i class="fas fa-angle-double-right"></i></h5>
                    @if (!empty($in->description))
                    <p class="text-muted has-newlines">{{$in->description}}</p>
                    @endif
                </div>
                @endforeach
                @foreach ($card->connectionsOut as $out)
                <div class="card-connection shadow-sm mb-3" data-id="{{$out->id}}" data-direction="to" data-card="{{$out->toCard->id}}" data-title="{{$out->title}}" data-description="{{$out->description}}">
                    <span class="more-options dropdown dropleft">
                        <a class="" href="#" role="button" id="dropdownMenuLinkConnection{{$out->id}}" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v text-secondary"></i>
                        </a>
                        <div class="dropdown-menu shadow">
                            <a class="dropdown-item connection-update" href="#">Edit</a>
                            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault();deleteModal('#destroy-connection-{{$out->id}}')">Delete</a>
                            <form id="destroy-connection-{{$out->id}}" method="POST" action="{{route('connection_destroy', [$set,$card,$out])}}" style="display: none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </span>
                    <h5 class="m-0"><i class="fas fa-angle-double-right"></i> <b>{{$out->title}}</b> <i class="fas fa-angle-double-right"></i></h5>
                    @if (!empty($out->description))
                    <p class="text-muted has-newlines">{{$out->description}}</p>
                    @endif
                    <div class="text-right">
                        <a href="{{ route('user_card', [$set->id,$out->toCard->id])}}" class="text-decoration-none d-inline-block"><h4 class="mt-2 mb-0">{{ $out->toCard->title }} <i class="fas fa-arrow-right"></i></h4></a>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
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
            <p>This action cannot be undone.</p>
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

    function clearValidation(){
        $('.is-invalid').removeClass('is-invalid');
    }

    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        $(document).ready(function() {
            $('#updateSelect').select2();
            $('#newSelect').select2();
        });

        $('#newBtn').click(function(){
            clearValidation();
            $('#newBtn i').toggleClass('rotate45');
            $('#newSelect').val('').change();
            $('input[name=newDirection]').val(['to']);
            $('#new-title').val('');
            $('#new-description').val('');
        });

        $('.connection-update').click(function(){
            clearValidation();
            $('#collapseNewConnection').collapse('hide');
            $('#newBtn i').removeClass('rotate45');

            connection = $(this).closest('.card-connection');
            direction = connection.attr('data-direction');
            id = connection.attr('data-id');
            otherCardId = connection.attr('data-card');
            relTitle = connection.attr('data-title');
            relDescription = connection.attr('data-description');

            $('#updateConnectionId').val(id);
            $('#updateSelect').val(otherCardId).change();
            $('input[name=updateDirection]').val([direction]);
            $('#update-title').val(relTitle);
            $('#update-description').val(relDescription);

            $('#newBtn').addClass('disabled');
            $('#collapseUpdateConnection').collapse('show');
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#connections").offset().top
            }, 300);
        });

        $('.cancel').click(function(){
            clearValidation();
            $('#newBtn').removeClass('disabled');
            $('#collapseUpdateConnection').collapse('hide');
            $('#collapseNewConnection').collapse('hide');
            $('#newBtn i').removeClass('rotate45');
            $('#newSelect').val('').change();
            $('input[name=newDirection]').val(['to']);
            $('#new-title').val('');
            $('#new-description').val('');
        });

        $('#updateSubmit').click(function(){
            clearValidation();
            connectionId = $('#updateConnectionId').val();
            newTitle = $('#update-title').val();
            newDescription = $('#update-description').val();

            //run validation...
            valid = true;
            if(newTitle.length < 4){
                valid = false;
                $('#update-title').addClass('is-invalid');
            }

            if(newDescription.length > 500){
                valid = false;
                $('#update-description').addClass('is-invalid');
            }

            //submit
            if(valid){
                $.ajax({
                    method: "PUT",
                    url :'/my-sets/{{$set->id}}/connection/'+connectionId,
                    data: { 'title' : newTitle, 'description': newDescription },
                    complete: function(){
                        location.reload();
                    },
                });
            }
        });

        $('#newSubmit').click(function(){
            clearValidation();
            currentCardId = '{{$card->id}}';
            newOtherCard = $('#newSelect').val();
            newTitle = $('#new-title').val();
            newDescription = $('#new-description').val();

            fromCard = null;
            toCard = null;

            direction = $('input[name="newDirection"]:checked').val();
            if(direction === 'from'){
                fromCard = newOtherCard;
                toCard = currentCardId;
            } else if(direction === 'to'){
                toCard = newOtherCard;
                fromCard = currentCardId;
            }
            valid = true;
            //run client validation...
            if(newTitle.length < 4){
                valid = false;
                $('#new-title').addClass('is-invalid');
            }

            if(newDescription.length > 500){
                valid = false;
                $('#new-description').addClass('is-invalid');
            }

            //submit
            if(valid){
                $.ajax({
                    method: "POST",
                    url :'/my-sets/{{$set->id}}/connection/',
                    data: { 'title' : newTitle, 'description': newDescription, 'fromCardId' : fromCard, 'toCardId' : toCard},
                    complete: function() {
                        location.reload();
                    },
                });
            }
        });

    });
</script>
@endsection