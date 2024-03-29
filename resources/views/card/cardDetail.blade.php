{{--

    This code sucks, but it works. Works > pretty. 

    I'm sorry. :'(
    
--}}
@extends('layouts.app')
@section('title', 'StemmaStudy | ' . $card->title)

@section('header')
<style>
    #newBtn i {
        transition: all .3s ease-in-out;
    }

    .rotate45 {
        transform: rotate(45deg);
    }

</style>


<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            @if (session()->has('card_created') && session('card_created') == true)
                <div class="text-center mb-3">
                    <a class="btn btn-primary" href="{{route('card_create', $set->id)}}"><i class="fas fa-plus"></i> Add Another Card</a>
                </div>
            @endif
            <div class="row mb-3">
                <div class="col-md-8 mb-3 mb-md-0">
                @if (session()->has('source') && session('source') == 'network')
                    <a class="text-decoration-none" href="{{route('set_network', $set->id)}}"><i class="fas fa-arrow-left"></i> {{$set->title}}</a>
                @else
                    <a class="text-decoration-none" href="{{route('cards_in_set', $set->id)}}"><i class="fas fa-arrow-left"></i> {{$set->title}}</a>
                @endif
                </div>
                <div class="col-md-4 text-md-right">
                    <a class="navigation-btn" href="{{route('set_network', $set->id)}}?card={{$card->id}}"><i class="fas fa-project-diagram green"></i> View on Network</a>    
                </div>
            </div>
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
                <div class="trix-content">
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
                    <h3 class="m-0">Connections</h3>
                    @if (Auth::user()->onTrialOrSubscribed())
                        <a data-toggle="collapse" href="#collapseNewConnection" id="newBtn" role="button" class="btn btn-secondary ml-3 new-btn"><i class="fas fa-plus"></i> New</a>
                    @endif
                </div>
                @if (!Auth::user()->onTrialOrSubscribed())
                    <div class="alert alert-info">
                        Your subscription has run out. <a href="{{route('subscribe')}}">Subscribe</a> to create new connections between cards.
                    </div>
                @else
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
                @endif
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
                <div class="card-connection shadow-sm mb-3 break-word" data-id="{{$in->id}}" data-direction="from" data-card="{{$in->fromCard->id}}" data-title="{{$in->title}}" data-description="{{$in->description}}">
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
                    <h4 class="mb-0"><a href="{{ route('user_card', [$set->id,$in->fromCard->id])}}" class="text-decoration-none d-inline-block">{{ $in->fromCard->title }}</a><br class="d-md-none d-block"> <i class="fas fa-arrow-right small"></i> <b>{{$in->title}}</b> <i class="fas fa-arrow-right small"></i> <br class="d-md-none d-block">{{$card->title}}</h4>
                    @if (!empty($in->description))
                    <p class="text-muted has-newlines">{{$in->description}}</p>
                    @endif
                </div>
                @endforeach
                @foreach ($card->connectionsOut as $out)
                <div class="card-connection shadow-sm mb-3 break-word" data-id="{{$out->id}}" data-direction="to" data-card="{{$out->toCard->id}}" data-title="{{$out->title}}" data-description="{{$out->description}}">
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
                    <h4 class="mb-0">{{$card->title}}<br class="d-md-none d-block"> <i class="fas fa-arrow-right small"></i> <b>{{$out->title}}</b> <i class="fas fa-arrow-right small"></i> <br class="d-md-none d-block"> <a href="{{ route('user_card', [$set->id,$out->toCard->id])}}" class="text-decoration-none d-inline-block">{{ $out->toCard->title }}</a></h4>
                    @if (!empty($out->description))
                    <p class="text-muted has-newlines">{{$out->description}}</p>
                    @endif
                    
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
        $('#newSelect').siblings('.select2').find('.select2-selection').removeClass('error-border');
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

            var connection = $(this).closest('.card-connection');
            var direction = connection.attr('data-direction');
            var id = connection.attr('data-id');
            var otherCardId = connection.attr('data-card');
            var relTitle = connection.attr('data-title');
            var relDescription = connection.attr('data-description');

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
            var connectionId = $('#updateConnectionId').val();
            var newTitle = $('#update-title').val();
            var newDescription = $('#update-description').val();

            //run validation...
            var valid = true;
            if(newTitle.length < 1){
                valid = false;
                $('#update-title').addClass('is-invalid');
                $('#update-title').siblings('.invalid-tooltip').text('Please enter a longer title.');
            }else if (newTitle.length > 100){
                valid = false;
                $('#update-title').addClass('is-invalid');
                $('#update-title').siblings('.invalid-tooltip').text('Please enter a shorter title.');
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
            var currentCardId = '{{$card->id}}';
            var newOtherCard = $('#newSelect').val();
            var newTitle = $('#new-title').val();
            var newDescription = $('#new-description').val();

            var fromCard = null;
            var toCard = null;

            var direction = $('input[name="newDirection"]:checked').val();
            if(direction === 'from'){
                fromCard = newOtherCard;
                toCard = currentCardId;
            } else if(direction === 'to'){
                toCard = newOtherCard;
                fromCard = currentCardId;
            }
            var valid = true;

            if(newOtherCard.length < 1){
                valid = false;
                $('#newSelect').siblings('.select2').find('.select2-selection').addClass('error-border');
            }

            if(newTitle.length < 1){
                valid = false;
                $('#new-title').addClass('is-invalid');
                $('#new-title').siblings('.invalid-tooltip').text('Please enter a longer title.');
            }else if (newTitle.length > 100){
                valid = false;
                $('#new-title').addClass('is-invalid');
                $('#new-title').siblings('.invalid-tooltip').text('Please enter a shorter title.');
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