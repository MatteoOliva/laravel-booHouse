<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
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
                "name" => "Aria Condizionata",
                "icon" => "svg/icons/aria-incondizionata.svg",
            ],
            [
                "name" => "Cimitero",
                "icon" => "svg/icons/cimitero.svg",
            ],
            [
                "name" => "Colazione",
                "icon" => "svg/icons/colazione.svg",
            ],
            [
                "name" => "Fantasmi",
                "icon" => "svg/icons/fantasmi.svg",
            ],
            [
                "name" => "Lavatrice",
                "icon" => "svg/icons/lavatrice.svg",
            ],
            [
                "name" => "Parcheggio",
                "icon" => "svg/icons/parcheggio.svg",
            ],
            [
                "name" => "Pulizia",
                "icon" => "svg/icons/pulizia.svg",
            ],
            [
                "name" => "Servizio in Camera",
                "icon" => "svg/icons/servizio-in-camera.svg",
            ],
            [
                "name" => "Sveglia",
                "icon" => "svg/icons/sveglia.svg",
            ],
            [
                "name" => "Trappola",
                "icon" => "svg/icons/trappola.svg",
            ],
            [
                "name" => "Wifi",
                "icon" => "svg/icons/wifi.svg",
            ],
        ];

        foreach ($data as $record) {
            $service = new Service;
            $service->name = $record["name"];
            $service->icon = $record["icon"];
            $service->save();
        }
    }
}
