<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::all();
        return view ('admin.apartments.index' , compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all();
        
        return view('admin.apartments.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $formData = $request->all();

         

        $newApartment = new Apartment();

        $newApartment->user_id = Auth::id();
        $newApartment->name = $formData['name'];
        $newApartment->description = $formData['description'];
        $newApartment->rooms_number = $formData['rooms_number'];
        $newApartment->beds_number = $formData['beds_number'];
        $newApartment->bathrooms_number = $formData['bathrooms_number'];
        $newApartment->sqm = $formData['sqm'];
        $newApartment->address = $formData['address'];
        $newApartment->latitude = $formData['latitude'];
        $newApartment->longitude = $formData['longitude'];
        $newApartment->isVisible = intval($formData['isVisible']);
        $newApartment->slug = Str::slug($formData['name'] , '-');

        if ($request->hasFile('cover_image')){

            $path = Storage::put('apartment_images' , $request->cover_image);

            $formData['cover_image'] = $path;

            $newApartment->cover_image = $formData['cover_image'];

            
        }

        


        $newApartment->save();

        if (array_key_exists('services', $formData)) {

            $newApartment->services()->attach($formData['services']);
        }


    return redirect()->route('admin.apartments.show', $newApartment);

        

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {

        

        return view('admin.apartments.show' , compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        
        $services = Service::all();

        return view('admin.apartments.edit', compact( 'services', 'apartment'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartment)
    {
        $formData = $request->all();

        $apartment->slug = Str::slug($formData['name'], '-');

        if($request->hasFile('cover_image')) {

            if($apartment->cover_image){

                Storage::delete($apartment->cover_image);
            }

            $path = Storage::put('apartment_images', $request->cover_image);

            $formData['cover_image'] = $path;


        }

        $apartment->update($formData);

        $apartment->save();


        if(array_key_exists('services', $formData)){

        $apartment->services()->sync($formData['services']);

        } else {

            $apartment->services()->detach();
        }
        
        

        return redirect()->route('admin.apartments.show', $apartment);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        if($apartment->cover_image){

            Storage::delete($apartment->cover_image);
        }

        $apartment->delete();

        return redirect()->route('admin.apartments.index');
    }

    private function validation($request){

        $formData = $request->all();



    }
}
