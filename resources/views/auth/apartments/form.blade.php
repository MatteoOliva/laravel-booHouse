@extends('layouts.app')

@section('content')

    <div class="container my-4 ">

        <h1 class="mb-5">Aggiungi un nuovo appartamento</h1>

        <form action="@if (!isset($apartment->id)) {{ route('user.apartments.store') }} @else {{ route('user.apartments.update') }} @endif" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($apartment->id)) 
                @method('PATCH')
            @endif

            <div class="row">
    
                <div class="col-6">
                    <label for="description" class="form-label">Titolo</label>
                    <input type="text" class="form-control" id="title" name="title" value=""/>
                </div>

                <div class="col-6">
                    <label for="description" class="form-label">Descrizione</label>
                    <input type="text" class="form-control" id="description" name="description" value=""/>
                </div>

                <div class="col-6">
                    <label for="rooms" class="form-label">N. di camere</label>
                    <input type="number" class="form-control" id="rooms" name="rooms" value=""/>
                </div>

                <div class="col-6">
                    <label for="beds" class="form-label">N. di letti</label>
                    <input type="number" class="form-control" id="beds" name="beds" value=""/>
                </div>

                <div class="col-6">
                    <label for="toilets" class="form-label">N. di bagni</label>
                    <input type="number" class="form-control" id="toilets" name="toilets" value=""/>
                </div>

                <div class="col-6">
                    <label for="mq" class="form-label">Metri quadri</label>
                    <input type="number" class="form-control" id="mq" name="mq" value=""/>
                </div>

                <div class="col-6">
                    <label for="image" class="form-label">Immagine</label>
                    <input type="text" class="form-control" id="image" name="image" value=""/>
                </div>

                <div class="col-6">
                    <label for="lat" class="form-label">Lat</label>
                    <input type="number" class="form-control" id="lat" name="lat" value=""/>
                </div>

                <div class="col-6">
                    <label for="lon" class="form-label">Lon</label>
                    <input type="number" class="form-control" id="lon" name="lon" value=""/>
                </div>

                <div class="col-6">
                    <label for="address" class="form-label">Indirizzo</label>
                    <input type="text" class="form-control" id="address" name="address" value=""/>
                </div>
    
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>


    </div>
    

@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection