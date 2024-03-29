@extends('layouts.app')

@section('title', 'StemmaStudy | Edit Set')

@section('content')
<div class="container mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="m-0 mb-2">Edit Set</h1>
            <div class="mt-4"></div>
            
        <form action="{{route('set_update', $set->id)}}" method="POST" >
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">Title</label>
                    <div class="position-relative">
                        <input type="text" class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}" id="title" name="title" value="{{ old('title', $set->title) }}" autocomplete="off">
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
                        <textarea class="form-control {{$errors->has('description') ? 'is-invalid' : ''}}" id="description" name="description" rows="3">{{ old('description', $set->description) }}</textarea>
                        @error('description')
                        <div class="invalid-tooltip">
                            {{$errors->first('description')}}
                        </div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">What is this set for?</small>
                </div>
                <div class="form-group form-check mb-4">
                    <input type="checkbox" name="notify" value="1" {{ old('notify', $set->notify) == '1' ? 'checked' : '' }} class="form-check-input" id="notify">
                    <label class="form-check-label" for="notify">Receive Study Reminders for this Set</label>
                    <small class="form-text text-muted">When you have at least 5 cards due for review across all sets with this enabled, we'll send you a reminder.</small>
                </div>
                {{-- <div class="form-group form-check mb-4">
                    <input type="checkbox" name="public" value="1" {{ old('public', $set->public) == '1' ? 'checked' : '' }} class="form-check-input" id="public">
                    <label class="form-check-label" for="public">Public</label>
                    <small class="form-text text-muted">Making your set public is a great way to help others learn.</small>
                </div>
                --}}
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{route('user_sets')}}" class="btn btn-link text-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
