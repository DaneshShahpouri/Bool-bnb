<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index()
    {
        $apartments = Apartment::with('user', 'services', 'views', 'messages', 'sponsorships')->get();

        return response()->json([
            'success' => true,
            'results' => $apartments
        ]);
    }
}
