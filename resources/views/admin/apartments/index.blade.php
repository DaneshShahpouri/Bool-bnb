@extends('layouts/admin')

@section('content')

<main id="apartment_index">
    <div class="container">
      <table class="table  table-striped my-3">
          {{-- Table - head --}}
            <thead>
              <tr>
                <th scope="col">Image</th>
                <th scope="col">Listing</th>
                {{-- <th scope="col">Slug</th> --}}
                <th scope="col">Status</th>
                <th scope="col">Rooms</th>
                <th scope="col">Beds</th>
                <th scope="col">Bathrooms</th>
                <th scope="col">Address</th>
                <th scope="col">Show Details</th>
              </tr>
            </thead>
          {{-- Table - body --}}
            <tbody>
              @foreach ($apartments as $apartment)
              @if ($apartment->user_id == Auth::id())
                <tr>
                  <td>
                    <img src="{{ asset('storage/' . $apartment->cover_image) }}" alt="Apartment Image" style="width: 80px; height: 50px;">
                  </td>
                  <td class="align-middle">{{strlen($apartment->name) > 25 ? substr($apartment->name, 0, 25) . '...' : $apartment->name}}</td>
                  {{-- <td>{{strlen($apartment->slug) > 40 ? substr($apartment->slug, 0, 40) . '...' : $apartment->slug}}</td> --}}
                  <td class="align-middle">
                    <div class="d-flex align-items-center">
                      <div class="check {{$apartment->isVisible == 1 ? 'bg-success' : 'bg-danger'}}"></div>
                      <div class="px-2">{{$apartment->isVisible == 1 ? ' Listed' : ' Unlisted'}}</div>
                    </div>
                  </td>
                  <td class="align-middle">{{$apartment->rooms_number}}</td>
                  <td class="align-middle">{{$apartment->beds_number}}</td>
                  <td class="align-middle">{{$apartment->bathrooms_number}}</td>
                  <td class="align-middle">{{strlen($apartment->address) > 40 ? substr($apartment->address, 0, 40) . '...' : $apartment->address}}</td>
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
          <div class="d-flex justify-content-center m-5">
            <a class="btn btn-outline-primary" href="{{route ('admin.apartments.create')}}">Add new Apartment</a>
          </div>
    </div>
</main>    
@endsection

