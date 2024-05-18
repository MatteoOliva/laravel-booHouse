<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function show(){

        Carbon::setLocale('it'); // Imposta la localizzazione italiana

        $months = [];
        for ($i = 0; $i < 6; $i++) {
            $months[] = Carbon::now()->subMonths($i)->translatedFormat('F');
        }
    
        $months = array_reverse($months); // Inverti l'array per avere i mesi in ordine cronologico

        return view('auth.apartments.statistics.show' , compact('months'));
    }
}
