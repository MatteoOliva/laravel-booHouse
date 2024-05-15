<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\Apartment;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * 
     */
    public function index($apartment_id)
    {
        
        $messages = Message::where('apartment_id', $apartment_id)->orderBy('created_at', 'DESC')->get();
        return view('auth.apartments.message.index', compact('messages','apartment_id'));
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
    public function show()
    {
       
        
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
