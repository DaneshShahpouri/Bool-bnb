<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class ApartmentController extends Controller
{

    public function index()
    {
        $apartments = Apartment::with('user', 'services', 'views', 'messages', 'sponsorships')->get();

        // $user = Auth::id();

        return response()->json([
            'success' => true,
            'results' => $apartments,
            // 'user'=> $user,
        ]);
    }

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

    public function address($citta)
    {

        $apartments = Apartment::with('user', 'services', 'views', 'messages', 'sponsorships')->where('address', 'LIKE', '%' . $citta . '%')->get();


        if ($citta) {
            return response()->json([
                'success' => true,
                'results' => $apartments
            ]);
        }
    }



    public function distance($city, $lat2, $lon2)
    {
        // $lat1 = 41.89055;
        // $lon1 = 12.50073;

        // $lat2 = 41.88211;
        // $lon2 = 12.56878;
        // Geocoding
        $client = new Client();
        $geocodeResponse = $client->request('GET', 'https://api.tomtom.com/search/2/search/' . $city . '.json?countrySet=IT&key=8AyhtFuGo44d57QodNOzeOGIsIaJsEq5');

        $geocodeData = json_decode($geocodeResponse->getBody());

        $lat1 = $geocodeData->results[0]->position->lat;
        $lon1 = $geocodeData->results[0]->position->lon;


        $lat1 = 41.89055;
        $lon1 = 12.50073;

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

            return response()->json([
                'success' => true,
                'results' =>  $kilometers,
                //'geo' => $geocodeResponse
            ]);
        }
    }
}
