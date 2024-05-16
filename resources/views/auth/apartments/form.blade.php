@extends('layouts.app')

@section('content')

    <div class="container my-4 ">

        @if(!isset($apartment->id))
            <h1 class="mb-5">Aggiungi un nuovo appartamento</h1>
        @else
            <h1 class="mb-5">Modifica l'appartamento {{ $apartment->title }}</h1>
        @endif

        <form action="@if (!isset($apartment->id)) {{ route('user.apartments.store') }} @else {{ route('user.apartments.update', $apartment) }} @endif" method="POST" enctype="multipart/form-data" id="apartment-form">
            @csrf
            @if (isset($apartment->id)) 
                @method('PATCH')
            @endif

            <div class="row">
                <div class="col-12 col-lg-9">
                    <div class="row">
                        <div class="col-12">
                            <label for="title" class="form-label mt-3">Titolo</label>
                            
                            <input autofocus required type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') ?? $apartment->title ?? '' }}"/>
                            <div class="invalid-feedback @error('title') d-block @else d-none @enderror" id="title-feedback">
                                @error('title')
                                {{ $message }}
                                @enderror
                            </div>                           
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label mt-3">Indirizzo</label>
                            <input required type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') ?? $apartment->address ?? '' }}" oninput="fetchAutocomplete(this.value)" autocomplete="off"/>
                            <div id="autocomplete-results" class="list-group position-absolute"></div>
                            <div class="invalid-feedback @error('address') d-block @else d-none @enderror" id="adress-feedback">
                                @error('address')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
        
                        <div class="col-12">
                            <label for="description" class="form-label mt-3">Descrizione</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" cols="30" rows="10">{{ old('description') ?? $apartment->description ?? ''  }}</textarea>
                            <div class="invalid-feedback @error('description') d-block @else d-none @enderror" id="description-feedback">
                                @error('description')
                                {{ $message }}
                                @enderror
                            </div>
                            {{-- @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror --}}
                        </div>
        
                        <div class="col-12">
                            <label for="rooms" class="form-label mt-3">N. di camere</label>
                            <input type="number" class="form-control @error('rooms') is-invalid @enderror" id="rooms" name="rooms" min="1" value="{{ old('rooms') ?? $apartment->rooms ?? '' }}" required/>                            
                            <div class="invalid-feedback @error('rooms') d-block @else d-none @enderror" id="rooms-feedback">
                                @error('rooms')
                                {{ $message }}
                                @enderror
                            </div>
                            {{-- @error('rooms')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror --}}
                        </div>
        
                        <div class="col-12">
                            <label for="beds" class="form-label mt-3">N. di letti</label>
                            <input required type="number" class="form-control @error('beds') is-invalid @enderror" id="beds" name="beds" value="{{ old('beds') ?? $apartment->beds ?? '' }}"/>
                            <div class="invalid-feedback @error('beds') d-block @else d-none @enderror" id="beds-feedback">
                                @error('beds')
                                {{ $message }}
                                @enderror
                            </div>
                            {{-- @error('beds')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror --}}
                        </div>
        
                        <div class="col-12">
                            <label for="toilets" class="form-label mt-3">N. di bagni</label>
                            <input type="number" class="form-control @error('toilets') is-invalid @enderror" id="toilets" name="toilets"  value="{{ old('toilets') ?? $apartment->toilets ?? '' }}" required/>
                            <div class="invalid-feedback @error('toilets') d-block @else d-none @enderror" id="toilets-feedback">
                                @error('toilets')
                                {{ $message }}
                                @enderror
                            </div> 
                            {{-- @error('toilets')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror --}}
                        </div>
        
                        <div class="col-12">
                            <label for="mq" class="form-label mt-3">Metri quadri</label>
                            <input type="number" class="form-control @error('mq') is-invalid @enderror" id="mq" name="mq" min="5" value="{{ old('mq') ?? $apartment->mq ?? '' }}" required/>
                            <div class="invalid-feedback @error('mq') d-block @else d-none @enderror" id="mq-feedback">
                                @error('mq')
                                {{ $message }}
                                @enderror
                            </div>
                            {{-- @error('mq')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror --}}
                        </div>
        
                        <div class="col-12 ">                
                            @if(isset($apartment->image))
                                <div class="form-label mt-3">Immagine</div>
                                <div class="image-cover">
                                    <img class="img-fluid mb-3 " src="@if (substr($apartment->image,0,3) == 'img') {{ '/' . $apartment->image }} @else {{ asset('storage/' . $apartment->image) }} @endif" alt="apartment image">
                                    <div class="col-6 d-flex flex-column justify-content-end align-items-start">
                                        <div class="btn btn-danger mb-3 image-trash" id="delete-img-btn"><i class="fa-solid fa-x"></i></div>
                                    </div>
                                </div>                               
                                <label for="image" class="form-label">Cambia immagine</label>
                            @else
                                <label for="image" class="form-label mt-3">Aggiungi Immagine</label>
                            @endif
                            @if(isset($apartment->image))
                            
                        @endif
                            <input required class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" value="{{ old('image') ?? '' }}" accept=".jpeg,.jpg,.png,.gif">
                            <div class="invalid-feedback @error('image') d-block @else d-none @enderror" id="image-feedback">
                                @error('image')
                                {{ $message }}
                                @enderror
                            </div>
                            {{-- @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror --}}
                        </div>                      
        
                        
                        
                    </div>
                    
                    {{-- hidden fields for lat and lon --}}
                    <input type="hidden" id="lat" name="lat" value="">
                    <input type="hidden" id="lon" name="lon" value="">
                    
                </div>
                
                <div class="col-12 col-lg-3">                  
                    <div class="form-label mt-3">Servizi aggiuntivi disponibili</div>
                    <div class="row">
                        @foreach ($services as $service)
                            <div class="my-2 col-6 col-lg-12">
                                <input type="checkbox" name="services[]" id="tags-{{ $service->id }}" value="{{ $service->id }}" {{ in_array($service->id, old('service') ?? $related_services_ids ?? []) ? 'checked' : '' }} class="me-1">
                                <img src="{{ '/' . $service->icon }}" alt="" style="width: 30px" class="me-1">
                                <label for="tags-{{ $service->id }}" class="me-1 text-service">{{ $service->name }}</label>
                            </div>
                        @endforeach          
                    </div>
                </div>
                        
                <div> 
                    <button type="submit" class="btn btn-primary mt-3" id="save-button-form">Salva</button>
                </div>
            
        </form>

        @if(isset($apartment->image))
            <form class="d-none" action="{{ route('user.apartments.destroy_image', $apartment) }}" method="POST" id="delete-img-form">
                @csrf
                @method('DELETE') 
            </form>
        @endif

    </div>
    

