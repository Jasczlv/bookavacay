<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Service;
use App\Models\Sponsor;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {

        $apartment_type =
            [
                'House for the perfect group vacation',
                'A tropical location for your event',
                'Vintage ex-fishing house',
                'Luxory villa with the best optionals',
                'Rusty Shack',
                'Relaxing house in the nature',
                'Ex-Politician house in Arcore',
                'Hottest Igloo of the summer',
                'Nice apartment near Termini Station',
                'Rope Gym in Piazzale Loreto'
            ];

        $user_ids = User::all()->pluck('id')->all();

        $sponsor_ids = Sponsor::all()->pluck('id')->all();

        $service_ids = Service::all()->pluck('id')->all();

        for ($i = 0; $i < 10; $i++) {

            /* $starting_point_lat = 44.49428334;  N S 44,67874 - 44,32525
            $starting_point_lon = 11.34267581; W E 11,08579 - 11,61025 */

            $random_lat = 44.12;
            $random_lon = 11.12;

            $new_apartment = new Apartment();

            $random_rooms = $faker->numberBetween(3, 15);

            $new_apartment->title = $apartment_type[$i];
            $new_apartment->rooms = $random_rooms;
            $new_apartment->beds = ceil($faker->numberBetween(1, $random_rooms / 2));
            $new_apartment->bathrooms = floor($faker->numberBetween(1, $random_rooms / 2));
            $new_apartment->sqr_mt = round($faker->numberBetween($random_rooms * 7, $random_rooms * 15));
            $new_apartment->lat = 44 + ($faker->numberBetween(32525, 67874)) / 100000;
            $new_apartment->lon = 11 + ($faker->numberBetween(10579, 61025)) / 100000;
            $new_apartment->image = 'https://picsum.photos/200/300?random=' . $i;
            $new_apartment->visible = true;
            $new_apartment->address = $faker->address();

            $new_apartment->user_id = $user_ids[floor(($i / 2))];

            $new_apartment->save();

            $number_of_services = rand(1, count($service_ids));
            $random_service_ids = $faker->randomElements($service_ids, $number_of_services);
            $new_apartment->services()->attach($random_service_ids);

            $random_sponsor_id = $faker->randomElements($sponsor_ids);
            $new_apartment->sponsors()->attach($random_sponsor_id, ['exp_date' => '2024-06-15 12:00:00']);

        }


    }
}
