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
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="receive_notifications" id="receive_notifications" {{ request()->user()->notify ? 'checked' : '' }}>

                            <label class="form-check-label" for="receive_notifications">
                                Receive Review Notifications
                            </label>
                            <small class="form-text text-muted">You'll get an email when you have at least 5 cards to review across all sets with notifications enabled as a helpful reminder to space your study. </small>
                        </div>
                        {{--
                            Hide until we plan to use. Should still default them on the list with registration.
                            
                            <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="receive_emails" id="receive_emails" {{ $receives_emails ? 'checked' : '' }}>

                            <label class="form-check-label" for="receive_emails">
                                Receive StemmaStudy News and Study Tips
                            </label>
                            <small class="form-text text-muted">You'll receive infrequent news about StemmaStudy updates and other information we think can help improve your study.</small>
                        </div> --}}
                        <hr>
                        <form class="mt-4 mb-4" action="{{route('update_name')}}" method="POST" >
                            @if(session()->has('updatedName'))
                            <div class="alert alert-success">
                                Your account name has been updated.
                            </div>
                            @endif
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
                        <h4 class="mt-4">Manage Your Subscription</h4>
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
<script>

$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#receive_emails').change(function(){
        if(this.checked) {
            $.ajax({
                method: "POST",
                url :'{{route('email_subscribe')}}'
            }).fail(function(){
                alert('Something went wrong. Please refresh the page and try again.');
            });
        } else {
            $.ajax({
                method: "POST",
                url :'{{route('email_unsubscribe')}}'
            }).fail(function(){
                alert('Something went wrong. Please refresh the page and try again.');
            });
        }
    });

    $('#receive_notifications').change(function(){
        if(this.checked) {
            $.ajax({
                method: "POST",
                url :'{{route('notification_subscribe')}}'
            }).fail(function(){
                alert('Something went wrong. Please refresh the page and try again.');
            });
        } else {
            $.ajax({
                method: "POST",
                url :'{{route('notification_unsubscribe')}}'
            }).fail(function(){
                alert('Something went wrong. Please refresh the page and try again.');
            });
        }
    });
});


</script>
@endsection