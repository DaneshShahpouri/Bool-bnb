<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function prova($citta, $raggioTerraange)
    {

        if ($raggioTerraange != null) {
            $apartments = Apartment::with('user', 'services', 'views', 'messages', 'sponsorships')->where('address', 'LIKE', '%' . $citta . '%')->first();
        } else {

            $apartments = Apartment::with('user', 'services', 'views', 'messages', 'sponsorships')->where('address', 'LIKE', '%' . $citta . '%')->first();
        }

        if ($citta) {
            return response()->json([
                'success' => true,
                'results' => $apartments
            ]);
        }
    }

    public function provaci()
    {
        $lat1 = 41.890557;
        $lon1 = 12.50073;

        $lat2 = 41.88211;
        $lon2 = 12.56878;

        $distance =  $this->haversineGreatCircleDistance($lat1, $lon1, $lat2, $lon2);

        // //funzione di conversione
        // if ($lat1) {
        //     $raggioTerra = 6371e3; // metri
        //     $φ1 = $lat1 * pi() / 180; // φ, λ in radianti
        //     $φ2 = $lat2 * pi() / 180;
        //     $Δφ = ($lat2 - $lat1) * pi() / 180;
        //     $Δλ = ($lon2 - $lon1) * pi() / 180;

        //     $a = sin($Δφ / 2) * sin($Δφ / 2) +
        //         cos($φ1) * cos($φ2) *
        //         sin($Δλ / 2) * sin($Δλ / 2);
        //     $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        //     $d = $raggioTerra * $c; // in metri
        // }

        return response()->json([
            'success' => true,
            'results' => $distance
        ]);
    }


    /**
     * Calculates the great-circle distance between two points, with
     * the Haversine formula.
     * @param float $latitudeFrom Latitude of start point in [deg decimal]
     * @param float $longitudeFrom Longitude of start point in [deg decimal]
     * @param float $latitudeTo Latitude of target point in [deg decimal]
     * @param float $longitudeTo Longitude of target point in [deg decimal]
     * @param float $earthRadius Mean earth radius in [m]
     * @return float Distance between points in [m] (same as earthRadius)
     */
    function haversineGreatCircleDistance(
        $latitudeFrom,
        $longitudeFrom,
        $latitudeTo,
        $longitudeTo,
        $earthRadius = 6371000
    ) {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }
}
