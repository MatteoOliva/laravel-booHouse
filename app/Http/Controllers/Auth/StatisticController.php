<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function show()
    {
        // Imposta la localizzazione italiana
        Carbon::setLocale('it');
        // prendo gli ultimi 6 mesi relativi alla data di oggi
        $months_names = [];
        for ($i = 0; $i < 6; $i++) {
            $months_names[] = Carbon::now()->subMonths($i)->translatedFormat('F');
        }
        // Inverti l'array per avere i mesi in ordine cronologico
        $months_names = array_reverse($months_names);

        $apartment_id = 1;
        $messages_per_month = Message::selectRaw("DATE_FORMAT(date, '%Y-%m') AS month")
            ->selectRaw("COUNT(*) AS message_count ")
            ->where([
                ['apartment_id', '=', $apartment_id],
                ['date', '>=', now()->subMonths(6)]
            ])
            ->groupBy('month')
            ->orderBy('month')->get();
        // ->pluck('message_count', 'month');

        // SELECT DATE_FORMAT(date, '%Y-%m') AS month, 
        // COUNT(*) AS message_count 
        // FROM messages 
        // WHERE apartment_id = 1 AND date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) 
        // GROUP BY DATE_FORMAT(date, '%Y-%m') 
        // ORDER BY month; 

        // prendo un array che contiente tutti i mesi degli ultimi 6 mesi in formato year-mm
        $last_6_months = [];
        for ($i = 5; $i >= 0; $i--) {
            $last_6_months[] = Carbon::now()->subMonths($i)->format('Y-m');
        }

        // creao un array che conterrà il conto dei messaggi per ogni mese degli ultimi 6 mesi
        $messages_6_months = [];
        // per ognuno degli ultimi 6 mesi prendo il singolo mese
        foreach ($last_6_months as $month) {
            // se trovo il primo mese nella collection il cui valore 'month' è = al mese 
            $month_has_messages = $messages_per_month->where('month', $month)->first();
            // se il mese è stato trovato nella collection
            if ($month_has_messages) {
                // inserisco il valore di 'message_count' nell'array dei risultati
                $messages_6_months[] = $month_has_messages['message_count'];
            } else {
                // altrimenti inserisco il valore 0
                $messages_6_months[] = 0;
            }
        }

        // dd($last_6_months, $messages_per_month->toArray(), $messages_6_months);


        return view('auth.apartments.statistics.show', compact('months_names', 'messages_6_months'));
    }
}
