<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::select('id', 'title', 'slug', 'description', 'rooms', 'beds', 'toilets', 'mq', 'image', 'lat', 'lon', 'address')
            ->where('visible', true)
            ->get();

        // SELECT * 
        // FROM apartments 
        // WHERE visible = true; 

        // per ogni appartamento
        foreach ($apartments as $apartment) {
            // ottieni il path assoluto dell'immagine
            $apartment->image = $apartment->get_img_absolute_path();
        }

        // restituisce la risposta in formato json
        return response()->json($apartments);
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

        // ottieni il path assoluto dell'immagine
        $apartment->image = $apartment->get_img_absolute_path();

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
    public function search($search_term)
    {
        // $search_term = 'otta';

        $apartments = Apartment::leftJoin('apartment_sponsorship', 'apartments.id', '=', 'apartment_sponsorship.apartment_id')
            ->select('apartments.id', 'apartments.title', 'apartments.slug', 'apartments.image', 'apartments.address')
            ->where([
                ['apartments.visible', '=', true],
                ['apartments.address', 'like', '%' . $search_term . '%']
            ])
            ->orWhere([
                ['apartments.title', 'like', '%' . $search_term . '%']
            ])
            ->with(['sponsorships']);
        $apartments = $apartments->paginate(10);

        // SELECT * 
        // FROM apartments 
        // LEFT JOIN apartment_sponsorship
        // ON apartments.id = apartment_sponsorship.apartment_id
        // WHERE name LIKE '%casa%';

        // per ogni appartamento
        foreach ($apartments as $apartment) {
            // ottieni il path assoluto dell'immagine
            $apartment->image = $apartment->get_img_absolute_path();
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
            ->where('visible', true);
        // ->orderBy('apartment_sponsorship.payment_date', 'desc');
        $sponsored_apartments = $sponsored_apartments->get();

        // SELECT * 
        // FROM apartments 
        // INNER JOIN apartment_sponsorship ON apartments.id = apartment_sponsorship.apartment_id 
        // WHERE visible = true; 

        $views_per_apartment = View::select('apartment_id', DB::raw('COUNT(*) as view_count'))
            ->groupBy('apartment_id')
            ->get();

        // SELECT apartment_id, 
        // COUNT(*) 
        // FROM views 
        // GROUP BY apartment_id; 

        //ciclo gli appartmenti 
        foreach ($sponsored_apartments as $apartment) {
            // var che conterrà il numero di views
            $views = 0;
            // controllo per tutte le visualizzazioni per appartamento
            foreach ($views_per_apartment as $view_row) {

                //se l'id dell appartamento è uguale all id_appartamento legato alla view
                if ($apartment->id == $view_row->apartment_id) {
                    //aggiungo il numero di visualizzazioni all'appartamento
                    $views = $view_row->view_count;
                }
            }
            // se var switch è su true allora aggiungi il val trovato all appartamento, altrimenti aggiungi 0
            $apartment->views = $views;
        }

        // per ogni appartamento
        foreach ($sponsored_apartments as $apartment) {
            // ottieni il path assoluto dell'immagine
            $apartment->image = $apartment->get_img_absolute_path();
        }

        // ordino per numero di visualizzazioni
        $ordered_apartments = $sponsored_apartments->sortByDesc('views')->toArray();
        // dd($ordered_apartments);

        // restituisce la risposta in formato json
        // return response()->json([
        //     'sponsored apartments' => $sponsored_apartments,
        //     'views per apartment' => $views_per_apartment
        // ]);
        return response()->json($ordered_apartments);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sponsored_search($search_term)
    {
        $sponsored_apartments = Apartment::join('apartment_sponsorship', 'apartments.id', '=', 'apartment_sponsorship.apartment_id')
            ->select('apartments.id', 'apartments.title', 'apartments.slug', 'apartments.image', 'apartments.address', 'apartments.description')
            ->where([
                ['apartments.visible', '=', true],
                ['apartments.address', 'like', '%' . $search_term . '%']
            ])
            ->orWhere([
                ['apartments.title', 'like', '%' . $search_term . '%']
            ])
            ->orderBy('apartment_sponsorship.payment_date', 'desc');
        $sponsored_apartments = $sponsored_apartments->get();

        // SELECT * 
        // FROM apartments 
        // INNER JOIN apartment_sponsorship ON apartments.id = apartment_sponsorship.apartment_id 
        // WHERE visible = true 
        // AND address LIKE '%pe%'; 

        // per ogni appartamento
        foreach ($sponsored_apartments as $apartment) {
            // ottieni il path assoluto dell'immagine
            $apartment->image = $apartment->get_img_absolute_path();
        }

        // restituisce la risposta in formato json
        return response()->json($sponsored_apartments);
    }

    public function not_sponsored_search($search_term)
    {
        // prendo l'elenco di tutti gli id degli appartamenti sponsorizzati
        $sponsored_apartment_ids = DB::table('apartment_sponsorship')->get()->pluck('apartment_id')->toArray();
        // dd($sponsored_apartment_ids);

        $apartments = Apartment::select('apartments.id', 'apartments.title', 'apartments.slug', 'apartments.image', 'apartments.address', 'apartments.description')
            ->where([
                ['apartments.address', 'like', '%' . $search_term . '%']
            ])
            ->orWhere([
                ['apartments.title', 'like', '%' . $search_term . '%']
            ])
            ->where(['apartments.visible', '=', true])
            ->get();

        // $apartments->->get();

        $not_sponsored_apartments = [];

        // ciclo tutti gli appartamenti
        foreach ($apartments as $apartment) {
            // se l'id dell'appartamento non è compreso tra gli id degli appartamenti sponsorizzati aggiungilo all'array degli appartamenti non sponsorizzati
            if (!in_array($apartment->id, $sponsored_apartment_ids)) $not_sponsored_apartments[] = $apartment;
        }

        return response()->json($not_sponsored_apartments);
    }

    public function search_ordered($search_term, $destination_lat, $destination_lon, $radius = 20)
    {
        // trova tutti gli appartamenti la cui distanza dalla longitudine e latitudine date sono inferirori al radius dato (default 20)
        $radius_apartments = Apartment::selectRaw('*, ACOS(SIN(RADIANS(lat)) * SIN(RADIANS(?)) + COS(RADIANS(lat)) * COS(RADIANS(?)) * COS(RADIANS(ABS(lon - ?)))) * 6371 AS distance')
            ->orderBy('distance', 'ASC')
            ->setBindings(([$destination_lat, $destination_lon, $radius]))
            ->whereRaw(
                'ACOS(SIN(RADIANS(lat)) * SIN(RADIANS(?)) + COS(RADIANS(lat)) * COS(RADIANS(?)) * COS(RADIANS(ABS(lon - ?)))) * 6371 <= ?',
                [
                    $destination_lat,
                    $destination_lat,
                    $destination_lon,
                    $radius
                ]
            )
            ->orWhere([
                ['apartments.title', 'like', '%' . $search_term . '%'],
            ]);

        $results = $radius_apartments->where('visible', true)->get();


        // per ogni appartamento trovato
        foreach ($results as $apartment) {
            // ottieni il path assoluto dell'immagine
            $apartment->image = $apartment->get_img_absolute_path();
        }

        return response()->json($results);
    }
}
