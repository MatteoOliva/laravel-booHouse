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
        return view('auth.apartments.form');
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

        // create a slug from the title
        $new_slug = Str::slug($apartment->title);
        // check if this new slug already exist in the db
        while (in_array($new_slug, $existing_slugs)) {

            // get only the last 2 carachters of the slug then parse them into int
            $last_digits = substr($new_slug, strlen($new_slug) - 2);
            $last_num = (int) $last_digits;

            // if this is a number 
            if ($last_num != 0) {

                // add 1 
                $new_num = $last_num + 1;
                // then if the num is < 10 add a 0 before it
                if ($new_num < 10) $new_num = '0' . $new_num;
                // get all the slug except the last 2 characters
                $slug_text = substr($new_slug, 0, -3);
            } else {

                // the new num to add will be 01
                $new_num = '01';
                // the slug text will be = to the whole slug
                $slug_text = $new_slug;
            }

            // then add the number to the text of the slug
            $new_slug = $slug_text . '-' . $new_num;
        }

        // add the slug to the apartment and save the apartment in the db
        $apartment->slug = $new_slug;
        $apartment->save();

        return redirect()->route('user.apartments.show', $apartment);
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
        return view('auth.apartments.form', compact('apartment'));
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
        dd($apartment);
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
