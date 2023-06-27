<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function store(Request $request)
    {


        $formData = $request->all();

        Validator::make($formData, [

            'apartment_id' => 'required',
            'username' => 'required|max:100|min:3',
            'content' => 'required|max:300|min:5',
            'email' => 'required|max:100|min:5',

        ], [
            'username.required' => 'Please enter a name',
            'username.max' => 'Username must be shorter than :max characters',
            'username.min' => 'Username must be longer than :min characters',
            'content.required' => 'Please write a message',
            'content.max' => 'Content must be shorter than :max characters',
            'content.min' => 'Content must be longer than :min characters',
            'email.required' => 'Please enter a email',
            'email.max' => 'Email must be shorter than :max characters',
            'email.min' => 'Email must be longer than :min characters',

        ])->validate();


        $message = new Message();

        $message->apartment_id = $request->input('apartment_id');
        $message->username = $request->input('username');
        $message->content = $request->input('content');
        $message->email = $request->input('email');

        $message->save();

        return $request->all();
    }
}
