<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Sponsorship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;


class ApartmentSponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // prendo gli appartamenti dal db
        $apartments = Apartment::all();

        // prendo gli le sponsorship id e le salvo in un array
        $sponsorships_ids = Sponsorship::all()->pluck('id')->toArray();

        // definisco un array con la data di fine di ogni sponsorizzazione
        $end_sponsorship = [
            1 => now()->addHours(24)->format( 'Y-m-d H:i:s'),
            2 => now()->addHours(72)->format('Y-m-d H:i:s'),
            3 => now()->addHours(144)->format('Y-m-d H:i:s'),
        ];
        

        
        foreach ($apartments as $apartment) {
        
            // Numero casuale di sponsorizzazioni da associare
            $numberSponsorships = random_int(0, 1); 
            $randomSponsorships = $faker->randomElements($sponsorships_ids, $numberSponsorships);

            // estraggo gli id degli sponsor casuali 
            $sponsorshipIds = array_slice($randomSponsorships, 0, $numberSponsorships);

            foreach ($sponsorshipIds as $sponsorshipId){
                // data di fine dello sponsor
                $endDate = $end_sponsorship[$sponsorshipId] ?? null;

                // assegno lo sponsor all'appartamento
                 $apartment->sponsorships()->attach($sponsorshipId , [
                'payment_date' => now(),
                'end_date' => $endDate,
                ]);
            }

            

            
            



        }

        
    }
}
