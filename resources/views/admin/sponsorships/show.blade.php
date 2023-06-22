@extends('layouts.admin')

@section('content')

<div class="sponsorship-container">
    <h2>Choose a sponsorship package</h2>

    <form method="post" id="payment-form" action="{{ route('admin.sponsorships.update', $sponsorship->id) }}">
        @csrf
        @method('PUT')
        
        <div class="sponsorship-package package1">
            <input type="radio" id="package1" name="amount" value="2.99" required>
            <label for="package1">€2.99 for 24 hours of sponsorship</label>
        </div>
        
        <div class="sponsorship-package package2">
            <input type="radio" id="package2" name="amount" value="5.99">
            <label for="package2">€5.99 for 72 hours of sponsorship</label>
        </div>
        
        <div class="sponsorship-package package3">
            <input type="radio" id="package3" name="amount" value="9.99">
            <label for="package3">€9.99 for 144 hours of sponsorship</label>
        </div>

        <div id="dropin-container"></div>

        <input type="hidden" id="nonce" name="payment_method_nonce">

        <button id="submit-button">Sponsor this apartment</button>
    </form>
</div>

<!-- Include the Braintree JavaScript SDK -->
<script src="https://js.braintreegateway.com/web/dropin/1.22.1/js/dropin.min.js"></script>

<script>
    var form = document.querySelector('#payment-form');
    var client_token = "{{ $token }}";

    braintree.dropin.create({
        authorization: client_token,
        container: '#dropin-container',
        }, function (createErr, instance) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            instance.requestPaymentMethod(function (err, payload) {
                if (err) {
                    console.log('Error', err);
                    return;
                }

                // Add the nonce to the form and submit
                document.querySelector('#nonce').value = payload.nonce;
                form.submit();
            });
        });
    });
</script>

@endsection