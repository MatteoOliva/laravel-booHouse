<?php

namespace App\Http\Controllers\Auth;



use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Braintree\Gateway;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Auth\DateTime;




class SponsorshipController extends Controller
{
    public function index($apartment_slug)
    {
        // Trova l'appartamento corrispondente all'ID fornito
        $apartment = Apartment::where('slug', $apartment_slug)->firstOrFail();
        $sponsorships = Sponsorship::all(); 
    

        return view('auth.apartments.sponsorship.index', compact('sponsorships', 'apartment'));
    }
    
    public function select($apartmentSlug, $sponsorshipId) {

        session(['selected_apartment_slug' => $apartmentSlug]);
        session(['selected_sponsorship_id' => $sponsorshipId]);
    
        
        return redirect()->route('user.sponsorship.payment', $apartmentSlug );
    }
    
    public function goToPayment($apartment_slug) 
    {
        $apartment = Apartment::where('slug', $apartment_slug)->first();
        $apartment_id = $apartment->id;
        $sponsorshipId = session('selected_sponsorship_id');
        $sponsorship = Sponsorship::findOrFail($sponsorshipId);

        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addHours($sponsorship->duration);

        $pivotData = DB::table('apartment_sponsorship')
        ->where('apartment_id', $apartment->id)
        ->where('sponsorship_id', $sponsorshipId)
        ->first();


        $gateway = new Gateway([
            'environment' => env('BRAINTREE_ENVIRONMENT'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY'),
        ]);

        $clientToken = $gateway->clientToken()->generate();
        
        return view('auth.apartments.sponsorship.pay', compact('clientToken', 'apartment', 'apartment_id', 'sponsorship', 'pivotData', 'startDate', 'endDate'));

    }

    public function checkOut(Request $request) 
    {
        // $nonceFromTheClient = $_POST["payment_method_nonce"];
        $nonceFromTheClient = $request->input('payment_method_nonce');

        // Ottieni l'id dell'appartamento e dellasponsorship dalla sessione
        $apartmentSlug = $request->session()->get('selected_apartment_slug'); 
        $sponsorshipId = $request->session()->get('selected_sponsorship_id');
        $apartment = Apartment::where('slug', $apartmentSlug)->firstOrFail();
        $apartmentId = $apartment->id;
        

        // Ottieni l'oggetto Sponsorship corrispondente all'id
        $sponsorship = Sponsorship::find($sponsorshipId);
        if (!$sponsorship) {
            return redirect()->route('user.apartments.index')->with('message-class', 'alert-danger')->with('message', 'Sponsorship non valida.');
        }

        $amount = $sponsorship->price;

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
            $active_sponsorship = DB::table('apartment_sponsorship')
            ->where('apartment_id', $apartmentId  )
            ->orderByDesc('end_date')
            ->first();

            if(isset($active_sponsorship) && $active_sponsorship->end_date >= now()) {
                $date_format_end_date = \Carbon\Carbon::parse( $active_sponsorship->end_date);
                // dd($date_format_end_date);
                $endDate = $date_format_end_date->addHours($sponsorship->duration)->format( 'Y-m-d H:i:s');
            } else {
                $endDate = now()->addHours($sponsorship->duration);
            }

        // Salvare i dati nel database
        Sponsorship::find($sponsorshipId)->apartments()->attach($apartmentId, [
            'payment_date' => now(),
            'end_date' => $endDate,
        ]);
        $apartment = Apartment::where('id',$apartmentId)->first();

            return redirect()->route('user.apartments.show', $apartment->slug)->with('message-class', 'alert-success')->with('message', 'Pagamento effettuato correttamente.');
        } else {
            return redirect()->route('user.sponsorships.index', $apartmentId)->with('message-class', 'alert-danger')->with('message', 'Pagamento non effettuato.');
        }
    }

}


