@extends('layouts.blank')

@section('title', 'StemmaStudy | Set Network')

@section('header')
<script src="{{asset('js/setNetwork.js')}}"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.js" defer></script>
@endsection

@section('content')
<style>

    body {
        background: var(--light);
    }

    .select2-dropdown {
        z-index: 10003;
    }

    .soft-link {
        color: #6e8789;
        margin: 5px 0px;
    }

    .soft-link:hover {
        color: #192332;
        cursor: pointer;
    }

    .sync-button i {
        display: none;
    }

    .sync-button:disabled i {
        display: inline-block;
        animation: rotation 2.5s infinite linear;
    }

    @keyframes rotation {
        100% {
            transform: rotate(360deg);
        }
    }

    .plus-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        z-index: 1;
        bottom: 25px;
        right: 25px;
        width: 65px;
        height: 65px;
        text-align: center;
        font-size: 24px;
        background: var(--main);
        color: var(--light);
        cursor: pointer;
        padding: 15px;
        border-radius: 50%;
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.075);
    }

    .plus-btn:hover {
        color: white;
        border: 5px solid #259772;
    }

    @media screen and (max-width: 500px){
        .plus-btn {
            right: 15px;
            bottom: 15px;
        }
    }
</style>

<div class="menu-btn"><i class="fas fa-bars green"></i> Menu</div>
<div class="add-card plus-btn"><i class="fas fa-plus"></i></div>
<div class="side-menu">
    <div class="menu-button-container">
        <div class="close-menu"><i class="fas fa-times green" style="font-size: 26px;"></i></div>
        <div class="menu-search search"><i class="fas fa-search green" style="font-size: 26px;"></i></div>
    </div>
    <div class="unlink side-link add-card"><i class="fas fa-plus green pr-4"></i> Add New Card</div>
    <a class="unlink side-link" href="{{route('cards_in_set', $set->id)}}"><i class="fas fa-list-alt green pr-4"></i> View Card List</a>
    <hr>
    <a class="unlink side-link" href="{{route('user_sets')}}"><i class="fas fa-home green pr-4"></i> My Sets</a>
</div>
<div id="zero-message" class="text-center" style="padding: 10px; top: 70px; z-index: 2; position: absolute; pointer-events: none; width: 100%;{{ $cards->count() == 0 ? "" : "display: none;" }}">
    <div class="raised-box p-3" style="max-width: 600px; display: inline-block; pointer-events: all;">
    <h2>There's nothing here yet!</h2>
    <p>Here you can add cards, connect cards together, and organize them visually.</p>
    
    <button class="btn btn-primary add-card"><i class="fas fa-plus"></i> New Card</button>

    </div>
</div>
<div id="network" style="width: 100%; height: 100vh;">
</div>
    <div id="loader" class="spinner-container" style="{{ $cards->count() == 0 ? "display: none;" : "" }}">
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
        <div class="connection-box shadow-lg overflow-auto">
            <h2 id="connection-box-title">Add Connection</h2>
            <h5 id="card-name" class="green"></h5>
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
            <button id="newConnectionSubmit" class="btn btn-primary sync-button" type="button"><span>Create</span><i class="fas fa-sync ml-2"></i></button>
            <button class="btn btn-link connection-cancel" type="button">Cancel</button>
        </div>
    </div>
    <div class="add-card-container">
        <div class="add-card-box shadow-lg overflow-auto">
            <h2>New Card</h2>
            <form id="create-card-form">
                <div class="form-group position-relative">
                    <label for="create-card-title">Title</label>
                    <div class="position-relative">
                        <input type="text" class="form-control" id="create-card-title" name="create-card-title"  value="" autocomplete="off">
                        <div class="invalid-tooltip"></div>
                    </div>
                    <small class="form-text text-muted">What should this card be called?</small>
                </div>
                <div class="form-group">
                    <label for="create-card-definition">Definition</label>
                    <div class="position-relative"> 
                        <div id="trixContainer">
                            @trix(\App\Card::class, 'content')
                        </div>
                        <div class="invalid-tooltip"></div>
                    </div>
                    <small class="form-text text-muted">Define this card in a way you will understand later.</small>
                </div>
                <button type="button" class="btn btn-primary sync-button" id="create-card">Create<i class="fas fa-sync ml-2"></i></button>
                <div class="btn btn-link" id="cancel-card">Cancel</div>
            </form>
        </div>
    </div>
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


