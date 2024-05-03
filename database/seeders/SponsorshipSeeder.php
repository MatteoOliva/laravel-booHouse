<?php

namespace Database\Seeders;

use App\Models\Sponsorship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "name" => "basic",
                "price" => 2.99,
                "duration" => 24,
            ],
            [
                "name" => "intermediate",
                "price" => 5.99,
                "duration" => 72,
            ],
            [
                "name" => "advanced",
                "price" => 9.99,
                "duration" => 144,
            ],
        ];

        foreach ($data as $record) {
            //     var_dump($record["name"], $record["price"], $record["duration"]);
            $sponsorship = new Sponsorship;
            $sponsorship->name = $record["name"];
            $sponsorship->price = $record["price"];
            $sponsorship->duration = $record["duration"];
            $sponsorship->save();
        }
    }
}
