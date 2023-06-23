<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser(Request $request)
    {
        // Recupera l'ID dell'utente registrato dal database
        $userId = User::find($request->user()->id)->id;

        // Restituisci l'ID dell'utente come risposta JSON
        return response()->json(['user_id' => $userId]);
    }
}
