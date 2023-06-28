<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {

        $apartments = [];
        $user = Auth::user();
        $userApartments = Apartment::all()
            ->where('user_id', '=', $user->id)
            ->sortBy('created_at', SORT_REGULAR, true);

        foreach ($userApartments as $apartment) {
            array_push($apartments, $apartment);
        }


        return view('admin.dashboard', compact('user', 'apartments'));
    }
}
