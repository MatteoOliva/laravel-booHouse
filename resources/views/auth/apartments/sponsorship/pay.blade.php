@extends('layouts.app')

@section('head-js')
<script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.min.js"></script>
@endsection

@section('content')
<div class="main-index">
    <div class="container">

        <div class="d-md-flex justify-content-md-between my-3 drop-pay">
            <a href="{{route('user.sponsorships.index', $apartment->slug)}}" class="btn my -4" style="background-color: #fab005; color: #0A0F15" > <i class="fa-solid fa-circle-left me-2" style="color: #0A0F15"></i>Torna alle sponsorizzazioni</a>
          </div>
    

<div class=" mb-3 ">


    <div class="card drop-pay">
        <h5 class="card-header text-center text-dark" style="background-color: #fab005">Dettagli Acquisto</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-12 text-center">
                    <h5 class="card-title">Stai sponsorizzando l'alloggio: <strong class="fs-4" style="color: #fab005">{{ $apartment->title }}</strong></h5>
                </div>
            </div>
            <div class="row text-center my-3">
                <div class="col-12 col-md-6">
                    <p>La sponsorizzazione scelta è: <strong class="text-capitalize fs-4" style="color: #fab005">{{ $sponsorship->name }}</strong></p>
                </div>

                <div class="col-12 col-md-6">
                    <p>Durata: <strong class="fs-4" style="color: #fab005">{{ $sponsorship->duration }} ore</strong></p>
                </div>
            </div>

            <div class="row text-center my-3">
                <div class="col-12 col-md-6">
                    <p>Data Inizio:  <strong class="fs-4" style="color: #fab005">{{ $startDate }}</strong></p>
                </div>

                <div class="col-12 col-md-6">
                    <p>Data Fine:  <strong class="fs-4" style="color: #fab005">{{ $endDate }}</strong></p>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-12">Prezzo:  <strong class="fs-4" style="color: #fab005">{{ $sponsorship->price }} €</strong> </div>
            </div>
          
        </div>
      
    </div>

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
</div>
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