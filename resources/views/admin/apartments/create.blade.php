@extends('layouts/admin')

@section('content')

<main id="apartment_create">

    <div class="container">

        <h1 class="my-4">Add new Aparment</h1>
        
        <form action="{{route ('admin.apartments.store')}}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- name --}}
            <div class="mb-3">
                <label for="name" class="mb-2">Listing Title*</label>
                <input class="form-control my-label @error('name') is-invalid @enderror" type="text" name="name" id="name" placeholder="Enter apartment name" required minlength="5" maxlength="255" value='{{old('name')}}'>
                @error('name')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            {{-- description --}}
            <div class="mb-3">
                <label for="description" class="mb-2">Listing Description*</label>
                <textarea class="form-control my-label @error('description') is-invalid @enderror" name="description" id="description" cols="30" rows="10" placeholder="Enter apartment description" required minlength="10" maxlength="800">{{old('description')}}</textarea>
                @error('description')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            {{-- cover-image --}}
            <div class="mb-3">
                <label for="cover_image" class="mb-2">Apartment Photo*</label>
                <input type="file" id="cover_image" name="cover_image" class="form-control my-label @error('cover_image') is-invalid @enderror" required>
                @error('cover_image')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror 
            </div>

            {{-- is visible --}}
            <div class="mb-3">
                <label for="isVisible">Visibility :</label>
                <select name="isVisible" id="isVisible" class="w-20" required>
                    <option value=1 {{ old('isVisible') == '1' ? 'selected' : '' }}>Show Listing</option>
                    <option value=0 {{ old('isVisible') == '0' ? 'selected' : '' }}>Hide Listing</option>
                </select>
            </div>

            {{-- services --}}
            <div class="mb-3 form-group">
                <div class="text-uppercase fw-bold mb-2">Select Amenities*:</div>
                <div class="d-flex">
                    @foreach ($services as $service)
                        <div class="form-check">
                            <input type="checkbox" id="tag-{{$service->id}}" name="services[]" value="{{$service->id}}" @checked(in_array($service->id, old('services', [])))>
                            <label for="tag-{{$service->id}}" class="mb-2">{{$service->name}}</label>
                        </div>
                    @endforeach
                </div>

                @error('services')
                <div class="text-danger">
                    {{$message}}
                </div>
                @enderror 
            </div>

            {{-- address --}}
            <div class="mb-3">
                <label for="address" class="mb-2">Address*</label>
                <input class="form-control my-label @error('address') is-invalid @enderror" placeholder="es: via prova, 00 city" type="text" name="address" id="address" placeholder="Enter apartment address" required minlength="7" maxlength="100" value='{{old('address')}}'>
                @error('address')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            {{-- rooms-number --}}
            <div class="mb-3">
                <label for="rooms_number" class="mb-2">Rooms*</label>
                <input class="form-control my-label @error('rooms_number') is-invalid @enderror" type="number" name="rooms_number" id="rooms_number" placeholder="Enter total rooms" required min="1" max="30" value='{{old('rooms_number')}}'>
                @error('rooms_number')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            {{-- beds-number --}}
            <div class="mb-3">
                <label for="beds_number" class="mb-2">Beds*</label>
                <input class="form-control my-label @error('beds_number') is-invalid @enderror" type="number" name="beds_number" id="beds_number" placeholder="Enter total beds" required min="1" max="60" value='{{old('beds_number')}}'>
                @error('beds_number')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            {{-- bathrooms-number --}}
            <div class="mb-1">
                <label for="bathrooms_number" class="mb-2">Bathrooms*</label>
                <input class="form-control my-label @error('bathrooms_number') is-invalid @enderror" type="number" name="bathrooms_number" id="bathrooms_number" placeholder="Enter total bathrooms" required min="1" max="20" value='{{old('bathrooms_number')}}'>
                @error('bathrooms_number')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            {{-- sqm --}}
            <div class="mb-3">
                <label for="sqm" class="mb-2">Area (sqm) *</label>
                <input class="form-control my-label @error('sqm') is-invalid @enderror" type="number" name="sqm" id="sqm" placeholder="Enter apartment square meters" required min="10" max="5000" value='{{old('sqm')}}'>
                @error('sqm')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            {{-- submit --}}
            <button type="submit" class="btn btn-primary my-2">Add apartment</button>
        </form>

    </div>

</main>


    
@endsection