@extends('layouts.app')

@section('title', 'StemmaStudy | New Card')

@section('header')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.js" defer></script>
@endsection

@section('content')
<div class="container mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="m-0 mb-2">New Card</h1>
            <div class="mt-4"></div>
            
            <form id="createForm" action="{{route('card_store', $set)}}" method="POST" >
                @csrf
                <div class="form-group position-relative">
                <label for="title">Title</label>
                <div class="position-relative">
                    <input type="text" class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}" id="title" name="title"  value="{{old('title')}}" autocomplete="off">
                    @error('title')
                    <div class="invalid-tooltip">
                        {{$errors->first('title')}}
                    </div>
                    @enderror
                </div>
                <small class="form-text text-muted">What should this card be called?</small>
                </div>
                <div class="form-group">
                    <label for="definition">Definition</label>
                    <div class="position-relative"> 
                        <div id="trixContainer" class=" {{$errors->has('definition') ? 'is-invalid' : ''}}">
                            @trix(\App\Card::class, 'content')
                        </div>
                        @error('definition')
                        <div class="invalid-tooltip">
                            {{$errors->first('definition')}}
                        </div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">Define this card in a way you will understand later.</small>
                </div>
                <div class="form-group">
                    
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
                @if (session()->has('source') && session('source') == 'network')
                <a href="{{route('set_network', $set)}}" class="btn btn-link text-secondary">Cancel</a>
                @else
                <a href="{{route('cards_in_set', $set)}}" class="btn btn-link text-secondary">Cancel</a>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>

        function clearErrors(){
            $('.invalid-tooltip').remove();
            $('.is-invalid').removeClass('is-invalid');
        }

        function errorMessage(ele, message){
            var parent = ele.parent();
            ele.addClass('is-invalid');
            parent.append('<div class="invalid-tooltip">' + message + '</div>');
        }

        $(document).ready(function(){
            $('#createForm').submit(function(e){
                clearErrors();
                var valid = true;
                var titleEle = $('#title');
                var contentContainer = $('#trixContainer');
                var title = titleEle.val();
                var content = $('trix-editor').val();


                if(!title || 0 === title.length || !title.trim()){
                    valid = false;
                    errorMessage(titleEle, "Please provide a title.");
                } else if( title.length < 3 ){
                    valid = false;
                    errorMessage(titleEle, "Please provide a longer title.");
                } else if ( title.length > 100 ){
                    valid = false;
                    errorMessage(titleEle, "Titles must be 100 characters or less.");
                }

                if(!content || 0 === content.length || !content.trim()){
                    valid = false;
                    errorMessage(contentContainer, "Please provide a definition.");
                } else if ( content.length > 20000 ){
                    valid = false;
                    errorMessage(contentContainer, "Definition too long.");
                }

                return valid;
            });
        });

    </script>

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