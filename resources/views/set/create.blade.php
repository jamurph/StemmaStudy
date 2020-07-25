@extends('layouts.app')

@section('title', 'StemmaStudy | New Set')

@section('content')
<div class="container mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="m-0 mb-2">New Set</h1>
            <div class="mt-4"></div>
            
            <form action="{{route('set_store')}}" method="POST" >
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
                <small class="form-text text-muted">What should this set be called?</small>
                </div>
                <div class="form-group mb-4">
                    <label for="description">Description</label>
                    <div class="position-relative"> 
                        <textarea class="form-control  {{$errors->has('description') ? 'is-invalid' : ''}}" id="description" name="description" rows="3">{{old('description')}}</textarea>
                        @error('description')
                        <div class="invalid-tooltip">
                            {{$errors->first('description')}}
                        </div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">What is this set for?</small>
                </div>
               {{-- <div class="form-group form-check mb-4">
                    <input type="checkbox" name="public" value="1" checked class="form-check-input" id="public">
                    <label class="form-check-label" for="public">Public</label>
                    <small class="form-text text-muted">Making your set public is a great way to help others learn.</small>
                </div> --}}
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{route('user_sets')}}" class="btn btn-link text-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
