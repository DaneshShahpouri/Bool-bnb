@extends('layouts/admin')

@section('content')

<div id="messages_index">

    <table class="table table-light table-striped w-75 m-auto mt-5">
        <thead>
            <th><i class="fa-solid fa-building"></i> Apartment</th>
            <th><i class="fa-solid fa-clock"></i> Date</th>
            <th><i class="fa-solid fa-user"></i> Username</th>
            <th><i class="fa-solid fa-thumbtack"></i> Contet</th>
            <th><i class="fa-solid fa-envelope"></i> Email</th>
        </thead>

        <tbody>
            @foreach ($messages as $message)  
            <tr>
                <td>{{$message->apartment->name}}</td>
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
</div>


@endsection