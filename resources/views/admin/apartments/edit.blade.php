@extends('layouts/admin')

@section('content')

<main class="apartment_edit">

    @if($apartment->user_id == Auth::id())

    <div class="container">

        <h1 class="my-4">Edit Apartment : <em>{{$apartment->name}}</em></h1>

        <form action="{{route ('admin.apartments.update', $apartment)}}" autocomplete="off" method="POST" enctype="multipart/form-data" onsubmit="return validateServicesUpdate()" id="edit-form">
            @csrf
            @method('PUT')

              {{-- input per evitare autocomplete di chrome --}}
              <input autocomplete="false" name="hidden" type="text" style="display:none;">

            {{-- name --}}
            <div class="mb-3">
                <label for="name" class="mb-2">Listing Title*</label>
                <input class="form-control my-label @error('name') is-invalid @enderror" type="text" name="name" id="name" placeholder="Enter apartment name" value="{{old('name') ?? $apartment->name}}" required minlength="5" maxlength="255">
                @error('name')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            {{-- description --}}
            <div class="mb-3">
                <label for="description" class="mb-2">Listing Description*</label>
                <textarea class="form-control my-label @error('description') is-invalid @enderror" name="description" id="description" cols="30" rows="10" placeholder="Enter apartment description" required minlength="10" maxlength="800">{{old('description') ?? $apartment->description}}</textarea>
                @error('description')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            {{-- cover-image --}}
            <div class="mb-4">
                <label for="cover_image" class="mb-2">Apartment Photo</label>
                <input type="file" id="cover_image" name="cover_image" class="form-control @error('cover_image') is-invalid @enderror">
                <div class="text-danger" id="error-image"></div>
                @error('cover_image')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror   
            </div>

            {{-- is visible --}}
            <div class="mb-4">
                <label for="isVisible">Visibility :</label>
                <select name="isVisible" id="isVisible" class="w-20" required>
                    <option value=1 @if(old('isVisible', $apartment->isVisible) == 1) selected @endif>Show Listing</option>
                    <option value=0 @if(old('isVisible', $apartment->isVisible) == 0) selected @endif>Hide Listing</option>
                </select>
            </div>

            {{-- services --}}
            <div class="mb-3 form-group _services">
                <div class="text-uppercase fw-bold my-3">Select Amenities*:</div>
                <div class="d-flex flex-wrap gap-3 justify-content-sm-start justify-content-center">
                    @foreach ($services as $service)  
                    <div class="form-check">
                        
                        @if($errors->any())
                        <input type="checkbox" id="tag-{{$service->id}}" name="services[]" value="{{$service->id}}" @checked(in_array($apartment->id, old('services', [])))>
                            @else
                            <input class="update-services" type="checkbox" id="tag-{{$service->id}}" name="services[]" value="{{$service->id}}" @checked($apartment->services->contains($service))>
                            @endif
                            
                            <label for="tag-{{$service->id}}" class="mb-2">
                                <span class="_icon d-md-none d-block ms-1">{!!$service->icon!!}</span>
                                <span class="_name d-none d-md-inline">{{$service->name}}</span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <div class="text-danger" id="messageServicesUpdate"></div>

                @error('services')
                <div class="text-danger">
                    {{$message}}
                </div>
                @enderror 

            </div>

            {{-- address --}}
            <div class="mb-3 _address-wrapper">
                <label for="address" class="mb-2">Address*</label>
                <input class="form-control my-label @error('address') is-invalid @enderror" type="text" name="address" id="addressCreateEdit" placeholder="Enter apartment address" value="{{old('address') ?? $apartment->address}}" required minlength="7" maxlength="100">
                <div id="messageAddressEdit" class="text-danger"></div>
                <ul id="edit-suggest"></ul>
                @error('address')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            {{-- rooms-number --}}
            <div class="mb-3">
                <label for="rooms_number" class="mb-2">Rooms*</label>
                <input class=" form-control my-label @error('rooms_number') is-invalid @enderror" type="number" name="rooms_number" id="rooms_number" placeholder="Enter total rooms" value="{{old('rooms_number') ?? $apartment->rooms_number}}" required min="1" max="30">
                @error('rooms_number')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            {{-- beds-number --}}
            <div class="mb-3">
                <label for="beds_number" class="mb-2">Beds*</label>
                <input class="form-control my-label @error('beds_number') is-invalid @enderror" type="number" name="beds_number" id="beds_number" placeholder="Enter total beds" value="{{old('beds_number') ?? $apartment->beds_number}}" required min="1" max="60">
                @error('beds_number')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            {{-- bathrooms-number --}}
            <div class="mb-1">
                <label for="bathrooms_number" class="mb-2">Bathrooms*</label>
                <input class="form-control my-label @error('bathrooms_number') is-invalid @enderror" type="number" name="bathrooms_number" id="bathrooms_number" placeholder="Enter total bathrooms" value="{{old('bathrooms_number') ?? $apartment->bathrooms_number}}" required min="1" max="20"> 
                @error('bathrooms_number')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            {{-- sqm --}}
            <div class="mb-3">
                <label for="sqm" class="mb-2">Area (sqm)* </label>
                <input class="form-control my-label @error('sqm') is-invalid @enderror" type="number" name="sqm" id="sqm" placeholder="Enter apartment square meters" value="{{old('sqm') ?? $apartment->sqm}}" required min="10" max="5000">
                @error('sqm')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>
    
            {{-- submit --}}
            <button type="submit" class="btn btn-primary my-2 text-light">Edit apartment</button>

        </form>
    </div>

    {{-- Se l'utente prova a modificare un appartamento non suo --}}
    @else
    <div class="container my-5 d-flex flex-column justify-content-center align-items-center">
        <div class="alert alert-danger w-100" role="alert">
            401 Unauthorized: You don't have access to this section.
        </div>

        <a class="btn btn-primary" href="{{route('admin.apartments.index')}}">Go back to your apartments</a>
    </div>
    @endif
</main>
    
<script type="text/javascript">
    let  isValidAddressEdit = true;
    //console.log(isValidAddressEdit)
  let messageAddressEdit = document.getElementById('messageAddressEdit')
    function validateServicesUpdate() {
        let services = document.querySelectorAll('input[type="checkbox"][class="update-services"]');
        let isChecked = Array.from(services).some(checkbox => checkbox.checked);
        let message = document.getElementById('messageServicesUpdate')
        message.innerText='';
        messageAddressEdit.innerText='';


        if (!isChecked) {
            message.innerText='Please select at least one service.';
            return false;
        }else if(!isValidAddressEdit){
                messageAddressEdit.innerText='Please select a valid address.';
                return false
            }

        return true;
    }

    document.getElementById('edit-form').addEventListener('submit', function( evt ) {
    let file = document.getElementById('cover_image').files[0];
    let error = document.getElementById('error-image');
    error.innerText=''
    // var regex = /^(image/)(gif|(x-)?png|p?jpeg)$/i;
    if( file?.size >= (1048576 * 2)) { // 1MB
        error.innerText='File size must not exceed 2Mb'
        evt.preventDefault();
    } 
}, false);
</script>
@endsection