@extends('layouts.app')

@section('title', 'StemmaStudy | New Card')

@section('header')
    @trixassets
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
                    <input type="text" class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}" id="title" name="title"  value="{{old('title')}}">
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
                <a href="{{route('cards_in_set', $set)}}" class="btn btn-link text-secondary">Cancel</a>
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
            $('#createForm').submit(function(e){
                clearErrors();
                valid = true;
                titleEle = $('#title');
                contentContainer = $('#trixContainer');
                title = titleEle.val();
                content = $('trix-editor').val();


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
@endsection