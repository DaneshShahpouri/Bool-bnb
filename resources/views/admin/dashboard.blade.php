
@extends('layouts/admin')

@section('content')


<main id="dashboard">
        {{-- Button --}}
        <div class="_dashboard-wrapper">
            <div class="_main">
                <h2 class="text-center mt-5">Welcome back, <span class="text-capitalize">{{Auth::user()->name == null ? 'User' : Auth::user()->name }}</span> <span class="text-capitalize">{{Auth::user()?->surname}}</span></h2>
                
                <p class="w-75 m-auto my-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos nesciunt inventore natus nisi quod cumque! Error delectus ullam saepe nemo. Aperiam nisi tempora nostrum quod obcaecati distinctio cupiditate porro quis!</p>
                <div class="container d-flex justify-content-center gap-3 my-4">
                    
                    <a class="btn btn-outline-primary  my-3" href="{{route('admin.apartments.index')}}">See your apartments</a>
                <a class="btn btn-outline-primary my-3" href="{{route('admin.messages.index')}}">See your messages</a>
                
                    
                </div>
            </div>
            <div class="_user">
                <h4 class="text-center">{{$user->name}}</h4>
                <div class="img-wrapper">
                    <img src="https://cdn.landesa.org/wp-content/uploads/default-user-image.png" alt="">
                </div>
                
                <div class="email">{{$user->email}}</div>
                <a class="btn btn-outline-primary my-3 px-3" href="{{route('profile.edit')}}">Edit Profile</a>
            </div>
        </div>
        <div class="_apartments">
            <h3 class="my-3">Last Apartments</h3>
            <div class="card-wrapper">
                <a class="btn btn-outline-primary _add-apartment-button" href="{{route('admin.apartments.create')}}">Add apartment</a>
                @for ($i=0; $i<3; $i++) 
                <a  class="card" href="{{route ('admin.apartments.show' , $apartments[$i]->slug)}}">
                        <div class="img-wrapper">
                            <img src="{{ asset('storage/' . $apartments[$i]->cover_image) }}" alt="">
                        </div>
                        <div class="info-card">
                            <h6>
                                {{$apartments[$i]->name}}
                            </h6>
                            <span>
                                {{$apartments[$i]->address}}
                            </span>
                        </div>
                        
                </a>   
                @endfor
            </div>
        </div>
    </main>
    
@endsection
