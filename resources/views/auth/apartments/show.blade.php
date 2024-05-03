@extends('layouts.app')

@section('content')

    <div class="container my-4 ">

      {{-- appartamento --}}
      <h1>{{ $apartment->title }}</h1>
      <p>{{ $apartment->description }}</p>
      <p>Indirizzo: {{ $apartment->address }}</p>
      <p>Camere: {{ $apartment->rooms }}</p>
      <p>Letti: {{ $apartment->beds }}</p>
      <p>Bagni: {{ $apartment->toilets }}</p>
      <p>Metri quadri: {{ $apartment->mq }}</p>
   
      {{-- servizi --}}
      <h5>Servizi</h5>
      @foreach ($services as $service)
      <div class="mb-3">
        {{ $service->name }}
        <img src="{{ '/' . $service->icon }}" alt="">
      </div>
      @endforeach

      {{-- switch --}}
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" @if ($apartment->visible) checked                           
        @endif>
        <label class="form-check-label" for="flexSwitchCheckChecked">Visibile</label>
      </div>

      {{-- modifica e cancella --}}
      <div>
        <a href="#" class="btn btn-primary"><i class="fa-solid fa-pen"></i></a>
        <a href="#" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
      </div>

      {{-- pulsante sponsorizzazione --}}
      <div class="my-3">
        <a href="#" class="btn btn-primary">Sponsorizza</a>
      </div>

      

      {{-- immagine --}}
      <img 
      src="@if (substr($apartment->image,0,3) == 'img') {{ '/' . $apartment->image }} 
      @else {{ asset('storage/' . $apartment->image) }}          
      @endif" 
      class="img-fluid" alt="#">

    </div>
    

@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection