@extends('layouts.app')

@section('content')



  
  <div class="container my-4 main-conteiner">
    
    {{-- pulsante sponsorizzazione --}}
    <div class="d-flex justify-content-between my-3">
      <a href="{{route('user.apartments.index')}}" class="btn my -4" style="background-color: #fab005; color: #0A0F15" > <i class="fa-solid fa-circle-left me-2" style="color: #0A0F15"></i>Torna agli appartamenti</a>
      <a href="{{route('user.sponsorships.index', $apartment->slug)}}" class="btn fw-semibold text-white" style="background-color: #cc1136"><i class="fa-regular fa-handshake"></i> Sponsorizza</a>
    </div>
    
    {{-- immagine --}}
    <div class="container-img image-apartment">  
      <img 
      src="{{ $apartment->get_img_absolute_path() }}" 
      class="img-fluid rounded mt-2 text-center" alt="#" style="height: 600px">
    </div>
    
    
    {{-- appartamento --}}
    <h1 class="mt-4 fw-bold">{{ $apartment->title }}</h1>
    <p>{{ $apartment->description }}</p>
    <h5 class="fw-bold fs-3">Informazioni Appartamento</h5>
    <p> <strong>Indirizzo: </strong>{{ $apartment->address }}</p>
    <div class="row">
      <div class="col-12 col-md-2 col-lg-1">
        <p><strong>Camere: </strong>{{ $apartment->rooms }}</p>
      </div>
      <div class="col-12 col-md-2 col-lg-1">
        <p><strong>Letti: </strong>{{ $apartment->beds }}</p>
      </div>
      <div class="col-12 col-md-2 col-lg-1">
        <p><strong>Bagni: </strong>{{ $apartment->toilets }}</p>
      </div>
      <div class="col-12 col-md-2 col-lg-1">
        <p><strong>Metri quadri: </strong>{{ $apartment->mq }}</p>
      </div>
    </div>
   
    {{-- servizi --}}
    <h5 class="fw-bold fs-4">Servizi</h5>
    <div class="row">
    @forelse ($services as $service)
    <div class="mb-3 col-6 col-md-4 col-lg-2">
        <img src="{{ '/' . $service->icon }}" alt="" style="width: 30px">
        {{ $service->name }}
      </div>
      @empty
      <p>Nessun servizio disponibile</p>     
      @endforelse
    </div>
      
      
      {{-- modifica e cancella --}}
      <div class="mt-4">
        
        <a href="{{ route('user.apartments.edit' , $apartment) }}" class="btn text-white fw-semibold" style="background-color: #fab005; color: black !important" ><i class="fa-solid fa-pen" style="color: black"></i> Modifica</a>
        <button type="button" class="btn text-white fw-semibold mx-1" data-bs-toggle="modal" data-bs-target="#delete-post-{{$apartment->id}}-modal" style="background-color: #cc1136">
        <i class="fa-solid fa-trash" style="color: white"></i> Cancella
        </button>

        {{-- messaggi --}}
        <a  class="btn btn-primary position-relative" href="{{route('user.messages.index', $apartment->slug)}}">
          Messaggi
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ $messages }}
            <span class="visually-hidden">unread messages</span>
          </span>
        </a>
        
      </div>


      
      
      {{-- switch --}}
      <form action="{{ route('user.apartments.update_visible', $apartment) }}" method="POST" class="form-check form-switch fs-5 mt-3" id="form-visible-{{ $apartment->id }}">
        @csrf
        @method('PATCH')

        <input
        @checked($apartment->visible) 
        data-apartment-id= "{{ $apartment->id }}" 
        id="flexSwitchCheckChecked-{{ $apartment->id }}"
        name="visible" 
        class="form-check-input" 
        type="checkbox" 
        role="switch"
        style="background-color: #cc1136"
        value="true"

        >
        <label class="form-check-label fw-semibold"  for="flexSwitchCheckChecked" >Visibile</label>

      </form>

      



     

      {{-- visualizzazioni --}}
      <div class="my-3">
        <h5 class="fw-bold fs-3 mb-3">Visualizzazioni</h5>
        {{-- @forelse ($apartment->views as $view)
            ({{ $views }})
        @empty
          <p>Ancora nessuna visita</p>     
            
        @endforelse --}}
        <p>Il tuo appartamento ha ricevuto <strong style="color: #cc1136" class="fs-3">{{ $total_views }}</strong> fantasmi <i class="fa-solid fa-ghost fa-fade fs-5"></i></p>
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
        Stai liberando l'appartamento <strong style="color: #cc1136">"{{$apartment->title}}" </strong> dal suo destino! L'operazione non ha ritorno, come un contratto con il diavolo!...SEI SICURO?!?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
        
        <form action="{{route('user.apartments.destroy', $apartment)}}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" style="background-color: #cc1136">Elimina</button>

         </form>

      </div>
    </div>
  </div>
</div>

@endsection

@section('js')
  <script>
    const checkboxes = document.querySelectorAll('input[name="visible"]');
    checkboxes.forEach(checkbox => {
      checkbox.addEventListener('change', () => {
        const formId = 'form-visible-' + checkbox.getAttribute('data-apartment-id');
        const formEl = document.getElementById(formId);
        formEl.submit();
      })
    });
  </script>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