{{-- Duplicated from card.create. We'll need to refactor all of this when the network view is redone. (Separate things out) --}}
<script>
        
    addEventListener("trix-before-initialize", function(event) {
        Trix.config.attachments.preview.caption.size = false;
        Trix.config.attachments.preview.caption.name = false;
        Trix.config.attachments.file.caption.size = false;
        Trix.config.lang.attachFiles = "Attach Image";
    });

    $(document).ready(function(){

        var attachmentCount = 0;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });


        addEventListener("trix-file-accept", function(event) {

            var config = laravelTrixConfig(event);
        
            if(
                config.hideToolbar ||
                (config.hideTools && config.hideTools.indexOf("file-tools") != -1) ||
                (config.hideButtonIcons && config.hideButtonIcons.indexOf("attach") != -1)
            ) {
                return event.preventDefault();
            }

            //only accept images
            if(event.file && event.file.type){
                var types = ['image/jpeg', 'image/png'];
                if(types.indexOf(event.file.type) === -1){
                    alert('Images must be jpg or png file types.');
                    return event.preventDefault();
                }
            }

            if(attachmentCount >= 5){
                alert("Cards cannot have more than 5 images.");
                return event.preventDefault();
            } else {
                attachmentCount = attachmentCount + 1;
            }
        });
        
        addEventListener("trix-attachment-remove", function(event) {
            var config = laravelTrixConfig(event);
        
            var attachment = event.attachment.attachment.attributes.values.url.split("/").pop();
            
            attachmentCount = Math.max(attachmentCount - 1, 0);

            $.ajax({
                method: "DELETE",
                url : "{{route('laravel-trix.destroy',['attachment' => ':attachment'])}}".replace(':attachment',attachment),
            }).done(function(response){
                setAttachementUrlCollectorValue('attachment-' + config['id'], function(collector){
                    for( var i = 0; i < collector.length; i++){
                        if ( collector[i] === response.attachment) {
                            collector.splice(i, 1);
                        }
                    }
            
                    return collector;
                });
            });
        });
        
        addEventListener("trix-attachment-add", function(event) {
            var config = laravelTrixConfig(event);
        
            if (event.attachment.file) {
                var attachment = event.attachment;
        
                config['attachment'] = attachment;
        
                Vapor.store(attachment.file, {
                    progress: function(progress) {
                        setProgress(Math.round(progress * 100));
                    }
                }).then(function(response){
                    //post upload info to StemmaStudy.
                    $.ajax({
                        method: "POST",
                        url :'{{route('laravel-trix.store')}}',
                        data: { 
                            'key' : response.key, 
                            'field': config.field,
                            'modelClass' : config.modelClass,
                        }
                    }).done(function(response){

                        attachment.setAttributes({
                            url : response.url,
                            href: response.url
                        });

                        //set laravel-trix collector value
                        setAttachementUrlCollectorValue('attachment-' + config['id'], function(collector){

                            collector.push(response.attachment)
            
                            return collector;
                        });

                        

                    }).fail(function(response){
                        attachment.remove();
                        if(response.errors && response.errors.file && response.errors.file.length > 0){
                            alert(response.errors.file[0].replaceAll('image\/', ''));
                        }else {
                            alert("Error Processing Upload.");
                        }

                        attachmentCount = Math.max(0, attachmentCount - 1);
                    });
                });
            }

            function setProgress(progress) {
                attachment.setUploadProgress(progress);
            }
        });
        
        function setAttachementUrlCollectorValue(inputId, callback){
            var attachmentCollector = document.getElementById(inputId);
        
            attachmentCollector.value = JSON.stringify(callback(JSON.parse(attachmentCollector.value)));
        }

        function laravelTrixConfig (event) {
            return JSON.parse(event.target.getAttribute("data-config"));
        }
    
    });
    
    
    window.onload = function() {
        var laravelTrixInstanceStyles =  document.getElementsByTagName('laravel-trix-instance-style');
    
        var style = document.createElement('style');
            style.type = 'text/css';
    
        for (var tag of laravelTrixInstanceStyles) {
            style.innerHTML += tag.textContent + ' ';
        }
    
        document.getElementsByTagName('head')[0].appendChild(style);
    }

</script>
@endsection