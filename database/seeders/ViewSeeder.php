<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\View;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {

        $apartment_ids = Apartment::all()->pluck('id')->all();

        for ($i = 0; $i < 10000; $i++) {

            $new_view = new View();

            $new_view->ip = $faker->ipv4();
            $new_view->apartment_id = $faker->randomElement($apartment_ids);
            $new_view->created_at = $faker->dateTimeBetween('-1 year', 'yesterday');


            $new_view->save();

        }

    }
}
