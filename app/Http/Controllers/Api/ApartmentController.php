<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class ApartmentController extends Controller
{

    public function index()
    {
        // $apartments = Apartment::with('user', 'services', 'views', 'messages', 'sponsorships')
        //     ->where('isVisible', '=', 1)
        //     ->orderBy('created_at', 'desc')
        //     ->get();

        // $user = Auth::id();

        $sponsorships = Sponsorship::all();
        $apartments = [];
        $currentDateTime = \Carbon\Carbon::now();
        $sponsoredApartments = Apartment::with(['user', 'services', 'views', 'messages', 'sponsorships' => function ($query) use ($currentDateTime) {
            $query->where('start_date', '<=', $currentDateTime);
        }])
            ->where('isVisible', '=', 1)
            ->has('sponsorships')
            ->orderBy('created_at', 'desc')
            ->get();


        // foreach ($sponsoredApartments as $apartment) {
        //     if (count($apartment->sponsorships) > 0) {
        //         //$startDate = $sponsorships->pivot->start_date;

        //         if ($currentDateTime->subHours($apartment->sponsorships[0]->duration) <= $apartment->sponsorships[0]->pivot['start_date']) {
        //             array_push($apartments, $apartment);
        //         }
        //     }
        // }


        //appartamenti non sponsorizzati

        $apartments = Apartment::with(['user', 'services', 'views', 'messages', 'sponsorships'])
            ->where('isVisible', '=', 1)
            ->doesntHave('sponsorships')
            ->orderBy('created_at', 'desc')
            ->get();

        // foreach ($tempApartments as $apartmentTemp) {
        //     if (count($apartmentTemp->sponsorships) == 0) {
        //         array_push($apartments, $apartmentTemp);
        //     }
        // };



        return response()->json([
            'success' => true,
            'results' => $apartments,
            'sponsorRes' => $sponsoredApartments

            // 'user'=> $user,
        ]);
    }

    //obsoleta
    public function search(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $address = $request->input('address');


        // Geocoding
        $geocodeResponse = $client->request('GET', 'https://api.tomtom.com/search/2/geocode/' . $address . '.json', [
            'query' => [
                'key' => '8AyhtFuGo44d57QodNOzeOGIsIaJsEq5',
            ]
        ]);

        $geocodeData = json_decode($geocodeResponse->getBody());
        $lat = $geocodeData->results[0]->position->lat;
        $lon = $geocodeData->results[0]->position->lon;

        // Ricerca appartamenti nel raggio di 20 km
        $earth_radius = 6371;
        $max_distance = $request->input('radius');

        $apartments = DB::table('apartments')
            ->select(DB::raw(", ({$earth_radius} acos(cos(radians({$lat}))
            
            cos(radians(latitude))
            cos(radians(longitude) - radians({$lon}))
            + sin(radians({$lat}))
            
            sin(radians(latitude)))) AS distance"))->havingRaw("distance < {$max_distance}")->orderBy('distance', 'asc')->get();

        return response()->json([
            'success' => true,
            'results' => $apartments,
            // 'user'=> $user,
        ]);
    }

    public function services()
    {
        $services = Service::all();

        // $user = Auth::id();

        return response()->json([
            'success' => true,
            'results' => $services,
            // 'user'=> $user,
        ]);
    }

    public function show($slug)
    {
        $apartments = Apartment::with('user', 'services', 'views', 'messages', 'sponsorships')->where('slug', $slug)->first();

        if ($apartments) {
            return response()->json([
                'success' => true,
                'results' => $apartments
            ]);
        } else {
            return response()->json([
                'success' => false,
                'results' => 'Sorry'
            ]);
        }
    }

    public function name($name)
    {
        $apartments = [];
        if ($name) {
            $sponsoredapartments = Apartment::with('user', 'services', 'views', 'messages', 'sponsorships')
                ->where('isVisible', '=', 1)
                ->has('sponsorships')
                ->where('address', 'LIKE', '%' . $name . '%')
                ->where('isVisible', '=', 1)
                ->has('sponsorships')
                ->orderBy('created_at', 'desc')
                ->orWhere('name', 'LIKE', '%' . $name . '%')
                ->has('sponsorships')
                ->where('isVisible', '=', 1)
                ->has('sponsorships')
                ->orderBy('created_at', 'desc')
                ->get();

            foreach ($sponsoredapartments as $apartment) {
                array_push($apartments, $apartment);
            }

            $Unsponsoredapartments = Apartment::with('user', 'services', 'views', 'messages', 'sponsorships')
                ->where('isVisible', '=', 1)
                ->where('address', 'LIKE', '%' . $name . '%')
                ->doesntHave('sponsorships')
                ->where('isVisible', '=', 1)
                ->orderBy('created_at', 'desc')
                ->orWhere('name', 'LIKE', '%' . $name . '%')
                ->where('isVisible', '=', 1)
                ->doesntHave('sponsorships')
                ->where('isVisible', '=', 1)
                ->orderBy('created_at', 'desc')
                ->get();

            foreach ($Unsponsoredapartments as $apartment) {
                array_push($apartments, $apartment);
            }


            return response()->json([
                'success' => true,
                'results' => $apartments
            ]);
        } else {
            $sponsoredapartments = Apartment::with('user', 'services', 'views', 'messages', 'sponsorships')
                ->where('isVisible', '=', 1)
                ->has('sponsorships')
                ->orderBy('created_at', 'desc')
                ->get();

            foreach ($sponsoredapartments as $apartment) {
                array_push($apartments, $apartment);
            }

            $Unsponsoredapartments = Apartment::with('user', 'services', 'views', 'messages', 'sponsorships')
                ->where('isVisible', '=', 1)
                ->has('sponsorships')
                ->orderBy('created_at', 'desc')
                ->get();

            foreach ($Unsponsoredapartments as $apartment) {
                array_push($apartments, $apartment);
            }


            return response()->json([
                'success' => true,
                'results' => $apartments
            ]);
        }
    }

    public function distance($lat1, $lon1, $lat2, $lon2)
    {

        // Geocoding
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $lat1Rad = deg2rad($lat1);
            $lon1Rad = deg2rad($lon1);
            $lat2Rad = deg2rad($lat2);
            $lon2Rad = deg2rad($lon2);

            $deltaLon = $lon2Rad - $lon1Rad;

            $distance = acos(sin($lat1Rad) * sin($lat2Rad) + cos($lat1Rad) * cos($lat2Rad) * cos($deltaLon));
            $distance = rad2deg($distance);
            $kilometers = $distance * 111.13384; // Raggio medio della Terra in chilometri

            return  $kilometers;
        }
    }

    public function getApartmentByCity($lat, $lon, $radius, $rooms = null, $beds = null, $bath = null, $services = null)
    {

        if (!$rooms) {
            $rooms = 0;
        }
        if (!$beds) {
            $beds = 0;
        }
        if (!$bath) {
            $bath = 0;
        }
        if (!$services) {
            $services = '';
        } else {

            $tempAmenities = explode(',',  $services);
            $amenities = array_map(function ($value) {
                return intval($value); // o (float)$value per convertire in numeri decimali
            }, $tempAmenities);
        }

        $newApartments = [];

        $apartments = Apartment::with('user', 'services', 'views', 'messages', 'sponsorships')
            ->where('rooms_number', '>=', $rooms)
            ->where('beds_number', '>=', $beds)
            ->where('bathrooms_number', '>=', $bath)
            ->where('isVisible', '=', 1)
            ->has('sponsorships')
            ->orderBy('created_at', 'desc')
            ->get();


        $apartment_distance = [];
        // Aggiungi il ciclo per calcolare la distanza
        foreach ($apartments as $apartment) {
            $apartment->distance = $this->distance(floatval($apartment->latitude), floatval($apartment->longitude), floatval($lat), floatval($lon));
            array_push($apartment_distance, $apartment);
        }

        // Ordina gli appartamenti in base alla distanza
        usort($apartment_distance, function ($a, $b) {
            return $a->distance - $b->distance;
        });


        foreach ($apartment_distance as $apartment) {
            if ($this->distance(floatval($apartment->latitude), floatval($apartment->longitude), floatval($lat), floatval($lon)) < intval($radius)) {
                if ($services != '') {
                    // Controlla se gli amenities dell'appartamento corrispondono a tutti gli ID selezionati
                    $apartmentAmenities = $apartment->services()->pluck('id')->toArray();
                    if (count(array_diff($amenities, $apartmentAmenities)) == 0) {
                        array_push($newApartments, $apartment);
                    }
                } else {
                    array_push($newApartments, $apartment);
                }
            }
        }

        $UnSponsorapartments = Apartment::with('user', 'services', 'views', 'messages', 'sponsorships')
            ->where('rooms_number', '>=', $rooms)
            ->where('beds_number', '>=', $beds)
            ->where('bathrooms_number', '>=', $bath)
            ->where('isVisible', '=', 1)
            ->doesntHave('sponsorships')
            ->orderBy('created_at', 'desc')
            ->get();

        $Unsoponsoreapartment_distance = [];
        // Aggiungi il ciclo per calcolare la distanza
        foreach ($UnSponsorapartments as $apartment) {
            $apartment->distance = $this->distance(floatval($apartment->latitude), floatval($apartment->longitude), floatval($lat), floatval($lon));
            array_push($Unsoponsoreapartment_distance, $apartment);
        }

        // Ordina gli appartamenti in base alla distanza
        usort($Unsoponsoreapartment_distance, function ($a, $b) {
            return $a->distance - $b->distance;
        });

        foreach ($Unsoponsoreapartment_distance as $apartment) {
            if ($this->distance(floatval($apartment->latitude), floatval($apartment->longitude), floatval($lat), floatval($lon)) < intval($radius)) {
                if ($services != '') {
                    // Controlla se gli amenities dell'appartamento corrispondono a tutti gli ID selezionati
                    $apartmentAmenities = $apartment->services()->pluck('id')->toArray();
                    if (count(array_diff($amenities, $apartmentAmenities)) == 0) {
                        array_push($newApartments, $apartment);
                    }
                } else {
                    array_push($newApartments, $apartment);
                }
            }
        }


        return response()->json([
            'success' => true,
            'results' => $newApartments
        ]);
    }

    public function getApartmentByCityEmptyName($rooms = null, $beds = null, $bath = null, $services = null)
    {

        if (!$rooms) {
            $rooms = 0;
        }
        if (!$beds) {
            $beds = 0;
        }
        if (!$bath) {
            $bath = 0;
        }
        if (!$services) {
            $services = '';
        }
        if ($services) {
            $tempAmenities = explode(',',  $services);
            $amenities = array_map(function ($value) {
                return intval($value); // o (float)$value per convertire in numeri decimali
            }, $tempAmenities);
        }

        $apartments = Apartment::with('user', 'services', 'views', 'messages', 'sponsorships')
            ->where('rooms_number', '>=', $rooms)
            ->where('beds_number', '>=', $beds)
            ->where('bathrooms_number', '>=', $bath)
            ->where('isVisible', '=', 1)
            ->has('sponsorships')
            ->orderBy('created_at', 'desc')
            ->get();

        $newApartments = [];

        foreach ($apartments as $apartment) {
            if ($services != '') {
                // Controlla se gli amenities dell'appartamento corrispondono a tutti gli ID selezionati
                $apartmentAmenities = $apartment->services()->pluck('id')->toArray();
                if (count(array_diff($amenities, $apartmentAmenities)) == 0) {
                    array_push($newApartments, $apartment);
                }
            } else {
                array_push($newApartments, $apartment);
            }
        }

        $UnSponsorapartments = Apartment::with('user', 'services', 'views', 'messages', 'sponsorships')
            ->where('rooms_number', '>=', $rooms)
            ->where('beds_number', '>=', $beds)
            ->where('bathrooms_number', '>=', $bath)
            ->where('isVisible', '=', 1)
            ->doesntHave('sponsorships')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($UnSponsorapartments as $apartment) {
            if ($services != '') {
                // Controlla se gli amenities dell'appartamento corrispondono a tutti gli ID selezionati
                $apartmentAmenities = $apartment->services()->pluck('id')->toArray();
                if (count(array_diff($amenities, $apartmentAmenities)) == 0) {
                    array_push($newApartments, $apartment);
                }
            } else {
                array_push($newApartments, $apartment);
            }
        }

        return response()->json([
            'success' => true,
            'results' => $newApartments
        ]);
    }
}
