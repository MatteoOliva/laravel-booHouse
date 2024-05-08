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
        // get all the apartments from the db
        $apartments = Apartment::all();

        // get all the sponsorship' ids and save them as an array
        $sponsorships_ids = Sponsorship::all()->pluck('id')->toArray();

        $end_sponsorships = [
            1 => now()->addHours(24)->format( 'Y-m-d H:i:s'),
            2 => now()->addHours(72)->format('Y-m-d H:i:s'),
            3 => now()->addHours(144)->format('Y-m-d H:i:s'),
        ];
        

        // for each Apartment
        foreach ($apartments as $apartment) {
            // get a random number of sponsor, min 0, max 1
            $sponsors_to_add = $faker->randomElements($sponsorships_ids, random_int(0, 1));

            $endDate = $faker->randomElement($end_sponsorships);

            // assign them to the apartment
            $apartment->sponsorships()->attach($sponsors_to_add , [
                'payment_date' => now(),
                'end_date' => $endDate,
            ]);



        }

        
    }
}
