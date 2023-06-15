
@extends('layouts/admin')

@section('content')

    <main id="dashboard">
        <h1 class="text-center mt-5">Welcome back, {{Auth::user()->name }} {{Auth::user()->surname}} </h1>

        <div class="container d-flex justify-content-center gap-3 mt-4">
            <a class="btn btn-primary" href="{{route('admin.apartments.index')}}">See your apartments</a>

            <a class="btn btn-primary" href="{{route('admin.apartments.create')}}">Add apartment</a>
        </div>
    </main>
    
@endsection