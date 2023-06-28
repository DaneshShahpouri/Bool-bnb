@extends('layouts/admin')

@section('content')

<main id="apartment_index">
    <div class="container">
      
      <h1 class="mt-5 text-center text-lg-start">Welcome back, <span class="text-capitalize">{{Auth::user()->name == null ? 'User' : Auth::user()->name }}</span> <span class="text-capitalize">{{Auth::user()?->surname}}</span></h1>

      <div class="d-flex my-5 justify-content-center justify-content-lg-start">
        {{-- <a class="btn btn-outline-primary me-3" href="{{route('admin.dashboard')}}">Dashboard</a> --}}
        <a class="btn btn-outline-primary me-3"  href="{{route ('admin.apartments.create')}}">Add Apartment</a>
        <a class="btn btn-outline-primary me-3" href="{{route('admin.messages.index')}}">All messages</a>
      </div>


      <table class="table table-striped my-5">
          {{-- Table - head --}}
            <thead>
              <tr>
                <th scope="col">Image</th>
                <th scope="col" class="d-none d-md-table-cell">Listing</th>
                {{-- <th scope="col">Slug</th> --}}
                <th scope="col">Status</th>
                <th scope="col" class="d-none d-lg-table-cell">Rooms</th>
                <th scope="col" class="d-none d-lg-table-cell">Beds</th>
                <th scope="col" class="d-none d-lg-table-cell">Bathrooms</th>
                <th scope="col" class="d-none d-sm-table-cell">Address</th>
                <th scope="col">Details</th>
              </tr>
            </thead>
          {{-- Table - body --}}
            <tbody>
              @foreach ($apartments as $apartment)
              @if ($apartment->user_id == Auth::id())
                <tr>
                  <td class="align-middle">
                    <div class="d-flex align-items-center">
                    <img src="{{ asset('storage/' . $apartment->cover_image) }}" alt="Apartment Image" style="width: 80px; height: 50px;">
                    @if($apartment->sponsorships->count() > 0)
                      <i class="fa-solid fa-star text-warning px-2"></i>
                    @endif
                  </td>
                  <td class="align-middle d-none d-md-table-cell">{{strlen($apartment->name) > 25 ? substr($apartment->name, 0, 25) . '...' : $apartment->name}}</td>
                  {{-- <td>{{strlen($apartment->slug) > 40 ? substr($apartment->slug, 0, 40) . '...' : $apartment->slug}}</td> --}}
                  <td class="align-middle">
                    <div class="d-flex align-items-center">
                      <div class="check {{$apartment->isVisible == 1 ? 'bg-success' : 'bg-danger'}}"></div>
                      <div class="px-2">{{$apartment->isVisible == 1 ? ' Listed' : ' Unlisted'}}</div>
                    </div>
                  </td>
                  <td class="align-middle d-none d-lg-table-cell">{{$apartment->rooms_number}}</td>
                  <td class="align-middle d-none d-lg-table-cell">{{$apartment->beds_number}}</td>
                  <td class="align-middle d-none d-lg-table-cell">{{$apartment->bathrooms_number}}</td>
                  <td class="align-middle d-none d-sm-table-cell">{{strlen($apartment->address) > 40 ? substr($apartment->address, 0, 40) . '...' : $apartment->address}}</td>
                  <td class="align-middle">
                    <div class="d-flex gap-3">
                      <a href="{{route ('admin.apartments.show' , $apartment->slug)}}"><i class="fa-solid fa-magnifying-glass"></i></a>
                      <a href="{{route ('admin.messages.single', $apartment->id)}}"><i class="fa-regular fa-envelope"></i></i></a>
                      <a href="{{route('admin.sponsorships.show', $apartment->slug)}}"><i class="fa-solid fa-sack-dollar"></i></i></i></a>
                    </div>
                  </td>
                </tr>
              @endif
              @endforeach
            </tbody>
          </table>

    </div>
</main>    
@endsection

