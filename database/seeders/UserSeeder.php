<?php

namespace Database\Seeders;

use App\Models\User;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 5; $i++) {

            $user = new User;
            $user->name = $faker->firstName();
            $user->surname = $faker->lastName();
            $user->birth_date = $faker->dateTimeBetween('-50 year', '-20 year');
            $user->email = $faker->email();
            $password = $faker->password();
            $user->password = Hash::make($password);
            $user->save();
            // var_dump($user);
        }
    }
}
