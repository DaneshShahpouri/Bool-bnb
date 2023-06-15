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

          
            <div class="card {{ routeNameContains('apartments.') ? 'border-danger' : ''}}">
                <div class="card-header {{ routeNameContains('apartments.') ? 'text-danger' : ''}}">
                    Apartments
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{route('admin.apartments.index')}}" class="list-group-item list-group-item-action {{ routeNameContains('apartments.index') ? 'active' : ''}}">Index</a>
                    <a href="{{route('admin.apartments.create')}}" class="list-group-item list-group-item-action {{ routeNameContains('apartments.create') ? 'active' : ''}}">Add Apartments</a>
                </div>
            </div>
        </aside>
      

        <div class="container">

            <h1 class="my-3">{{$apartment->name}}</h1>

            <div class="pt-4">
                <h3 class="mb-4">Photo</h3>

                <div class="img_container"><img src="{{asset('storage/' . $apartment->cover_image)}}" alt="Photo"></div>
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
                                
            
            <div class="mb-4"><a href="">Visualizza messaggi appartamento</a></div>
    
            <div class="d-flex gap-3 py-3">

                <button class="btn btn-primary "><a href="{{route('admin.apartments.edit' , $apartment->slug)}}" class="text-white text-decoration-none">Edit Apartment</a></button>
                
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    DELETE
                </button>
    
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete your apartment</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Are you sure you want to delete {{$apartment->name}}?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <form action="{{route('admin.apartments.destroy', $apartment->slug)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">DELETE</button>
                          </form>
                          
                        </div>
                      </div>
                    </div>
                </div>
            </div>  
        </div>

    </main>

    
    
@endsection