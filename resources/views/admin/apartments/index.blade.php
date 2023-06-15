@extends('layouts/admin')

@section('content')

<main id="apartment_index">
    <div class="container">
      <table class="table my-3">
          {{-- Table - head --}}
            <thead>
              <tr>
                <th scope="col">Listing</th>
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
                  <td>{{strlen($apartment->name) > 40 ? substr($apartment->name, 0, 40) . '...' : $apartment->name}}</td>
                  <td class="d-flex align-items-center">
                    <div class="check {{$apartment->isVisible == 1 ? 'bg-success' : 'bg-danger'}}"></div>
                    <div class="px-2">{{$apartment->isVisible == 1 ? ' Listed' : ' Unlisted'}}</div>
                  </td>
                  <td>{{$apartment->rooms_number}}</td>
                  <td>{{$apartment->beds_number}}</td>
                  <td>{{$apartment->bathrooms_number}}</td>
                  <td>{{strlen($apartment->address) > 40 ? substr($apartment->address, 0, 40) . '...' : $apartment->address}}</td>
                  <td><a href="{{route ('admin.apartments.show' , $apartment->slug)}}"><i class="fa-solid fa-magnifying-glass"></i></a></td>
                </tr>
              @endif
              @endforeach
            </tbody>
          </table>
      <a href="{{route ('admin.apartments.create')}}">Aggiungi nuovo appartamento</a>
    </div>
</main>    
@endsection
