@extends('layouts.app')

@section('content')

    

    <div class="container mt-4">
      <div class="d-md-flex justify-content-md-end">
        <a href="{{route('user.apartments.create')}}" class="btn btn-primary my-3" > <i class="fa-solid fa-plus"></i> Aggiungi appartamento</a>
      </div>

        <div class="row g-2">
            @foreach ($apartments as $apartment)
            <div class="col-3">
                <a class="text-decoration-none" href="{{ route('user.apartments.show', $apartment) }}">
                    <div class="card card-index h-100" style="width: 18rem;">
                        <img 
                        src="@if (substr($apartment->image,0,3) == 'img') {{  '/' . $apartment->image }} 
                             @else {{ asset('storage/' . $apartment->image) }}          
                             @endif" 
                             class="img-fluid rounded-top" alt="#">
                        <div class="card-body" style="background-color: ">
                          <h5 class="card-title">{{ $apartment->title }}</h5>
                            <div class="d-md-flex justify-content-md-end">
                           

                             <a href="{{ route('user.apartments.edit', $apartment) }}" class="btn text-white fw-semibold mx-1" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .70rem; background-color: #1278c6"><i class="fa-solid fa-pen"></i></a>                       
                             <button type="button" class="btn text-white fw-semibold mx-1" data-bs-toggle="modal" data-bs-target="#delete-post-{{$apartment->id}}-modal" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .70rem; background-color: #A33B3B">
                              <i class="fa-solid fa-trash"></i>
                            </button>

                            </div>
                             <div class="form-check form-switch fs-5">
                               <input class="form-check-input" style="background-color: #1278c6;" type="checkbox" role="switch" id="flexSwitchCheckChecked" @if ($apartment->visible) checked                           
                               @endif>
                               <label class="form-check-label fw-semibold" for="flexSwitchCheckChecked">Visibile</label>
                          </div>
                        </div>
                      </div>
                </a>
                
            </div>
            @endforeach
        </div>
    </div>
    

@endsection

@section('modal')
@foreach($apartments as $apartment)
<div class="modal fade" id="delete-post-{{$apartment->id}}-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-light">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fa-solid fa-skull"></i><i class="fa-solid fa-skull"></i><i class="fa-solid fa-skull"></i> Eliminazione appartamento! <i class="fa-solid fa-skull"></i><i class="fa-solid fa-skull"></i><i class="fa-solid fa-skull"></i></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Stai liberando l'appartamento <strong style="color:  #A33B3B"> "{{$apartment->title}}".</strong> dal suo destino! L'operazione non ha ritorno, come un contratto con il diavolo!...SEI SICURO?!?
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
@endforeach

@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection