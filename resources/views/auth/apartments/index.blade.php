@extends('layouts.app')

@section('content')

    

    <div class="container mt-4">
        <div class="row g-3">
            @foreach ($apartments as $apartment)
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                      <h5 class="card-title">{{ $apartment->title }}</h5>
                      <a href="#" class="btn btn-primary">Dettaglio</a>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" @if ($apartment->visible) checked                           
                        @endif>
                        <label class="form-check-label" for="flexSwitchCheckChecked">Visibile</label>
                      </div>
                    </div>
                  </div>
            </div>
            @endforeach
        </div>
    </div>
    

@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection