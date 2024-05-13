@extends('layouts.app')

@section('content')



  
  <div class="container my-4 main-conteiner">
    
    {{-- pulsante sponsorizzazione --}}
    <div class="d-md-flex justify-content-md-between my-3">
      <a href="{{route('user.apartments.index')}}" class="btn my -4" style="background-color: #B1D2C6; color: #0A0F15" > <i class="fa-solid fa-circle-left me-2" style="color: #0A0F15"></i>Torna agli appartamenti</a>
      <a href="#" class="btn fw-semibold text-white" style="background-color: #a33b3b"><i class="fa-regular fa-handshake"></i> Sponsorizza</a>
    </div>
    
    {{-- immagine --}}
    <div class="text-center">
      
      <img 
      src="{{ $apartment->get_img_absolute_path() }}" 
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
        
        <a href="{{ route('user.apartments.edit' , $apartment) }}" class="btn text-white fw-semibold" style="background-color: #F87C5D"><i class="fa-solid fa-pen" style="color: #B1D2C6"></i> Modifica</a>
        <button type="button" class="btn text-white fw-semibold mx-1" data-bs-toggle="modal" data-bs-target="#delete-post-{{$apartment->id}}-modal" style="background-color: #A33B3B">
        <i class="fa-solid fa-trash" style="color: #B1D2C6"></i> Cancella
        </button>
        
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
        style="background-color: #F87C5D"
        value="true"

        >
        <label class="form-check-label fw-semibold"  for="flexSwitchCheckChecked" >Visibile</label>

      </form>

      {{-- messaggi --}}
      <div class="my-3">
        <h5>Messaggi ricevuti</h5>
        @forelse ($apartment->messages as $message)
        <div class="card my-2">
          <div class="card-body">
            <p>Mittente: {{ $message->email }}</p>
          <p>{{ $message->content }}</p>
          </div>         
        </div>      
        @empty
          <p>Ancora nessuna vittima</p>     
        @endforelse
      </div>

      {{-- visualizzazioni --}}
      <div class="my-3">
        <h5>Visualizzazioni</h5>
        {{-- @forelse ($apartment->views as $view)
            ({{ $views }})
        @empty
          <p>Ancora nessuna visita</p>     
            
        @endforelse --}}
        <p>Il tuo appartamento ha ricevuto {{ $total_views }} fantasmi</p>
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

