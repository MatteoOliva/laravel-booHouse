<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ApartmentServiceSeeder extends Seeder
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

        // get all the services' ids and save them as an array
        $services_ids = Service::all()->pluck('id')->toArray();

        // for each Apartment
        foreach ($apartments as $apartment) {
            // get a random number of services, min 0, max 4
            $services_to_add = $faker->randomElements($services_ids, random_int(0, 4));
            // assign them to the apartment
            $apartment->services()->attach($services_to_add);
        }
    }
}
