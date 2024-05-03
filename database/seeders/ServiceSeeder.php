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
                "name" => "aria condizionata",
                "icon" => "/svg/icons/aria-incondizionata.svg",
            ],
            [
                "name" => "cimitero",
                "icon" => "/svg/icons/cimitero.svg",
            ],
            [
                "name" => "colazione",
                "icon" => "/svg/icons/colazione.svg",
            ],
            [
                "name" => "fantasmi",
                "icon" => "/svg/icons/fantasmi.svg",
            ],
            [
                "name" => "lavatrice",
                "icon" => "/svg/icons/lavatrice.svg",
            ],
            [
                "name" => "parcheggio",
                "icon" => "/svg/icons/parcheggio.svg",
            ],
            [
                "name" => "pulizia",
                "icon" => "/svg/icons/pulizia.svg",
            ],
            [
                "name" => "servizio-in-camera",
                "icon" => "/svg/icons/servizio-in-camera.svg",
            ],
            [
                "name" => "sveglia",
                "icon" => "/svg/icons/sveglia.svg",
            ],
            [
                "name" => "trappola",
                "icon" => "/svg/icons/trappola.svg",
            ],
            [
                "name" => "wifi",
                "icon" => "/svg/icons/wifi.svg",
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
