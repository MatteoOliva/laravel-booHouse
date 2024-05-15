@extends('layouts.app')

@section('content')

    <div class="main-sponsor d-flex align-items-center">

        
        <main class="container">
            <a href="{{ route('user.apartments.show', $apartment) }}" class="btn my-4" style="background-color: #B1D2C6; color: #0A0F15" > <i class="fa-solid fa-circle-left me-2" style="color: #0A0F15"></i>Torna all'appartamento</a>
            <div class="semi-trasp-spons">
                <div class="display-5 fw-bold text-center pb-5">Scegli una sponsorizzazione per il tuo alloggio:
                    <br> <span style="color: greenyellow ">{{ $apartment->title }}</span></div>
                <div class="row text-center">
                    @foreach ($sponsorships as $sponsorship)
                    <div class="col-4">
                        <div class="card mb-4 rounded-3 shadow-sm h-100 card-sponsor">
                            <div class="card-header py-3">
                                <h4 class="my-0 fw-normal text-capitalize"><i class="fa-solid fa-skull"></i> {{ $sponsorship->name }} <i class="fa-solid fa-skull"></i></h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title pricing-card-title"><strong style="color:greenyellow">{{ $sponsorship->price }}</strong><small class="text-body-secondary fw-light" style="color:greenyellow !important"> €</small></h1>
                                <div class="mt-3 mb-4 text-center">
                                    <div class="text-center fs-3">Sponsorizza per <strong style="color:brown" class="fs-1">{{ $sponsorship->duration }}</strong> ore</div>
                                </div>
                                <button type="button" class="w-100 btn btn-lg btn-outline-primary">Sponsorizza!!</button>
                                <a href="{{ route('user.sponsorship.payment', $apartment->id) }}" type="button" class="w-100 btn btn-lg btn-outline-primary">Sponsorizza!!</a>
                                <a href="{{ route('user.sponsorship.select', ['apartment_id' => $apartment->id, 'sponsorship_id' => $sponsorship->id]) }}" type="button" class="w-100 btn btn-lg btn-outline-primary">Sponsorizza!!</a>

                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </main>

</div>

@endsection


@section('js')
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
@endsection



@section('js')
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection