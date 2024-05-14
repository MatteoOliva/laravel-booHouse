<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Illuminate\Http\Request;

class SponsorshipController extends Controller
{
    public function index($apartment_id)
    {
        $apartment = Apartment::where('id', $apartment_id)->first();
      
        $sponsorships = Sponsorship::all(); 
        return view('auth.apartments.sponsorship.index', compact('sponsorships', 'apartment_id', 'apartment' )); 
    }
}

