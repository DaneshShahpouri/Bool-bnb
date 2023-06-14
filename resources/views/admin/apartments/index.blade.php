@extends('layouts/admin')

@section('content')





<main id="apartments_index">

    <div class="container">
       
        <table class="table my-3">
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
            <tbody>
              
                  
             
                @foreach ($apartments as $apartment)

                @if ($apartment->user_id == Auth::id())

                    <tr>
                        <td>{{$apartment->name}}</td>
                        <td><i class="{{$apartment->isVisible == 1 ? 'fa-regular fa-eye' : 'fa-regular fa-eye-slash'}}"></i> {{$apartment->isVisible == 1 ? 'Listed' : 'Unlisted'}} </td>
                       
                        <td>{{$apartment->rooms_number}}</td>
                        <td>{{$apartment->beds_number}}</td>
                        <td>{{$apartment->bathrooms_number}}</td>
                        <td>{{$apartment->address}}</td>
                        <td><a href="{{route ('admin.apartments.show' , $apartment->slug)}}"><i class="fa-solid fa-magnifying-glass"></i></a></td>
                    </tr>
                
                    
                @endif
                    
                @endforeach

              
              
            </tbody>
          </table>

    </div>

</main>
    
@endsection
