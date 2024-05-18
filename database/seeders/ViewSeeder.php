<?php

namespace Database\Seeders;

use App\Models\View;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;


class ViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++) {
            $view = new View;
            $view->apartment_id = random_int(1, 13);
            $view->date = $faker->dateTimeBetween('-6 month', now());
            $view->ip_address = $faker->ipv4();
            $view->save();
        }
    }
}
