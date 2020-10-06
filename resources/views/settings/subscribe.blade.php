@extends('layouts.blank')

@section('title', 'StemmaStudy | Start Subscription')

@section('header')
<style>
    .StripeElement {
        box-sizing: border-box;

        height: 40px;
        padding: 10px 12px;

        width: 100%;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .StripeElement--focus {
        color: #495057;
        background-color: #fff;
        border-color: #73debc;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(40, 170, 128, 0.25);
    }

    .StripeElement--invalid {
        border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }

    @media screen and (max-width: 400px){
        .card-body {
            padding: 0.5rem;
        }
    }

</style>
@endsection

@section('content')
    <div class="container mb-3">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 mt-5">
                <div class="text-center mb-5">
                    <img style="width: 240px;" src="{{asset('/image/logo.svg')}}" />
                </div>
                <div class="card shadow" style="border-top-width: 5px;">
                    <div class="card-header pb-0"><h4 class="text-center">Start Subscription</h4></div>
                    <div class="card-body pt-0">
                        <form id="subscription-form" method="POST" action="{{route('subscribe')}}">
                            @csrf
                            <p class="text-center text-muted"><em>Only $4.99 per month. Cancel anytime.</em></p>
                            <p>Please enter your payment details below.</p>
                            <div class="form-group position-relative">
                                <input id="card-holder-name" placeholder="Name on Card" name="card-holder-name" type="text" class="form-control" required>
                            </div>
                            <div class="form-group position-relative">
                                <!-- Stripe Elements Placeholder -->
                                <div id="card-element"></div>
                            </div>
                            <div id="errorMessage" class="alert alert-danger" style="display: none;">
                                Error
                            </div>
                        </form>
                        <button id="card-button" class="btn btn-primary w-100" data-secret="{{ $intent->client_secret }}">
                            Update Payment Method
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center"><a target="_blank" href="https://stripe.com/"><img src="{{asset('/image/settings/powered_by_stripe.png')}}" /></a></div>
    {{-- <div class="text-center"><a href="{{route('user_sets')}}"><i class="fas fa-arrow-left"></i> Back to StemmaStudy</a></div> --}}
@endsection

@section('scripts')
<script src="https://js.stripe.com/v3/"></script>

<script>
    const stripe = Stripe('{{env('STRIPE_KEY')}}');

    const elements = stripe.elements();
    const cardElement = elements.create('card');

    cardElement.mount('#card-element');
</script>


<script>
    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;

    cardButton.addEventListener('click', async (e) => {
        $('#card-button').prop('disabled', true);
        hideError();
        if(cardHolderName.value != ""){
            const { setupIntent, error } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: { name: cardHolderName.value }
                    }
                }
            );

            if (error) {
                showError(error.message);
                $('#card-button').prop('disabled', false);
            } else {
                var form = $('#subscription-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'payment_method');
                hiddenInput.setAttribute('value', setupIntent.payment_method);
                form.append(hiddenInput);
                form.submit();
            }
        } else {
            showError('Name on Card is required.');
            $('#card-button').prop('disabled', false);
        }
        
    });

    function showError(message){
        $('#errorMessage').text(message);
        $('#errorMessage').show();
    }

    function hideError(){
        $('#errorMessage').hide();
    }
</script>
@endsection