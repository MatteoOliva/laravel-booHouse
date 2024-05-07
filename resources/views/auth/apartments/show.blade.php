@extends('layouts.app')

@section('content')



  
  <div class="container my-4">
    
    {{-- pulsante sponsorizzazione --}}
    <div class="d-md-flex justify-content-md-between my-3">
      <a href="{{route('user.apartments.index')}}" class="btn btn-primary my -4" > <i class="fa-solid fa-circle-left me-2"></i>Torna agli appartamenti</a>
      <a href="#" class="btn fw-semibold text-white" style="background-color: #a33b3b"><i class="fa-regular fa-handshake"></i> Sponsorizza</a>
    </div>
    
    {{-- immagine --}}
    <div class="text-center">
      
      <img 
      src="@if (substr($apartment->image,0,3) == 'img') {{ '/' . $apartment->image }} 
          @else {{ asset('storage/' . $apartment->image) }}          
          @endif" 
      class="img-fluid rounded mt-2 text-center" alt="#">
    </div>
    
    
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
        <button type="button" class="btn text-white fw-semibold mx-1" data-bs-toggle="modal" data-bs-target="#delete-post-{{$apartment->id}}-modal" style="background-color: #A33B3B">
          <i class="fa-solid fa-trash"></i> Cancella
        </button>
        
      </div>
      
      {{-- switch --}}
      <div class="form-check form-switch mt-3 fs-5">
        <input class="form-check-input" style="background-color: #1278c6" type="checkbox" role="switch" id="flexSwitchCheckChecked" @if ($apartment->visible) checked                           
        @endif>
        <label class="form-check-label fw-semibold" for="flexSwitchCheckChecked">Visibile</label>
      </div>
      
    </div>
    

    
    @endsection
    
    @section('modal')
    
    <div class="modal fade" id="delete-post-{{$apartment->id}}-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-light">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fa-solid fa-skull"></i><i class="fa-solid fa-skull"></i><i class="fa-solid fa-skull"></i> Eliminazione appartamento! <i class="fa-solid fa-skull"></i><i class="fa-solid fa-skull"></i><i class="fa-solid fa-skull"></i></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Stai liberando l'appartamento <strong style="color: #A33B3B">"{{$apartment->title}}" </strong> dal suo destino! L'operazione non ha ritorno, come un contratto con il diavolo!...SEI SICURO?!?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
        
        <form action="{{route('user.apartments.destroy', $apartment)}}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" style="background-color: #a33b3b">Elimina</button>

         </form>

      </div>
    </div>
  </div>
</div>

@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

