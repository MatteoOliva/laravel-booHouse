<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;


class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        for ($i = 0; $i < 100; $i++) {
            $message = new Message;
            $message->apartment_id = random_int(1, 20);
            $message->email = $faker->email();
            $message->content = $faker->paragraph(5);
            $message->date = $faker->dateTimeBetween('-6 month', now());
            $message->save();
        }
    }
}
