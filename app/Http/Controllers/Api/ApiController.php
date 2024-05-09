<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // Prendi il primo progetto che corrisponde allo slug ricevuto
        $apartment = Apartment::select('id', 'title', 'slug', 'description', 'rooms', 'beds', 'toilets', 'mq', 'image', 'lat', 'lon', 'address',)
            ->where([
                'slug' => $slug,
                'visible' => true
            ])
            ->with(['sponsorships:duration', 'services:name,icon', 'user:name'])
            ->first();

        // se l'url dell'immagine inizia per img
        if (substr($apartment->image, 0, 3) == 'img') {
            // setta l'url dell'immagine dalla cartella img
            $apartment->image = asset('/' . $apartment->image);
        } else {
            //setta l'url dell'immagine dalla cartella storage
            $apartment->image = asset('/storage/' . $apartment->image);
        }

        // restituisce la risposta in formato json
        return response()->json($apartment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(string $search_term)
    {
        // $search_term = 'otta';

        $apartments = Apartment::leftJoin('apartment_sponsorship', 'apartments.id', '=', 'apartment_sponsorship.apartment_id')
            ->select('apartments.id', 'apartments.title', 'apartments.slug', 'apartments.image', 'apartments.address')
            ->where('title', 'like', '%' . $search_term . '%')
            ->with(['sponsorships']);
        $apartments = $apartments->paginate(10);

        // SELECT * 
        // FROM apartments 
        // LEFT JOIN apartment_sponsorship
        // ON apartments.id = apartment_sponsorship.apartment_id
        // WHERE name LIKE '%casa%';

        // per ogni appartamento
        foreach ($apartments as $apartment) {

            // se l'url dell'immagine inizia per img
            if (substr($apartment->image, 0, 3) == 'img') {
                // setta l'url dell'immagine dalla cartella img
                $apartment->image = asset('/' . $apartment->image);
            } else {
                //setta l'url dell'immagine dalla cartella storage
                $apartment->image = asset('/storage/' . $apartment->image);
            }
        }

        // restituisce la risposta in formato json
        return response()->json($apartments);
    }

    /**
     * Mostra tutti gli appartamenti sponsorizzati dal più recente
     *
     * @return \Illuminate\Http\Response
     */
    public function sponsored_all()
    {
        $sponsored_apartments = Apartment::join('apartment_sponsorship', 'apartments.id', '=', 'apartment_sponsorship.apartment_id')
            ->select('apartments.id', 'apartments.title', 'apartments.slug', 'apartments.image', 'apartments.address', 'apartments.description')
            ->where('visible', true)
            ->orderBy('apartment_sponsorship.payment_date', 'desc');
        $sponsored_apartments = $sponsored_apartments->get();

        // SELECT * 
        // FROM apartments 
        // INNER JOIN apartment_sponsorship ON apartments.id = apartment_sponsorship.apartment_id 
        // WHERE visible = true; 

        // restituisce la risposta in formato json
        return response()->json($sponsored_apartments);
    }
}
