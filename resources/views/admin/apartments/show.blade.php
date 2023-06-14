@php

$routeName = Route::currentRouteName();
  function routeNameContains($string) {
    return str_contains(Route::currentRouteName(), $string);
  }
@endphp


@extends('layouts/admin')

@section('content')

    <main id="apartment_show">

        

        
        <aside id="admin-sidebar" class="mt-5">
            <div class="card {{ $routeName == 'admin.dashboard' ? 'border-danger' : ''}}">
                <div class="card-header {{ $routeName == 'admin.dashboard' ? 'text-danger' : ''}}">
                    Home
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{route('admin.dashboard')}}" class="list-group-item list-group-item-action {{ routeNameContains('admin.dashboard') ? 'active' : ''}}">dashboard</a>
                </div>
            </div>

            {{-- <div class="card {{ str_contains(Route::currentRouteName(), 'apartments.') ? 'border-warning' : ''}}"> --}}
            <div class="card {{ routeNameContains('apartments.') ? 'border-danger' : ''}}">
                <div class="card-header {{ routeNameContains('apartments.') ? 'text-danger' : ''}}">
                    Apartments
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{route('admin.apartments.index')}}" class="list-group-item list-group-item-action {{ routeNameContains('apartments.index') ? 'active' : ''}}">Index</a>
                    <a href="{{route('admin.apartments.create')}}" class="list-group-item list-group-item-action {{ routeNameContains('apartments.create') ? 'active' : ''}}">Add Apartments</a>
                </div>

            </div>

            {{-- <div class="card {{ routeNameContains('types.') ? 'border-warning' : ''}}">
                <div class="card-header {{ routeNameContains('types.') ? 'text-warning' : ''}}">
                    Types
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{route('admin.types.index')}}" class="list-group-item list-group-item-action {{ routeNameContains('types.index') ? 'active' : ''}}">Index</a>
                    <a href="{{route('admin.types.create')}}" class="list-group-item list-group-item-action {{ routeNameContains('types.create') ? 'active' : ''}}">Add Type</a>

                </div>
            </div> --}}

        </aside>
      

        <div class="container">

            <h1 class="my-3">{{$apartment->name}}</h1>

            <div class="pt-4">
                <h3>Photo</h3>

                <img src="" alt="">
            </div>

            <div class="listing py-5">

                <h3>Listing Basics</h3>

                <ul>
                    <li>
                        <div class="listing_title"><strong>Listing Title</strong> </div>
                        <div>{{$apartment->name}}</div>
                    </li>
                    <li>
                        <div class="listing_title"><strong>Listing Description</strong></div>
                        <div>{{$apartment->description}}</div>
                    </li>
                    <li>
                        <div class="listing_title"><strong>Listing status</strong></div>
                        <div><i class="{{$apartment->isVisible == 1 ? 'fa-regular fa-eye' : 'fa-regular fa-eye-slash'}}"></i> {{$apartment->isVisible == 1 ? "Listed - Guests can book your listing and find it in search results." : "Unlisted - Guests can't book your listing or find it in search results."}}</div>
                    </li>
                    <li>
                        <div class="listing_title"><strong>Amenities</strong></div>
                        <div>
                            <ul class="d-flex">
                                @foreach ($apartment->services as $service)
                                    <li class="border-0"><div>{!!$service->icon !!} {{$service->name}}</div></li>
                                @endforeach
                            </ul>
                        </div>
                    </li>

                    <li>
                        <div class="listing_title"><strong>Listing Address</strong></div>
                        <div>{{$apartment->address}}</div>
                    </li>
                </ul>

                <div class="bottom_listing py-5">

                    <h3>Property and Rooms</h3>
    
                    <ul>
                        <li>
                            <div class="listing_title"><strong>Rooms</strong></div>
                            <div>{{$apartment->rooms_number}}</div>
                        </li>
                        <li>
                            <div class="listing_title"><strong>Square meters</strong></div>
                            <div>{{$apartment->sqm}}</div>
                        </li>
                        <li>
                            <div class="listing_title"><strong>Beds</strong></div>
                            <div>{{$apartment->beds_number}}</div>
                        </li>
                        <li>
                            <div class="listing_title"><strong>Bathrooms</strong></div>
                            <div>{{$apartment->bathrooms_number}}</div>
                        </li>
                        
                    </ul>
    
                </div>
               
                
            </div>
                                
            
            
            <div><a href="">Visualizza messaggi appartamento</a></div>
    
            <button>modifica</button>
            <button>elimina</button>

            
            
            
        </div>

    </main>

    
    
@endsection