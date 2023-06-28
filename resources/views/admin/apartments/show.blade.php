@php

$routeName = Route::currentRouteName();
  function routeNameContains($string) {
    return str_contains(Route::currentRouteName(), $string);
  }
@endphp


@extends('layouts/admin')
@section('content')
    <main id="apartment_show">

        {{-- Sidebar --}}
        <aside id="admin-sidebar" class="col-2 position-sticky" style="top:50px;">
            <div class="card {{ $routeName == 'admin.dashboard' ? 'border-danger' : ''}}">
                {{-- <div class="card-header {{ $routeName == 'admin.dashboard' ? 'text-danger' : ''}}">
                    {{$apartment->name}}
                </div> --}}
                {{-- <div class="list-group list-group-flush">
                    <a href="{{route('admin.dashboard')}}" class="list-group-item list-group-item-action {{ routeNameContains('admin.dashboard') ? 'active' : ''}}">Dashboard</a>
                </div> --}}
                <div class="list-group list-group-flush">
                    <a href="{{route('admin.dashboard')}}" class="py-3 list-group-item list-group-item-action {{ routeNameContains('admin.dashboard') ? 'active' : ''}}"><i class="fa-solid fa-house me-2"></i> Dashboard</a>
                    <a href="{{route('admin.apartments.index')}}" class="py-3 list-group-item list-group-item-action {{ routeNameContains('apartments.index') ? 'active' : ''}}"><i class="fa-solid fa-building me-2"></i> Your Apartments</a>
                    <a href="{{route ('admin.messages.single', $apartment->id)}}" class="py-3 list-group-item list-group-item-action {{ routeNameContains('apartments.index') ? 'active' : ''}}"><i class="fa-solid fa-envelope me-2"></i> Messages</a>
                    <a href="{{route('admin.sponsorships.show', $apartment->slug)}}" class="py-3 list-group-item list-group-item-action {{ routeNameContains('sponsorships.show') ? 'active' : ''}}"><i class="fa-solid fa-chart-line me-2"></i> Sponsor</a>
                    <a href="{{route('admin.apartments.edit' , $apartment->slug)}}" class="py-3 list-group-item list-group-item-action {{ routeNameContains('sponsorships.show') ? 'active' : ''}}"><i class="fa-solid fa-pen me-2"></i> Edit</a>
                    <a type="button" class="py-3 list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa-solid fa-trash me-2"></i> Delete</a>                    
                    {{-- <a href="{{route('admin.apartments.create')}}" class="list-group-item list-group-item-action {{ routeNameContains('apartments.create') ? 'active' : ''}}">Add Apartment</a> --}}
                </div>
            </div>

          
            {{-- <div class="card {{ routeNameContains('apartments.') ? 'border-danger' : ''}}">
                <div class="card-header {{ routeNameContains('apartments.') ? 'text-danger' : ''}}">
                    Dashboard
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{route('admin.apartments.index')}}" class="list-group-item list-group-item-action {{ routeNameContains('apartments.index') ? 'active' : ''}}">Your Apartments</a>
                    <a href="{{route('admin.sponsorships.show', $apartment->slug)}}" class="list-group-item list-group-item-action {{ routeNameContains('sponsorships.show') ? 'active' : ''}}">Sponsor Apt</a>
                    <a href="{{route('admin.apartments.create')}}" class="list-group-item list-group-item-action {{ routeNameContains('apartments.create') ? 'active' : ''}}">Add Apartment</a>
                </div>
            </div> --}}


            {{-- card messaggi --}}
            {{-- <div class="card {{ routeNameContains('apartments.') ? 'border-danger' : ''}}">
                <div class="card-header {{ routeNameContains('apartments.') ? 'text-danger' : ''}}">
                    Messages
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{route('admin.messages.index')}}" class="list-group-item list-group-item-action {{ routeNameContains('apartments.index') ? 'active' : ''}}">All Messages</a>
                    <a href="{{route ('admin.messages.single', $apartment->id)}}" class="list-group-item list-group-item-action {{ routeNameContains('apartments.index') ? 'active' : ''}}">Apt Messages</a>
                </div>
            </div> --}}
        </aside>
        {{-- end Sidebar --}}
      

        {{-- main --}}
        <div class="container">

            {{-- Apartment - name --}}
            <h1 class="my-3">{{$apartment->name}}</h1>

            {{-- Apartment - Photo --}}
            <div class="pt-4">
                <h3 class="mb-4">Photo</h3>
                <div class="img_container"><img src="{{asset('storage/' . $apartment->cover_image)}}" alt="Photo"></div>
            </div>

            {{-- ----------------------da inserire all' interno della foto --}}
            @if($activeSponsorships > 0)
            <div class="sponsored">
                This apartment is currently sponsored.
            </div>
            @endif
            {{-- ----------------------da inserire all' interno della foto --}}

            {{-- Apartment - Details --}}
            <div class="listing pt-5">
                <h3>Listing Basics</h3>
                <ul>
                    {{-- Apartment - name --}}
                    <li>
                        <div class="listing_title"><strong>Listing Title</strong> </div>
                        <div>{{$apartment->name}}</div>
                    </li>
                    {{-- Apartment - description --}}
                    <li>
                        <div class="listing_title"><strong>Listing Description</strong></div>
                        <div>{{$apartment->description}}</div>
                    </li>
                    {{-- Apartment - is visible --}}
                    <li>
                        <div class="listing_title"><strong>Listing status</strong></div>
                        <div><i class="{{$apartment->isVisible == 1 ? 'fa-regular fa-eye' : 'fa-regular fa-eye-slash'}}"></i> {{$apartment->isVisible == 1 ? "Listed - Guests can book your listing and find it in search results." : "Unlisted - Guests can't book your listing or find it in search results."}}</div>
                    </li>
                    {{-- Apartment - Services --}}
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

                    {{-- Apartment - address --}}
                    <li>
                        <div class="listing_title"><strong>Listing Address</strong></div>
                        <div>{{$apartment->address}}</div>
                    </li>
                </ul>

                <div class="bottom_listing py-3">
                    <h3>Property and Rooms</h3>
                    <ul>
                        {{-- Apartment - rooms --}}
                        <li>
                            <div class="listing_title"><strong>Rooms</strong></div>
                            <div>{{$apartment->rooms_number}}</div>
                        </li>
                        {{-- Apartment - sqm --}}
                        <li>
                            <div class="listing_title"><strong>Square meters</strong></div>
                            <div>{{$apartment->sqm}}</div>
                        </li>
                        {{-- Apartment - beds --}}
                        <li>
                            <div class="listing_title"><strong>Beds</strong></div>
                            <div>{{$apartment->beds_number}}</div>
                        </li>
                        {{-- Apartment - bathroom --}}
                        <li>
                            <div class="listing_title"><strong>Bathrooms</strong></div>
                            <div>{{$apartment->bathrooms_number}}</div>
                        </li>   
                    </ul>
                </div>
            </div>
                                
            {{-- Delete - button --}}
            {{-- <div class="d-flex gap-3 pb-5">
                <button class="btn btn-primary "><a href="{{route('admin.apartments.edit' , $apartment->slug)}}" class="text-white text-decoration-none">Edit Apartment</a></button>
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    DELETE
                </button> --}}
    
                {{-- Delete - modal --}}
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
                {{-- end Delete - modal --}}
            </div>  
        </div>

    </main>

    
    
@endsection