<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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

        return view('admin.apartments.index', compact('apartments'));
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

        $this->validation($request);

        $newApartment = new Apartment();

        $newApartment->user_id = Auth::id();
        $newApartment->name = $formData['name'];
        $newApartment->description = $formData['description'];
        $newApartment->rooms_number = $formData['rooms_number'];
        $newApartment->beds_number = $formData['beds_number'];
        $newApartment->bathrooms_number = $formData['bathrooms_number'];
        $newApartment->sqm = $formData['sqm'];
        $newApartment->address = $formData['address'];
        $newApartment->isVisible = intval($formData['isVisible']);


        //controllo dello slug
        $formData['slug'] = Str::slug($formData['name']);
        $existSlug = Apartment::where('slug', $formData['slug'])->first();

        $counter = 1;
        $formDataSlug = $formData['slug'];


        while ($existSlug) {
            if (strlen($formData['slug']) >= 60) {
                substr($formData['slug'], 0, strlen($formData['slug']) - 3);
            }
            $formData['slug'] = $formDataSlug . '-' . $counter;
            $counter++;
            $existSlug = Apartment::where('slug', $formData['slug'])->first();
        };

        $newApartment->slug = $formData['slug'];

        $client = new Client();
        $res = $client->get('https://api.tomtom.com/search/2/geocode/' . urlencode($formData['address']) . '.json', [
            'query' => [
                'key' => 'qjmqFCtzdoYUrau6McZvVU6fLcLPEuAA',
            ],

            'verify' => false,
        ]);

        if ($res->getStatusCode() == 200) {
            $data = json_decode($res->getBody(), true);
            if (count($data['results']) > 0) {
                $position = $data['results'][0]['position'];
                $newApartment->latitude = $position['lat'];
                $newApartment->longitude = $position['lon'];
            } else {
                return back()->withErrors(['address' => 'Unable to find coordinates for this address.']);
            }
        } else {

            return back()->withErrors(['address' => 'Error fetching coordinates.']);
        }

        if ($request->hasFile('cover_image')) {

            $path = Storage::put('apartment_images', $request->cover_image);

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



        return view('admin.apartments.show', compact('apartment'));
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

        return view('admin.apartments.edit', compact('services', 'apartment'));
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

        if ($apartment->user_id == Auth::id()) {

            $formData = $request->all();

            $this->validation($request);

            //$apartment->slug = Str::slug($request->name);

            $client = new Client();
            $res = $client->get('https://api.tomtom.com/search/2/geocode/' . urlencode($formData['address']) . '.json', [
                'query' => [
                    'key' => 'qjmqFCtzdoYUrau6McZvVU6fLcLPEuAA',
                ],

                'verify' => false,
            ]);

            if ($res->getStatusCode() == 200) {
                $data = json_decode($res->getBody(), true);
                if (count($data['results']) > 0) {
                    $position = $data['results'][0]['position'];
                    $apartment->latitude = $position['lat'];
                    $apartment->longitude = $position['lon'];
                } else {
                    return back()->withErrors(['address' => 'Unable to find coordinates for this address.']);
                }
            } else {

                return back()->withErrors(['address' => 'Error fetching coordinates.']);
            }

            if ($request->hasFile('cover_image')) {

                if ($apartment->cover_image) {

                    Storage::delete($apartment->cover_image);
                }

                $path = Storage::put('apartment_images', $request->cover_image);

                $formData['cover_image'] = $path;
            }

           
            $titleOld = $apartment->name;
            // verifica se è stato modificato il titolo e in caso viene aggiornato lo slug
            if ($titleOld != $formData['name']) {
                // crea uno slug dal titolo e e lo ricerca nel db per controllare che non esiste, in caso esiste la variabile $existSlug ritorna un true e attiva il ciclo while
                $formData['slug'] = Str::slug($formData['name']);
                $existSlug = Apartment::where('slug', $formData['slug'])->first();

                $counter = 1;
                $dataSlug = $formData['slug'];

                // questa funzione controlla se lo slag esiste già nel database, e in caso esista con questo ciclo while li viene inserito un numero di continuazione 
                while ($existSlug) {
                    if (strlen($formData['slug']) >= 60) {
                        substr($formData['slug'], 0, strlen($formData['slug']) - 3);
                    }
                    $formData['slug'] = $dataSlug . '-' . $counter;
                    $counter++;
                    $existSlug = Apartment::where('slug', $formData['slug'])->first();
                }
            } else {
                $formData['slug'] = $apartment->slug;
            } // fine creazione slug

            $apartment->update($formData);

            $apartment->save();



            if (array_key_exists('services', $formData)) {

                $apartment->services()->sync($formData['services']);
            } else {

                $apartment->services()->detach();
            }

            return redirect()->route('admin.apartments.show', $apartment);
        } else {
            return redirect()->route('admin.apartments.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        if ($apartment->cover_image) {

            Storage::delete($apartment->cover_image);
        }

        $apartment->delete();

        return redirect()->route('admin.apartments.index');
    }

    private function validation($request)
    {

        $formData = $request->all();

        $rules = [

            'name' => 'required|max:255|min:5',
            'description' => 'required|max:800|min:10',
            // 'cover_image' => 'required|image|max:4096',
            'isVisible' => 'required',
            'address' => 'required|max:100|min:7',
            'rooms_number' => 'required|numeric|min:1|max:30',
            'beds_number' => 'required|numeric|min:1|max:60',
            'bathrooms_number' => 'required|numeric|min:1|max:20',
            'sqm' => 'required|numeric|min:10|max:5000',
            'services' => 'required|exists:services,id'
        ];

        if ($request->isMethod('post')) {
            $rules['cover_image'] = 'required|image|max:4096';
        } elseif ($request->isMethod('put') || $request->isMethod('patch')) {
            $rules['cover_image'] = 'nullable|image|max:4096';
        }

        $validator = Validator::make(
            $formData,
            $rules,
            [
                'name.required' => 'Please enter an apartment name',
                'name.max' => 'Name must be shorter than :max characters',
                'name.min' => 'Name must be longer than :min characters',

                'description.required' => 'Description required',
                'description.max' => 'Description must be shorter than :max characters',
                'description.min' => 'Description must be longer than :min characters',

                'cover_image.required' => "Please upload an image",
                'cover_image.max' => "The image size should not exceed :max kb",
                'cover_image.image' => "Please upload an image file",

                'isVisible.required' => 'Visibility field required',

                'address.required' => 'Please enter an address',
                'address.min' => 'Address must be longer than :min characters',
                'address.max' => 'Address must be shorter than :max characters',

                'rooms_number.required' => 'Please enter the number of rooms',
                'rooms_number.numeric' => 'This field must contain a numeric value',
                'rooms_number.min' => 'The number of rooms must be at least :min',
                'rooms_number.max' => 'The number of rooms must not exceed :max',

                'beds_number.required' => 'Please enter the number of beds',
                'beds_number.numeric' => 'This field must contain a numeric value',
                'beds_number.min' => 'The number of beds must be at least :min',
                'beds_number.max' => 'The number of beds must not exceed :max',

                'bathrooms_number.required' => 'Please enter the number of bathrooms',
                'bathrooms_number.numeric' => 'This field must contain a numeric value',
                'bathrooms_number.min' => 'The number of bathrooms must be at least :min',
                'bathrooms_number.max' => 'The number of bathrooms must not exceed :max',

                'sqm.required' => 'Please enter the apartment size in square meters',
                'sqm.numeric' => 'This field must contain a numeric value',
                'sqm.min' => 'The square meters value must be at least :min',
                'sqm.max' => 'The square meters value must not exceed :max',

                'services.exists' => 'Choose among one of the available amenities',
                'services.required' => 'Please select at least one amenity',

            ]
        )->validate();

        return $validator;
    }
}
