@extends('layouts.app')

@section('title', 'StemmaStudy | Settings')

@section('header')
<style>
    .btn-secondary:disabled {
        cursor: not-allowed;
    }

</style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h4>Settings</h4></div>
                    <div class="card-body">
                        @if(session()->has('updatedName'))
                        <div class="alert alert-success">
                            Your account name has been updated.
                        </div>
                        @endif
                        <form action="{{route('update_name')}}" method="POST" >
                            @csrf
                            <div class="form-group position-relative">
                            <label for="username">Name</label>
                            <div class="position-relative">
                                <input type="text" class="form-control {{$errors->has('username') ? 'is-invalid' : ''}}" id="username" name="username"  value="{{old('username', $user->name)}}">
                                @error('username')
                                <div class="invalid-tooltip">
                                    {{$errors->first('username')}}
                                </div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">The name for your account on StemmaStudy.</small>
                            </div>
                            <button type="submit" class="btn btn-secondary">Update</button>
                        </form>
                        <hr>
                        <h4>Manage Your Subscription</h4>
                        @if ($freeTrial)
                            <p>Your free trial expires on {{$trialEnd}}.</p>
                            <div class="">
                                <a href="{{route('subscribe')}}" class="btn btn-primary">Start My Subscription</a>
                                <p><small>$4.99 per month. Payment starts after your free trial ends.</small></p>
                            </div>
                        @elseif($subscribed)
                            <p>You have an active subscription!</p>
                            <a href="{{route('billing_portal')}}">Visit Billing Portal</a>
                        @else
                            <p>Your free trial has ended. You still have access to view your cards, but you won't be able to create new ones or take assessments until you subscribe.</p>
                            <a href="{{route('subscribe')}}" class="btn btn-primary">Start My Subscription</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection