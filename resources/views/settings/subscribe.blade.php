@extends('layouts.blank')

@section('title', 'StemmaStudy | Start Subscription')

@section('header')

@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 mt-5">
                <div class="card">
                    <div class="card-header"><h4>Start Subscription</h4></div>
                    <div class="card-body">
                        <input id="card-holder-name" type="text">

                        <!-- Stripe Elements Placeholder -->
                        <div id="card-element"></div>

                        <button id="card-button" class="btn btn-primary" data-secret="{{ $intent->client_secret }}">
                            Update Payment Method
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://js.stripe.com/v3/"></script>

<script>
    const stripe = Stripe('stripe-public-key');

    const elements = stripe.elements();
    const cardElement = elements.create('card');

    cardElement.mount('#card-element');
</script>


<script>
    const cardHolderName = document.getElementById('card-holder-name');
const cardButton = document.getElementById('card-button');
const clientSecret = cardButton.dataset.secret;

cardButton.addEventListener('click', async (e) => {
    const { setupIntent, error } = await stripe.confirmCardSetup(
        clientSecret, {
            payment_method: {
                card: cardElement,
                billing_details: { name: cardHolderName.value }
            }
        }
    );

    if (error) {
        alert(error.message);
    } else {
        alert("success");
        // The card has been verified successfully...
        // TODO
    }
});
</script>
@endsection