@endsection

@section('js')


    <script>
       

       function fetchAutocomplete(query) {
            if (query.length > 3) {
                const apiKey = '{{ env("API_TOMTOM_KEY") }}';
                const url = 'https://api.tomtom.com/search/2/geocode/' + encodeURIComponent(query) + '.json?countrySet=IT&language=it-IT&key=' + apiKey;
                // console.log(apiKey)
                axios.get(url)
                    .then(response => {
                        const results = response.data.results;
                        const container = document.getElementById('autocomplete-results');
                        // Pulisce i vecchi risultati
                        container.innerHTML = ''; 

                        if (results.length > 0) {
                            results.forEach(result => {
                                const div = document.createElement('a');
                                div.innerHTML = result.address.freeformAddress;

                                // Classi di Bootstrap per gli elementi della lista
                                div.classList.add('list-group-item', 'list-group-item-action'); 
                                div.onclick = function () {
                                    document.getElementById('address').value = result.address.freeformAddress;
                                    

                                    // Nasconde i risultati dopo la selezione
                                    container.innerHTML = '';
                                };
                                container.appendChild(div);
                            });
                        }
                    })
            } else {
                // Pulisce i risultati se la query è troppo breve
                document.getElementById('autocomplete-results').innerHTML = ''; 
            }
        }


        const saveButton = document.getElementById('save-button-form').addEventListener('click', function(event) {
            //preveniamo l'invio del form
            event.preventDefault();
            // prendiamo l'imput dell'indirizzo e il suo valore(ovvero la query)
            const adressInput = document.getElementById('address');
            const query = adressInput.value;
            //se la query ha almeno 1 carattere
            if (query.length > 0) {

                // prendo l'API key dal file env
                const apiKey = '{{ env("API_TOMTOM_KEY") }}';
                // const apiKey = '';

                // compongo l'url con tutti i dati
                const url = 'https://api.tomtom.com/search/2/geocode/' + query + '.json?key=' + apiKey;
                // console.log(apiKey);    

                // chiamo l'api di tomtom 
                axios.get(url).then((response) => {
                    
                    // console.log(response);
                    // salvo i dati della longitudine e della latitudine
                    const lat = response.data.results[0].position.lat;
                    const lon = response.data.results[0].position.lon;
                    // console.log(lat, lon);

                    // inserisco la latitudine e la longitudine negli appositi input del form
                    document.getElementById('lat').value = lat;
                    document.getElementById('lon').value = lon;

                    // console.log(document.getElementById('lat').value, document.getElementById('lon').value);

                    // submitto il form
                    document.getElementById('apartment-form').submit();
                
                }).catch((error) => {

                    // console.log(error.response.data);
                    window.location.href = '{{ route("user.apartments.back_to_index") }}';

                })


            // se invece il canpo indirizzo è vuoto
            } else {

                // aggiungi la classe is-invalid all'input
                adressInput.classList.add('is-invalid');
                // prendo il div del feedback, gli tolgo il d-none e inserisco il messaggio di errore
                const adressFeedback = document.getElementById('adress-feedback');
                adressFeedback.classList.remove('d-none');
                adressFeedback.innerText = "L'indirizzo è obbligatorio";
                // console.log(adressFeedback.innerText);

            }

            // document.getElementById('lat').value = 10;
            // document.getElementById('lon').value = 10;
            // document.getElementById('apartment-form').submit();


            //validazione titolo
            const titleInput = document.getElementById('title');
            const querytitle = titleInput.value;
            if (querytitle.length == 0){
                // aggiungi la classe is-invalid all'input
                titleInput.classList.add('is-invalid');
                // prendo il div del feedback, gli tolgo il d-none e inserisco il messaggio di errore
                const titleFeedback = document.getElementById('title-feedback');
                titleFeedback.classList.remove('d-none');
                titleFeedback.innerText = "Il titolo è obbligatorio";
            }

            //validazione descrizione
            const descriptionInput = document.getElementById('description');
            const querydescription = descriptionInput.value;
            if (querydescription.length == 0){
                // aggiungi la classe is-invalid all'input
                descriptionInput.classList.add('is-invalid');
                // prendo il div del feedback, gli tolgo il d-none e inserisco il messaggio di errore
                const descriptionFeedback = document.getElementById('description-feedback');
                descriptionFeedback.classList.remove('d-none');
                descriptionFeedback.innerText = "La descrizione è obbligatoria";
            }

            //validazione camere
            const roomsInput = document.getElementById('rooms');
            const queryrooms = roomsInput.value;
            if (queryrooms <= 0 || queryrooms >= 500){
                // aggiungi la classe is-invalid all'input
                roomsInput.classList.add('is-invalid');
                // prendo il div del feedback, gli tolgo il d-none e inserisco il messaggio di errore
                const roomsFeedback = document.getElementById('rooms-feedback');
                roomsFeedback.classList.remove('d-none');
                roomsFeedback.innerText = "Il numero delle camere deve essere tra 1 e 500";
            }

            //validazione letti
            const bedsInput = document.getElementById('beds');
            const querybeds = bedsInput.value;
            if (querybeds <= 0 || querybeds >= 500){
                // aggiungi la classe is-invalid all'input
                bedsInput.classList.add('is-invalid');
                // prendo il div del feedback, gli tolgo il d-none e inserisco il messaggio di errore
                const bedsFeedback = document.getElementById('beds-feedback');
                bedsFeedback.classList.remove('d-none');
                bedsFeedback.innerText = "Il numero dei letti deve essere tra 1 e 500";
            }

            //validazione bagni
            const toiletsInput = document.getElementById('toilets');
            const querytoilets = toiletsInput.value;
            if (querytoilets <= 0 || querytoilets >= 500){
                // aggiungi la classe is-invalid all'input
                toiletsInput.classList.add('is-invalid');
                // prendo il div del feedback, gli tolgo il d-none e inserisco il messaggio di errore
                const toiletsFeedback = document.getElementById('toilets-feedback');
                toiletsFeedback.classList.remove('d-none');
                toiletsFeedback.innerText = "Il numero dei bagni deve essere tra 1 e 500";
            }

            //validazione metri quadri
            const mqInput = document.getElementById('mq');
            const querymq = toiletsInput.value;
            if (querymq <= 5){
                // aggiungi la classe is-invalid all'input
                mqInput.classList.add('is-invalid');
                // prendo il div del feedback, gli tolgo il d-none e inserisco il messaggio di errore
                const mqFeedback = document.getElementById('mq-feedback');
                mqFeedback.classList.remove('d-none');
                mqFeedback.innerText = "Il valore inserito deve essere minimo 5";
            }

            //validazione immagine
            const imageInput = document.getElementById('image');
            const queryimage = imageInput.value;
            if (!queryimage){
                // aggiungi la classe is-invalid all'input
                imageInput.classList.add('is-invalid');
                // prendo il div del feedback, gli tolgo il d-none e inserisco il messaggio di errore
                const imageFeedback = document.getElementById('image-feedback');
                imageFeedback.classList.remove('d-none');
                imageFeedback.innerText = "Immagine obbligatoria";
            }
        });

        // get all elements from the dom
        const deleteImgForm = document.getElementById('delete-img-form');
        const deleteImgBtn = document.getElementById('delete-img-btn');
        // console.log(deleteImgBtn,deleteImgForm);

        if(deleteImgBtn) {

            // add an event listener on the button
            deleteImgBtn.addEventListener('click', () => {

                console.log(deleteImgForm);
                //submit the form
                deleteImgForm.submit();
            });

        }
</script>

@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@endsection