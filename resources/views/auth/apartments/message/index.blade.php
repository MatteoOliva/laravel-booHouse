@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Mittente</th>
                <th scope="col">Contenuto</th>
                <th scope="col">Data</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($messages as $message)
            <tr>
                <th >{{ $message->email }}</th>
                <td>{{ Str::limit($message->content, 50) }}</td>
                <td>{{ $message->created_at }}</td>
                <td>APRI</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    {{-- Se è stata usata la paginazione --}}
    {{-- {{ $related_messages->links('pagination::bootstrap-5') }} --}}
</div>
@endsection


@section('js')
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection