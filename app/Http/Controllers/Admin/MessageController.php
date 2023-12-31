<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Selezionare gli appartamenti dell'user collegato
        // $apartments = Apartment::where('user_id', Auth::id())->get();
        // $param = [];

        //pushare in un array temporaneo gli id
        // foreach ($apartments as $apartment) {
        //     array_push($param, $apartment->id);
        // }

        //prendere solo i messaggi che hanno quell'id
        // $messages = Message::where('apartment_id', $param)->get();
        // return view('admin.messages.index', compact('messages'));



        //Selezionare gli appartamenti dell'user collegato
        $apartments = Apartment::where('user_id', Auth::id())->get();

        //prendere gli id degli appartamenti
        $apartmentIds = $apartments->pluck('id')->toArray();

        //prendere solo i messaggi che hanno un id appartamento nell'array
        $messages = Message::whereIn('apartment_id', $apartmentIds)->orderBy('created_at', 'desc')->get();

        return view('admin.messages.index', compact('messages'));
    }

    //messaggi per singolo appartamento
    public function showByApartment($apartmentId)
    {
        $apartment = Apartment::where('id', $apartmentId)->where('user_id', Auth::id())->first();

        if (!$apartment) {
            abort(404);  // Not Found
        }

        $messages = Message::where('apartment_id', $apartmentId)->orderBy('created_at', 'desc')->get();

        return view('admin.messages.single', compact('messages'));
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
