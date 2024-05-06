<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth_user_id = auth()->id();
        $apartments = Apartment::where('user_id', $auth_user_id)->get();

        // var_dump($apartments);
        return view('auth.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // get all services for the db
        $services = Service::all();
        return view('auth.apartments.form', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // get all data from the request
        $data = $request->all();

        // create a new apartment and fill it with the data from the request
        $apartment = new Apartment;
        $apartment->fill($data);
        // get the id of the user and add it to the aprtment
        $auth_user_id = auth()->id();
        $apartment->user_id = $auth_user_id;
        // set the visibility to false
        $apartment->visible = false;

        // get all the slugs from the db
        $existing_slugs = Apartment::all()->pluck('slug')->toArray();
        // dd($existing_slugs);

        // add the slug to the apartment and save the apartment in the db
        $apartment->slug = $apartment->create_unique_slug($existing_slugs);
        $apartment->save();

        return redirect()->route('user.apartments.show', $apartment);
        // dd($apartment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        // var_dump($apartment->services->pluck('id')->toArray());
        $related_services = $apartment->services->pluck('id')->toArray();

        $services = Service::whereIn('id', $related_services)->get();
        return view('auth.apartments.show', compact('apartment', 'services'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        // get all services for the db
        $services = Service::all();
        // get an array of the ids of services alredy related to this apartment
        $related_services_ids = $apartment->services->pluck('id')->toArray();
        return view('auth.apartments.form', compact('apartment', 'services', 'related_services_ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartment)
    {
        // get all data from the request
        $data = $request->all();

        // fill the apartment with the data from the request
        $apartment->fill($data);

        // get all the slugs from the db
        $existing_slugs = Apartment::all()->pluck('slug')->toArray();
        // add the slug to the apartment and save the apartment in the db
        $apartment->slug = $apartment->create_unique_slug($existing_slugs);
        $apartment->save();

        return redirect()->route('user.apartments.show', $apartment);
        // dd($apartment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        //
    }
}
