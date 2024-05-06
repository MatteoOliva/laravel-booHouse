<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // take all the users ids form the db
        $user_ids = User::all()->pluck('id');
        // var_dump($user_ids);

        // create an empty array to save all thje slugs
        $slugs = [];

        // open the csv file
        $file = fopen(__DIR__ . '/../csv/apartments.csv', 'r');
        // var_dump($file);

        // set the switch variable for the first line to true
        $is_first_line = true;

        // as long as the file is not ended
        while (!feof($file)) {
            // get the data from the line of the file
            $data = fgetcsv($file);
            // if the line is not empty
            if ($data) {
                // if it's not the first line
                if (!$is_first_line) {
                    // var_dump($data);

                    $apartment = new Apartment;
                    // get a random user id
                    $apartment->user_id = $faker->randomElement($user_ids);
                    $apartment->title = $data[0];
                    $apartment->description = $data[2];
                    $apartment->rooms = $data[3];
                    $apartment->beds = $data[4];
                    $apartment->toilets = $data[5];
                    $apartment->mq = $data[6];
                    $apartment->image = $data[7];
                    $apartment->lat = $data[8];
                    $apartment->lon = $data[9];
                    $apartment->address = $data[10];
                    $apartment->visible = $data[11];

                    // create a slug from the title
                    $new_slug = Str::slug($apartment->title);
                    // if this slug is not in the array set before
                    // $i = 1;
                    while (in_array($new_slug, $slugs)) {
                        // var_dump('inizio while ' . $new_slug . ' ciclo n ' . $i);

                        // get only the last 2 carachters of the slug then parse them into int
                        $last_digits = substr($new_slug, strlen($new_slug) - 2);
                        $last_num = (int) $last_digits;
                        // var_dump('caratteri ' . $last_digits, 'intero ' . $last_num);
                        // if they are a number 
                        if ($last_num !=  0) {
                            // add 1 
                            $new_num = $last_num + 1;
                            // then if the num is < 10 add a 0 before it
                            if ($new_num < 10) $new_num = '0' . $new_num;
                            // get all the slug except the last 2 characters
                            $slug_text = substr($new_slug, 0, -3);
                        } else {
                            // the new num to add will be 01
                            $new_num = '01';
                            // the slug text will be = to the whole slug
                            $slug_text = $new_slug;
                        }
                        // then add the number to the text of the slug
                        $new_slug = $slug_text . '-' . $new_num;
                        // var_dump($new_slug);
                        // $i++;
                    }

                    // add the slug to the array and in the new apartment
                    array_push($slugs, $new_slug);
                    $apartment->slug = $new_slug;

                    // save the apartment in the db
                    $apartment->save();
                }

                // set first line to false
                $is_first_line = false;
            }
        }
    }
}
