<?php

namespace App\Http\Controllers\Auth;

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
     * 
     */
    public function index( $apartment_slug)
    {
        $apartment = Apartment::where('slug', $apartment_slug)->firstOrFail();
        $auth_user_id = auth()->id();

        if($apartment->user_id !=  $auth_user_id){
            abort(403);
        };

        $apartment_id = $apartment->id;
        $messages = Message::where('apartment_id', $apartment->id)->orderBy('created_at', 'DESC')->paginate(12);
        return view('auth.apartments.message.index', compact('messages','apartment_slug'));
    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * 
     */
    public function show( Message $message)
    {
        $apartment_id = $message->apartment_id;
        $apartment= Apartment::where('id', $apartment_id)->firstOrFail();
        $user_id= $apartment->user_id;
        $auth_user_id = auth()->id();

        if($apartment->user_id !=  $auth_user_id){
            abort(403);
        };
       
        return view('auth.apartments.message.show', compact('message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * 
     */
    public function edit()
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request

     */
    public function update(Request $request)
    {
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
 
     */
    public function destroy()
    {

     }
}
