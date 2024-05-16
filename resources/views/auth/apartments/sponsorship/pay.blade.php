@extends('layouts.app')

@section('head-js')
<script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.min.js"></script>
@endsection

@section('content')

<div class="container">

    <form id="payment-form" action="{{ route('user.sponsorship.checkout') }}" method="post">
        @csrf
        <!-- Putting the empty container you plan to pass to
          'braintree.dropin.create' inside a form will make layout and flow
          easier to manage -->
        <div id="dropin-container" class="drop-pay"></div>
        <div class="d-flex justify-content-center">
        <input type="submit" value="Effettua Pagamento" class="btn btn-success"/>
        </div>
        <input type="hidden" id="nonce" name="payment_method_nonce" />
      </form>

</div>



@endsection

@section('js')
<script>
    var form = document.getElementById('payment-form');
    var nonceInput = document.getElementById('nonce');  

    braintree.dropin.create({
        authorization: '{{ $clientToken }}',  
        container: '#dropin-container'
    }, function (createErr, instance) {
        if (createErr) {
            console.error(createErr);
            return;  
        }

        form.addEventListener('submit', function (event) {
            event.preventDefault();  

            instance.requestPaymentMethod(function (err, payload) {
                if (err) {
                    console.error(err);
                    return;  
                }

                if (payload && payload.nonce) {
                    nonceInput.value = payload.nonce;  
                    form.submit();  
                } else {
                    console.error("Payment method nonce is missing.");
                }
            });
        });
    });
</script>
@endsection


@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection