<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpadateApartmentRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

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
    public function store(StoreApartmentRequest $request)
    {
        // get all data from the request
        // $data = $request->all();

        // validate the request
        $data = $request->validated();

        // create a new apartment and fill it with the data from the request
        $apartment = new Apartment;
        $apartment->fill($data);
        // get the id of the user and add it to the aprtment
        $auth_user_id = auth()->id();
        $apartment->user_id = $auth_user_id;
        // set the visibility to false
        $apartment->visible = false;

        // get all the slugs from the db
        $existing_slugs = Apartment::withTrashed()->get()->pluck('slug')->toArray();
        // dd($existing_slugs);
        // add the slug to the apartment and save the apartment in the db
        $apartment->slug = $apartment->create_unique_slug($existing_slugs);
        // dd($apartment);

        //ifthe request contains the key image then save it in the store folder and save the path in the db
        if ($request->hasFile('image')) $apartment->image = Storage::put('uploads/apartments', $request->file('image'));

        $apartment->save();

        //if the key services exist in the array data, then assign the values passed
        //with data[services] to the apartment, creating the relations
        if (Arr::exists($data, 'services')) $apartment->services()->attach($data['services']);

        return redirect()->route('user.apartments.show', $apartment)->with('message-class', 'alert-success')->with('message', 'Appartamento inserito correttamente.');
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

        // protection route
        if (Auth::id() != $apartment->user_id)
            abort(403);

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

        // protection route
        if (Auth::id() != $apartment->user_id)
            abort(403);

        return view('auth.apartments.form', compact('apartment', 'services', 'related_services_ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function update(UpadateApartmentRequest $request, Apartment $apartment)
    {
        // get all data from the request and validate it
        // $data = $request->all();
        $data = $request->validated();

        // if the title in the request is different from the title of the apartment
        if ($apartment->title != $request->input('title')) {
            // fill the apartment with the data from the request
            $apartment->fill($data);
            // get all the slugs from the db
            $existing_slugs = Apartment::withTrashed()->get()->pluck('slug')->toArray();
            // create a new slug form the new titile and it to the apartment and save the apartment in the db
            $apartment->slug = $apartment->create_unique_slug($existing_slugs);
        } else {

            // fill the apartment with the data from the request
            $apartment->fill($data);
        }

        //if the request has an image
        if ($request->hasFile('image')) {
            // apartment already has an image, delete it from the storage
            if ($apartment->image) Storage::delete($apartment->image);
            //then add the new path to the db
            $apartment->image = Storage::put('uploads/apartments', $request->file('image'));
        }

        $apartment->save();

        //if the key services exist in the array data
        if (Arr::exists($data, 'services')) {
            //assign the values passed
            //with data[services] to the apartment, creating the relationships
            $apartment->services()->sync($data['services']);
        } else {
            //detach all services from this apartment
            $apartment->services()->detach();
        }

        return redirect()->route('user.apartments.show', $apartment)->with('message-class', 'alert-success')->with('message', 'Appartamento modificato correttamente.');
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
        $apartment->delete();
        return redirect()->route('user.apartments.index')->with('message-class', 'alert-danger')->with('message', 'Appartamento eliminato correttamente.');
    }

    /**
     * Delete the image related to the apartment
     *
     */
    public function destroy_image(Apartment $apartment)
    {
        //delete the image from the storage
        Storage::delete($apartment->image);
        //set the value of apartment image to null
        $apartment->image = "img/placeholder.webp";
        // set the apartment to not visible
        $apartment->visible = false;
        //save the apartment in the db
        $apartment->save();
        //return the user to where it was
        return redirect()->back();
    }

    /**
     * toggle the visible paramer
     *
     */
    public function update_visible(Request $request, Apartment $apartment)
    {

        $data = $request->all();
        $apartment->visible = Arr::exists($data, 'visible') ? true : false;
        $apartment->save();
        return redirect()->back();
    }

    /**
     * redirect to index (to be used if API errors occurs)
     *
     */
    public function back_to_index()
    {
        return redirect()->route('user.apartments.index')->with('message-class', 'alert-danger')->with('message', 'Un fantasma ci ha rallentati! Per favore riprova più tardi');
    }
}
