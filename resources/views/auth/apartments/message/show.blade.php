@extends('layouts.app')

@section('content')

<div class="main-index">
    <div class="container">
    <div class="d-md-flex justify-content-md-between my-3">
        <a href="{{route('user.messages.index', $apartment->slug)}}" class="btn my -4" style="background-color: #fab005; color: #0A0F15" > <i class="fa-solid fa-circle-left me-2" style="color: #0A0F15"></i>Torna ai messaggi</a>      
      </div>
<div class=" mt-4 main-conteiner">
      <h1 class="mb-5">Messaggio per {{ $apartment->title }}</h1>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title ">Da: <span style="color: #fab005">{{ $message->email }}</span></h5>
        </div>
        <div class="card-body">
            
            <p class="card-text"><strong class="fs-5">Contenuto:</strong><br> {{ $message->content }}</p>
            <p class="card-text"><small class="text-muted">Ricevuto il: {{ $message->created_at->format('d-m-Y - H:i') }}</small></p>
        </div>
    </div>
</div>
</div>
</div>
@endsection


@section('js')
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection