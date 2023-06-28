@extends('layouts/admin')

@section('content')

<div id="messages_index">

    <div class="container mt-3 mb-5 table-responsive">

        <div class="d-flex my-5 justify-content-center justify-content-lg-start">
            <a class="btn btn-outline-primary me-3" href="{{route('admin.dashboard')}}">Dashboard</a>
            <a class="btn btn-outline-primary me-3"  href="{{route ('admin.apartments.index')}}">Your Apartments</a>
        </div>

        @foreach ($messages as $message)  
        {{-- <div class="d-lg-none card my-3"> --}}
        <div class="card my-3">
            <div class="card-header">{{ $message->apartment_id != null ? $message->apartment->name : 'Cancelled' }}</div>
            <div class="card-body">
                <p><strong>Date:</strong> {{$message->created_at}}</p>
                <p><strong>Username:</strong> {{$message->username}}</p>
                <p><strong>Content:</strong> {{$message->content}}</p>
                <p><strong>Email:</strong> {{$message->email}}</p>
            </div>
        </div>
        @endforeach

        {{-- <table class="d-none d-lg-table table table-light table-hover m-auto mt-5"> --}}
        <table class="d-none table table-light table-hover m-auto mt-5">
            <thead>
                <th><i class="fa-solid fa-building"></i> Apartment</th>
                <th><i class="fa-solid fa-clock"></i> Date</th>
                <th><i class="fa-solid fa-user"></i> Username</th>
                <th><i class="fa-solid fa-thumbtack"></i> Content</th>
                <th><i class="fa-solid fa-envelope"></i> Email</th>
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
    </div>
    
</div>

@endsection