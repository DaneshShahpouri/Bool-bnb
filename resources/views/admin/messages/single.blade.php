@extends('layouts/admin')

@section('content')

<div id="messages_index">

    <div class="container table-responsive">
        @foreach ($messages as $message)  
        <div class="d-lg-none card my-3">
            <div class="card-header">{{$message->apartment->name}}</div>
            <div class="card-body">
                <p><strong>Date:</strong> {{$message->created_at}}</p>
                <p><strong>Username:</strong> {{$message->username}}</p>
                <p><strong>Content:</strong> {{$message->content}}</p>
                <p><strong>Email:</strong> {{$message->email}}</p>
            </div>
        </div>
        @endforeach

        <table class="d-none d-lg-table table table-light table-hover m-auto mt-5">
            <thead>
                <th><i class="fa-solid fa-building"></i> Apartment</th>
                <th class="d-none d-md-table-cell"><i class="fa-solid fa-clock"></i> Date</th>
                <th class="d-none d-md-table-cell"><i class="fa-solid fa-user"></i> Username</th>
                <th class="_border-radius"><i class="fa-solid fa-thumbtack"></i> Content</th>
                <th class="d-none d-sm-table-cell"><i class="fa-solid fa-envelope"></i> Email</th>
            </thead>
        
            <tbody>
                @foreach ($messages as $message)  
                <tr>
                    <td>{{$message->apartment->name}}</td>
                    <td class="d-none d-md-table-cell">{{$message->created_at}}</td>
                    <td class="d-none d-md-table-cell">{{$message->username}}</td>
                    <td>{{$message->content}}</td>
                    <td class="d-none d-sm-table-cell">{{$message->email}}</td>
                </tr>
                @endforeach
            </tbody>
            
        </table>
    </div>
    
    <div class="m-4 d-flex justify-content-center">
        <a class="btn btn-outline-primary" href="{{route('admin.apartments.index')}}">See your apartments</a>
    </div>
</div>

@endsection
