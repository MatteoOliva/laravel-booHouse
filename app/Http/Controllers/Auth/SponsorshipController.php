<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Braintree\Gateway;
use Illuminate\Http\Request;

class SponsorshipController extends Controller
{
    public function index($apartment_id)
    {
        $apartment = Apartment::where('id', $apartment_id)->first();
        
        $sponsorships = Sponsorship::all(); 
        return view('auth.apartments.sponsorship.index', compact('sponsorships', 'apartment_id', 'apartment' )); 
    }
    
    public function goToPayment($apartment_id) 
    {
        $apartment = Apartment::where('id', $apartment_id)->first();
        $gateway = new Gateway([
            'environment' => env('BRAINTREE_ENVIRONMENT'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY'),
        ]);

        $clientToken = $gateway->clientToken()->generate();
        
        return view('auth.apartments.sponsorship.pay', compact('clientToken', 'apartment', 'apartment_id'));

    }

    public function checkOut() 
    {
        $nonceFromTheClient = $_POST["payment_method_nonce"];
        dd($nonceFromTheClient);
    }


}

