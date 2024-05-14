@extends('layouts.app')

@section('head-js')
<script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.min.js"></script>
@endsection

@section('content')

<div class="container">

    <div id="dropin-container"></div>
    <button id="submit-button">Request payment method</button>
</div>



@endsection

@section('js')
    <script>
    var button = document.querySelector('#submit-button');

braintree.dropin.create({
  authorization: '{{$clientToken}}',
  container: '#dropin-container'
}, function (createErr, instance) {
  button.addEventListener('click', function () {
    instance.requestPaymentMethod(function (requestPaymentMethodErr, payload) {
      // Submit payload.nonce to your server
    });
  });
});
    </script>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection