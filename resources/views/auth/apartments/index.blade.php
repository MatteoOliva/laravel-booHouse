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
                    <div class="card" style="width: 18rem;">
                        <img 
                        src="@if (substr($apartment->image,0,3) == 'img') {{  '/' . $apartment->image }} 
                             @else {{ asset('storage/' . $apartment->image) }}          
                             @endif" 
                             class="img-fluid" alt="#">
                        <div class="card-body">
                          <h5 class="card-title text-black">{{ $apartment->title }}</h5>
                            <div class="d-md-flex justify-content-md-end">
                             <a href="#" class="btn text-white fw-semibold mx-1" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .70rem; background-color: #1278c6"><i class="fa-solid fa-pen"></i></a>
                             <a href="#" class="btn text-white fw-semibold mx-1" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .70rem; background-color: #A33B3B"><i class="fa-solid fa-trash"></i></a>
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

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection