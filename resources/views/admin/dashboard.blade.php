
@extends('layouts/admin')

@section('content')


<main id="dashboard">
        {{-- Button --}}
        <div class="_dashboard-wrapper">
            <div class="_main">
                <h2 class="text-center my-3"><span class="_welcome">Welcome back,</span> <span class="text-capitalize">{{Auth::user()->name == null ? 'User' : Auth::user()->name }}</span> <span class="text-capitalize">{{Auth::user()?->surname}}<i class="fa-solid fa-user"></i></span></h2>
                
                <p class="mx-3 m-auto my-2">Welcome to your Dashboard! Here you can access your messages, manage your apartments, add new ones, or even sponsor an apartment to boost its visibility. Explore and make the most of our services!</p>
                <div class="container d-flex justify-content-center gap-3 my-3">
                    
                    <a class="btn btn-outline-primary  my-2" href="{{route('admin.apartments.index')}}">See your apartments</a>
                <a class="btn btn-outline-primary my-2" href="{{route('admin.messages.index')}}">See your messages</a>
                
                    
                </div>
            </div>
            <div class="_user">
                <h4 class="text-center">Profile <i class="fa-solid fa-feather"></i></h4>
                <div class="img-wrapper">
                    <img src="https://cdn.landesa.org/wp-content/uploads/default-user-image.png" alt="">
                </div>
                
                <span class="email">{{$user->email}}</span>
                <div class="memebership my-1">
                    
                    <span class="my-0">since:
                        <strong> {{substr($user->created_at, 0, 4)}}</strong></span>
                </div>
                <a class="btn btn-outline-primary my-2 px-3" href="{{route('profile.edit')}}">Edit Profile</a>
            </div>
        </div>
        <div class="_apartments">
            <h3 class="mb-3">Last Apartments <i class="fa-solid fa-building"></i></h3>
            <div class="card-wrapper">
                <a class="btn btn-outline-primary _add-apartment-button d-flex flex-column" href="{{route('admin.apartments.create')}}"><i class="fa-solid fa-plus"></i></a>
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
