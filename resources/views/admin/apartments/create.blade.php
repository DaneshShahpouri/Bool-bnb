@extends('layouts/admin')

@section('content')



<main id="apartment_create">

    <div class="container">
        
        <form action="{{route ('admin.apartments.store')}}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- <div class="mb-3">
                <label for="services">Name</label>
                <select class="form-control @error('name') is-invalid @enderror" type="text" name="services" id="name" placeholder="">
                    <option value="">Undefined</option>
    
                    @foreach ($types as $type)
                        <option value="{{$type->id}}" {{$type->id == old('name') ? 'selected' : ''}}>{{$type->name}}</option>
                    @endforeach
                </select>
    
                @error('type_id')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div> --}}

            <div class="mb-3">
                <label for="apartment_name"></label>
                <input class="form-control @error('apartment_name') is-invalid @enderror" type="text" name="apartment_name" id="apartment_name" placeholder="Inserisci il nome del progetto">
                @error('apartment_name')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="apartment_description"></label>
                <textarea class="form-control @error('apartment_description') is-invalid @enderror" name="apartment_description" id="apartment_description" cols="30" rows="10" placeholder="inserisci la descrizione del progetto"></textarea>
                @error('apartment_description')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" value="1" checked name="isVisible">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" value="0" checked>
                <label class="form-check-label" for="flexSwitchCheckDefault" id="prova">Visible</label>
            </div>
    
            <button type="submit">Crea</button>

        </form>

    </div>

</main>

<script>

   let prova = document.getElementById('prova')

   console.log(prova)

   

</script>
    
@endsection