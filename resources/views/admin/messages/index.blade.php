@extends('layouts/admin')

@section('content')

<table class="table table-light table-striped w-75 m-auto mt-5">
    <thead>
        <th>Apartment</th>
        <th>Date</th>
        <th>Username</th>
        <th>Contet</th>
        <th>Email</th>
    </thead>

    <tbody>
        @foreach ($messages as $message)  
        <tr>
            <td>{{$message->apartment_id != null ? $message->apartment->name : 'Cancelled'}}</td>
            <td>{{$message->created_at}}</td>
            <td>{{$message->username}}</td>
            <td>{{$message->content}}</td>
            <td>{{$message->email}}</td>
        </tr>
        @endforeach
    </tbody>
    
</table>

<div class="m-4 d-flex justify-content-center">
    <a class="btn btn-outline-primary" href="{{route('admin.apartments.index')}}">See your apartments</a>
</div>


@endsection