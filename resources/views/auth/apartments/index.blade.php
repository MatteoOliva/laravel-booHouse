@extends('layouts.app')

@section('content')

<div class="content">
  
  <div class="main-index">
    
    <div class="container">
      <div class="d-flex justify-content-end">
        <a href="{{route('user.apartments.create')}}" class="btn my-3" style="background-color: #fab005; color: #0A0F15" > <i class="fa-solid fa-plus"></i> Aggiungi alloggio</a>
      </div>
      
      <div class="row g-2 mb-4">
        @foreach ($apartments as $apartment)
        {{-- @if ($apartment->visible) --}}
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
          <a class="text-decoration-none" href="{{ route('user.apartments.show', $apartment) }}">
            <div class="card card-index h-100 @if($apartment->has_active_sponsorship()) sponsored-border @endif" >

              <div class="container-main-img">
                <img src="{{ $apartment->get_img_absolute_path() }}" 
                class="img-fluid rounded-top" alt="#">
              </div>

              @if($apartment->has_active_sponsorship())
                <div v-if="apartment.sponsored" class="sponsored-star">
                  <i class="fa-solid fa-star fa-beat fa-lg"></i>
                </div>
              @endif

              <div class="card-body" style="background-color:">
                <h5 class="card-title" style="color: #fab005"><strong>{{ $apartment->title }}</strong></h5>
                <div class="d-flex justify-content-end">
                  
                  
                  <a href="{{ route('user.apartments.edit', $apartment) }}" class="btn text-white fw-semibold mx-1" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .70rem; background-color: #fab005; color: black"><i class="fa-solid fa-pen" style="color: black"></i></a>                       
                  <button type="button" class="btn text-white fw-semibold mx-1" data-bs-toggle="modal" data-bs-target="#delete-post-{{$apartment->id}}-modal" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .70rem; background-color: #cc1136">
                    <i class="fa-solid fa-trash" style="color: white"></i>
                  </button>
                  
                </div>

                <form action="{{ route('user.apartments.update_visible', $apartment) }}" method="POST" class="form-check form-switch fs-5" id="form-visible-{{ $apartment->id }}">
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
                  style="background-color: #cc1136;"
                  value="true"

                  >

                  <label class="form-check-label fw-semibold" for="flexSwitchCheckChecked">Visibile</label>
                  {{-- <div class="form-check form-switch fs-5"> --}}
                  {{-- <input class="form-check-input" style="background-color: #fab005;" type="checkbox" role="switch" id="flexSwitchCheckChecked" @if ($apartment->visible) checked @endif> --}}
                  {{-- </div> --}}
                </form>

              </div>
            </div>
          </a>
          
        </div>
        {{-- @endif --}}
        @endforeach
      </div>
    </div>
    
  </div>
  
</div>
                @endsection
                
                @section('modal')
                @foreach($apartments as $apartment)
                <div class="modal fade" id="delete-post-{{$apartment->id}}-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-dark text-light">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel"></i><i class="fa-solid fa-skull"></i><i class="fa-solid fa-skull"></i> Eliminazione appartamento! <i class="fa-solid fa-skull"></i><i class="fa-solid fa-skull"></i></i></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        Stai liberando l'appartamento <strong style="color:  #cc1136"> "{{$apartment->title}}" </strong> dal suo destino! L'operazione non ha ritorno, come un contratto con il diavolo!...SEI SICURO?!?
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
@endforeach

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