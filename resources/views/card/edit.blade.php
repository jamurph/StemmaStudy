@extends('layouts.app')

@section('title', 'StemmaStudy | Edit Card')

@section('header')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.js" defer></script>
@endsection

@section('content')
<div class="container mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="m-0 mb-2">Update Card</h1>
            <div class="mt-4"></div>
            
            <form id="updateForm" action="{{route('card_update', [$set,$card])}}" method="POST" >
                @csrf
                @method('PUT')
                <div class="form-group position-relative">
                <label for="title">Title</label>
                <div class="position-relative">
                    <input type="text" class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}" id="title" name="title"  value="{{old('title', $card->title)}}" autocomplete="off">
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
                            @trix($card, 'content')
                        </div>
                        @error('definition')
                        <div class="invalid-tooltip">
                            {{$errors->first('definition')}}
                        </div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">Define this card in a way you will understand later.</small>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{route('user_card', [$set, $card])}}" class="btn btn-link text-secondary">Cancel</a>
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
        parent = ele.parent();
        ele.addClass('is-invalid');
        parent.append('<div class="invalid-tooltip">' + message + '</div>');
    }

    $(document).ready(function(){
        $('#updateForm').submit(function(e){
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

    addEventListener("trix-file-accept", function(event) {
        var config = laravelTrixConfig(event);
    
        if(
            config.hideToolbar ||
            (config.hideTools && config.hideTools.indexOf("file-tools") != -1) ||
            (config.hideButtonIcons && config.hideButtonIcons.indexOf("attach") != -1)
        ) {
            return event.preventDefault();
        }
    });
    
    addEventListener("trix-attachment-remove", function(event) {
        var config = laravelTrixConfig(event);
    
        var xhr = new XMLHttpRequest();
    
        var attachment = event.attachment.attachment.attributes.values.url.split("/").pop();
    
        xhr.open("DELETE", "{{route('laravel-trix.destroy',['attachment' => ':attachment'])}}".replace(':attachment',attachment), true);
    
        setAttachementUrlCollectorValue('attachment-' + config['id'], function(collector){
            for( var i = 0; i < collector.length; i++){
                if ( collector[i] === attachment) {
                    collector.splice(i, 1);
                }
            }
    
            return collector;
        });
    
        xhr.send();
    });
    
    addEventListener("trix-attachment-add", function(event) {
        var config = laravelTrixConfig(event);
    
        if (event.attachment.file) {
            var attachment = event.attachment;
    
            config['attachment'] = attachment;
    
             uploadFile(config, setProgress, setAttributes, errorCallback);
    
            function setProgress(progress) {
                attachment.setUploadProgress(progress);
            }
    
            function setAttributes(attributes) {
                attachment.setAttributes(attributes);
            }
    
            function errorCallback(xhr,attachment){
                attachment.remove();
                var response = JSON.parse(xhr.response);
                if(response.errors && response.errors.file && response.errors.file.length > 0){
                    alert(response.errors.file[0].replaceAll('image\/', '').replace('+xml',''));
                }else {
                    alert("Error Processing Upload.");
                }
            }
        }
    });
    
    
    function uploadFile(data, progressCallback, successCallback, errorCallback) {
        var formData = createFormData(data);
        var xhr = new XMLHttpRequest();
    
        xhr.open("POST", "{{route('laravel-trix.store')}}", true);
    
        xhr.upload.addEventListener("progress", function(event) {
            var progress = (event.loaded / event.total) * 100;
            progressCallback(progress);
        });
    
        xhr.addEventListener("load", function(event) {
            if (xhr.status >= 200 && xhr.status < 300) {
                var response = JSON.parse(xhr.response);
    
                setAttachementUrlCollectorValue('attachment-' + data['id'], function(collector){
                    collector.push(response.url.split("/").pop())
    
                    return collector;
                });
    
                successCallback({
                    url : response.url,
                    href: response.url
                })
            } else {
                errorCallback(xhr,data.attachment)
            }
        });
    
        xhr.send(formData);
    }
    
    function setAttachementUrlCollectorValue(inputId, callback){
        var attachmentCollector = document.getElementById(inputId);
    
        attachmentCollector.value = JSON.stringify(callback(JSON.parse(attachmentCollector.value)));
    }
    
    function createFormData(data) {
        var formData = new FormData();
        formData.append("Content-Type", data.attachment.file.type);
        formData.append("file", data.attachment.file);
        formData.append("field", data.field);
        formData.append("modelClass", data.modelClass);
    
        if(data.disk != undefined) {
            formData.append("disk", data.disk);
        }
    
        return formData;
    }
    
    function laravelTrixConfig (event) {
        return JSON.parse(event.target.getAttribute("data-config"));
    }
    
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