<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUser()
    {
        // Recupera l'ID dell'utente registrato dal database
        $userId = auth()->user()->id;

        // Restituisci l'ID dell'utente come risposta JSON
        return response()->json(['user_id' => $userId]);
    }
}
