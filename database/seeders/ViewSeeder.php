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

        for ($i = 0; $i < 100; $i++) {

            $new_view = new View();

            $new_view->ip = $faker->ipv4();
            $new_view->apartment_id = $faker->randomElement($apartment_ids);

            $new_view->save();

        }

    }
}
