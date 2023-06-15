@extends('layouts/admin')

@section('content')

<main class="apartment_edit">

    <div class="container">

        <h1 class="my-4">Edit Apartment : <em>{{$apartment->name}}</em></h1>

        <form action="{{route ('admin.apartments.update', $apartment)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="mb-2">Listing Title</label>
                <input class="form-control my-label @error('name') is-invalid @enderror" type="text" name="name" id="name" placeholder="Enter apartment name" value="{{old('name') ?? $apartment->name}}">
                @error('name')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="mb-2">Listing Description</label>
                <textarea class="form-control my-label @error('description') is-invalid @enderror" name="description" id="description" cols="30" rows="10" placeholder="Enter apartment description">{{old('description') ?? $apartment->description}}</textarea>
                @error('description')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="cover_image" class="mb-2">Apartment Photo</label>
                <input type="file" id="cover_image" name="cover_image" class="form-control @error('cover_image') is-invalid @enderror">
                @error('cover_image')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
                    
            </div>

              <div class="mb-3">
                <label for="isVisible">Visibility :</label>
                <select name="isVisible" id="isVisible" class="w-20" @checked($apartment->services->contains)>
                    <option value=1>Show Listing</option>
                    <option value=0>Hide Listing</option>
                </select>
            </div>

            <div class="mb-3 form-group">
                <div class="text-uppercase fw-bold mb-2">Select Amenities:</div>
    
                <div class="d-flex">

                    @foreach ($services as $service)
                      
                        <div class="form-check">
                            <input type="checkbox" id="tag-{{$service->id}}" name="services[]" value="{{$service->id}}" @checked($apartment->services->contains($service))>
                            <label for="tag-{{$service->id}}" class="mb-2">{{$service->name}}</label>
                        </div>
                   
                    @endforeach
                </div>
            
            </div>

            <div class="mb-3">
                <label for="address" class="mb-2">Address</label>
                <input class="form-control my-label @error('address') is-invalid @enderror" type="text" name="address" id="address" placeholder="Enter apartment address" value="{{old('address') ?? $apartment->address}}">
                @error('address')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="rooms_number" class="mb-2">Rooms</label>
                <input class="form-control my-label @error('rooms_number') is-invalid @enderror" type="number" name="rooms_number" id="rooms_number" placeholder="Enter total rooms" value="{{old('rooms_number') ?? $apartment->rooms_number}}">
                @error('rooms_number')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="beds_number" class="mb-2">Beds</label>
                <input class="form-control my-label @error('beds_number') is-invalid @enderror" type="number" name="beds_number" id="beds_number" placeholder="Enter total beds" value="{{old('beds_number') ?? $apartment->beds_number}}">
                @error('beds_number')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            <div class="mb-1">
                <label for="bathrooms_number" class="mb-2">Bathrooms</label>
                <input class="form-control my-label @error('bathrooms_number') is-invalid @enderror" type="number" name="bathrooms_number" id="bathrooms_number" placeholder="Enter total bathrooms" value="{{old('bathrooms_number') ?? $apartment->bathrooms_number}}">
                @error('bathrooms_number')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="sqm" class="mb-2">Area (sqm) </label>
                <input class="form-control my-label @error('sqm') is-invalid @enderror" type="number" name="sqm" id="sqm" placeholder="Enter apartment square meters" value="{{old('sqm') ?? $apartment->sqm}}">
                @error('sqm')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>
    
            <button type="submit" class="btn btn-primary my-2 text-light">Edit apartment</button>

        </form>
    </div>
</main>
    
@endsection