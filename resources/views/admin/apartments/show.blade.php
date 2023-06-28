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
        <div class="container _container">

            <div class="left-inner">
                {{-- Apartment - name --}}
                <div class="name-container">
                    <h1 class="name">{{$apartment->name}}</h1>
                    @if($activeSponsorships > 0)
                    <div class="sponsored">
                        <i class="fa-solid fa-rocket icon"></i>
                        <span>Sponsored</span> 
                    </div>   
                    @else
                    <div class="sponsored">
                        <i class="fa-solid fa-ghost icon"></i>
                        <span>Not sponsored</span> 
                    </div>  
                    @endif
                </div>
    
                {{-- Apartment - Photo --}}
                    <div class="img_container">
                        <img src="{{asset('storage/' . $apartment->cover_image)}}" alt="Photo">
                    </div>
                
                
                {{-- Apartment - is visible --}}
                <div class="info-container-left">
                    <div class="listing_title-left st"><strong>Status</strong></div>
                    <div>
                        <i class="{{$apartment->isVisible == 1 ? 'fa-regular fa-eye' : 'fa-regular fa-eye-slash'}}"></i>
                        {{$apartment->isVisible == 1 ? "Listed - Guests can book your listing and find it in search results." : "Unlisted - Guests can't book your listing or find it in search results."}}
                    </div>
                </div>
                
                 {{-- Apartment - Services --}}
                 <div class="info-container-left">
                     <div class="listing_title-left"><strong>Amenities</strong></div>
                     <div>
                         <ul class="amenities-container">
                             @foreach ($apartment->services as $service)
                                 <li class="border-0"><div class="am"><span class="am-icon">{!!$service->icon !!}</span> {{$service->name}}</div></li>
                             @endforeach
                         </ul>
                     </div>  
                 </div>
            </div>

            <div class="right-inner">

                {{-- Apartment - Details --}}
                <div class="listing-container">
                    <div class="listing_title">Listing Basics</div>
                    <ul>
                        {{-- Apartment - name --}}
                        <li>
                            <div class="listing_title-right"><i class="fa-solid fa-hotel"></i>Name </div>
                            <div class="results">{{$apartment->name}}</div>
                        </li>
                        {{-- Apartment - description --}}
                        <li>
                            <div class="listing_title-right"><i class="fa-solid fa-pen"></i>Description</div>
                            <div class="results">{{$apartment->description}}</div>
                        </li>
    
                        {{-- Apartment - address --}}
                        <li>
                            <div class="listing_title-right"><i class="fa-solid fa-location-dot"></i>Address</div>
                            <div class="results">{{$apartment->address}}</div>
                        </li>
                    </ul>
                </div>
                
                <div class="listing-container">
                    <div class="listing_title">Property and Rooms</div>
                    <ul>
                        {{-- Apartment - sqm --}}
                        <li class="results-container">
                            <div class="listing_title-right"><i class="fa-solid fa-arrows-left-right"></i>Square meters</div>
                            <div class="results">{{$apartment->sqm}}</div>
                        </li>
                        {{-- Apartment - rooms --}}
                        <li class="results-container">
                            <div class="listing_title-right"><i class="fa-solid fa-door-closed"></i>Rooms</div>
                            <div class="results">{{$apartment->rooms_number}}</div>
                        </li>
                        {{-- Apartment - beds --}}
                        <li class="results-container">
                            <div class="listing_title-right"><i class="fa-solid fa-bed"></i>Beds</div>
                            <div class="results">{{$apartment->beds_number}}</div>
                            
                        </li>
                        {{-- Apartment - bathroom --}}
                        <li class="results-container">
                            <div class="listing_title-right"><i class="fa-solid fa-bath"></i>Bathrooms</div>
                            <div class="results">{{$apartment->bathrooms_number}}</div>
                            
                        </li>   
                    </ul>
                </div>
            </div>


            {{-- ----------------------da inserire all' interno della foto --}}

                                
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