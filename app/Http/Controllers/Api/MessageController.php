<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $newMessage = new Message();

        $newMessage->apartment_id = $request->input('apartment_id');
        $newMessage->username = $request->input('username');
        $newMessage->content = $request->input('content');
        $newMessage->email = $request->input('email');

        $newMessage->save();

        
        return response()->json([
            'success' => true,
            'results' => $newMessage,
        ]);
    }
}
