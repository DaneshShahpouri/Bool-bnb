
@extends('layouts/admin')

@section('content')


    <main id="dashboard">
        <h1 class="text-center mt-5">Welcome back, <span class="text-capitalize">{{Auth::user()->name == null ? 'User' : Auth::user()->name }}</span> <span class="text-capitalize">{{Auth::user()?->surname}}</span></h1>

        <p class="w-75 m-auto my-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos nesciunt inventore natus nisi quod cumque! Error delectus ullam saepe nemo. Aperiam nisi tempora nostrum quod obcaecati distinctio cupiditate porro quis!</p>
        <div class="container d-flex justify-content-center gap-3 mt-4">
            <a class="btn btn-outline-primary" href="{{route('admin.apartments.index')}}">See your apartments</a>
            
            <a class="btn btn-outline-primary" href="{{route('admin.apartments.create')}}">Add apartment</a>
            
            <a class="btn btn-outline-primary" href="{{route('admin.messages.index')}}">See your messages</a>
        </div>
    </main>
    
@endsection