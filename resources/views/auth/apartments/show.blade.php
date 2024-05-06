@extends('layouts.app')

@section('content')

    <div class="container my-4">

      {{-- pulsante sponsorizzazione --}}
      <div class="d-md-flex justify-content-md-end">
        <a href="#" class="btn fw-semibold text-white" style="background-color: #990000"><i class="fa-regular fa-handshake"></i> Sponsorizza</a>
      </div>

      {{-- immagine --}}
      <img 
      src="@if (substr($apartment->image,0,3) == 'img') {{ '/' . $apartment->image }} 
      @else {{ asset('storage/' . $apartment->image) }}          
      @endif" 
      class="img-fluid rounded mt-2" alt="#">


      {{-- appartamento --}}
      <h1 class="mt-4 fw-bold">{{ $apartment->title }}</h1>
      <p>{{ $apartment->description }}</p>
      <h5 class="fw-bold fs-3">Informazioni Appartamento</h5>
      <p> <strong>Indirizzo: </strong>{{ $apartment->address }}</p>
      <p><strong>Camere: </strong>{{ $apartment->rooms }}</p>
      <p><strong>Letti: </strong>{{ $apartment->beds }}</p>
      <p><strong>Bagni: </strong>{{ $apartment->toilets }}</p>
      <p><strong>Metri quadri: </strong>{{ $apartment->mq }}</p>
   
      {{-- servizi --}}
      <h5 class="fw-bold fs-3">Servizi</h5>
      @foreach ($services as $service)
      <div class="mb-3">
        <img src="{{ '/' . $service->icon }}" alt="" style="width: 30px">
        {{ $service->name }}
      </div>
      @endforeach

      
      {{-- modifica e cancella --}}
      <div class="mt-4">
        <a href="{{ route('user.apartments.edit' , $apartment) }}" class="btn text-white fw-semibold" style="background-color: #1278c6"><i class="fa-solid fa-pen"></i> Modifica</a>
        <a href="#" class="btn text-white fw-semibold" style="background-color: #A33B3B"><i class="fa-solid fa-trash"></i> Cancella</a>
      </div>
      
      {{-- switch --}}
      <div class="form-check form-switch mt-3 fs-5">
        <input class="form-check-input" style="background-color: #1278c6" type="checkbox" role="switch" id="flexSwitchCheckChecked" @if ($apartment->visible) checked                           
        @endif>
        <label class="form-check-label fw-semibold" for="flexSwitchCheckChecked">Visibile</label>
      </div>

    </div>
    

@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

