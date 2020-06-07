@extends('layouts.app')

@section('content')
<div class="container mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="m-0 mb-2">Update Card</h1>
            <div class="mt-4"></div>
            
            <form action="{{route('card_update', [$set,$card])}}" method="POST" >
                @csrf
                @method('PUT')
                <div class="form-group position-relative">
                <label for="title">Title</label>
                <div class="position-relative">
                    <input type="text" class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}" id="title" name="title"  value="{{old('title', $card->title)}}">
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
                        <textarea class="form-control  {{$errors->has('definition') ? 'is-invalid' : ''}}" id="definition" name="definition" rows="3">{{old('definition', $card->definition)}}</textarea>
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
