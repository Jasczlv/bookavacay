<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $services =
            [
                'Wi-Fi',
                'Pool',
                'Parking',
                'Beautiful landscape',
                'Reception desk',
                'Pets friendly',
                'LGBTQ+ friendly',
                'Air conditioning',
                'Close to transport',
                'Breakfast included',
                'Kitchen',
                'Shower',
                'Tv',
                'Washing machine',
                'Hairdryer'
            ];

        for ($i = 0; $i < count($services); $i++) {

            $new_service = new Service();

            $new_service->name = $services[$i];

            $new_service->save();

        }

    }
}
