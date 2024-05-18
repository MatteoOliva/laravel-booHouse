<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\View;
use Illuminate\Http\Request;

class ApiViewController extends Controller
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
        // prendo l'inidirizzo ip 
        $ip_address =  $_SERVER['REMOTE_ADDR'];
        // $ip_address = '163.158.88.160';

        // prendo l'id appartamento dalla request
        $apartment_id = $request['apartment_id'];

        // prendo la data di oggi senza l'ora
        $today = Carbon::today();

        // vedo nella tabella già esiste una riga con questo apartment_id 
        $already_viewed_today = View::where([
            ['apartment_id', $apartment_id],
            ['ip_address', $ip_address]
        ])
            ->whereDate('date', $today)
            ->exists();

        // dd([
        //     'apartment_id' => $apartment_id,
        //     'ip_address' => $ip_address,
        //     'today' => $today->toDateString(),
        //     'already_viewed_today' => $already_viewed_today
        // ]);

        // se la riga non esiste
        if (!$already_viewed_today) {

            //creo una nuova view e salvo i dati nel db
            $view = new View();
            $view->apartment_id = $apartment_id;
            $view->ip_address = $ip_address;
            $view->date = now();
            $view->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
