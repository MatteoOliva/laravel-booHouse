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
        // Trova l'appartamento corrispondente all'ID fornito
        $apartment = Apartment::findOrFail($apartment_id);
      
        $sponsorships = Sponsorship::all(); 

        return view('auth.apartments.sponsorship.index', compact('sponsorships', 'apartment'));
    }

    public function select($apartmentId, $sponsorshipId) {

        session(['selected_apartment_id' => $apartmentId]);
        session(['selected_sponsorship_id' => $sponsorshipId]);
    
        return redirect()->route('user.sponsorship.payment', $apartmentId );
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

    public function checkOut(Request $request) 
    {
        // $nonceFromTheClient = $_POST["payment_method_nonce"];
        $nonceFromTheClient = $request->input('payment_method_nonce');

        // Ottieni l'id dell'appartamento e dellasponsorship dalla sessione
        $apartmentId = $request->session()->get('selected_apartment_id'); 
        $sponsorshipId = $request->session()->get('selected_sponsorship_id'); 

        // Ottieni l'oggetto Sponsorship corrispondente all'id
        $sponsorship = Sponsorship::find($sponsorshipId);
        if (!$sponsorship) {
            return redirect()->route('user.apartments.index')->with('message-class', 'alert-danger')->with('message', 'Sponsorship non valida.');
        }

        $amount = $sponsorship->price;
        $endDate = now()->addHours($sponsorship->duration);

        // Salvare i dati nel database
        Sponsorship::find($sponsorshipId)->apartments()->attach($apartmentId, [
            'payment_date' => now(),
            'end_date' => $endDate,
        ]);

        $gateway = new Gateway([
            'environment' => env('BRAINTREE_ENVIRONMENT'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY'),
        ]);

        $result = $gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonceFromTheClient,
            'options' => [
              'submitForSettlement' => True
            ]
          ]);


        if ($result->success == true) {
            return redirect()->route('user.apartments.index');
        } else {
            return redirect()->route('user.sponsorships.index', '10');
        }
    }


}


