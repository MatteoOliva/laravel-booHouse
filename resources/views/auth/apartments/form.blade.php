@extends('layouts.app')

@section('content')

    <div class="container my-4 ">

        <h1 class="mb-5">Aggiungi un nuovo appartamento</h1>

        <form action="@if (!isset($apartment->id)) {{ route('user.apartments.store') }} @else {{ route('user.apartments.update') }} @endif" method="POST" enctype="multipart/form-data" id="apartment-form">
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
                    <label for="address" class="form-label">Indirizzo</label>
                    <input type="text" class="form-control" id="address" name="address" value=""/>
                </div>
                
                <div class="col">
                    <div class="form-label mb-1">Servizi aggiuntivi disponibili</div>
                    <div class="d-flex flex-wrap">
                        @foreach ($services as $service)
                            <div>
                                <input type="checkbox" name="services[]" id="tags-{{ $service->id }}" value="{{ $service->id }}" {{ in_array($service->id, old('service') ?? $related_services_ids ?? []) ? 'checked' : '' }} class="ms-1">
                                <label for="tags-{{ $service->id }}" class="ms-3">{{ $service->name }}</label>
                                <img src="{{ '/' . $service->icon }}" alt="">
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- hidden fields for lat and lon --}}
                <input type="hidden" id="lat" name="lat" value="">
                <input type="hidden" id="lon" name="lon" value="">
    
            </div>

            <button type="submit" class="btn btn-primary" id="save-button-form">Save</button>
            
            <button type="submit" class="btn btn-danger" id="save-button-form">Save</button>
        </form>


    </div>
    

@endsection

@section('js')


    <script>
       const saveButton = document.getElementById('save-button-form').addEventListener('click', function(event) {
        event.preventDefault();

        const url = 'https://api.tomtom.com/search/2/geocode/torino via roma 12.json?key=1ylMcjS1X2qwG3Q6Vy0KqcXpAjOa4ZkR';

        axios.get(url).then((response) => {

            const lat = response.data.results[0].position.lat;
            const lon = response.data.results[0].position.lon;



            document.getElementById('lat').value = lat;
            document.getElementById('lon').value = lon;


            document.getElementById('apartment-form').submit();



          
        })

       });
    </script>

@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection