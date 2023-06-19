<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
