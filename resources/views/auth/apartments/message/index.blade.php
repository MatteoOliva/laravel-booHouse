@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-md-flex justify-content-md-between my-3">
        <a href="{{route('user.apartments.show', $apartment_slug)}}" class="btn my -4" style="background-color: #fab005; color: #0A0F15" > <i class="fa-solid fa-circle-left me-2" style="color: #0A0F15"></i>Torna all'appartamento</a>
      </div>

        <h1 class="mb-5">Messaggi per {{ $apartment->title }}</h1>
    <table class="table">
        <thead>
            <tr class="">
                <th scope="col">Mittente</th>
                <th scope="col" class="cont-col">Contenuto</th>
                <th scope="col">Data</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($messages as $message)
            <tr>
                <th class="text-warning">{{ $message->email }}</th>
                <td class="cont-col-bg">{{ Str::limit($message->content, 100) }}</td>
                <td class="cont-col-md">{{ Str::limit($message->content, 50) }}</td>
                <td>{{ $message->created_at }}</td>
                <td><a href="{{route('user.messages.show', $message)}}"><i class="fa-solid fa-eye text-primary"></i></a></td>
            </tr>
            @empty
            <tr>
                <td colspan="4"><i>Nessun messaggio ricevuto</i></td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    {{-- Se è stata usata la paginazione --}}
    {{ $messages->links('pagination::bootstrap-5') }}
</div>
@endsection


@section('js')
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection