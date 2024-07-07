<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Sponsor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sponsors =
            [
                [
                    'tier' => 'Standard',
                    'hours' => 24,
                    'price' => 2.99
                ],
                [
                    'tier' => 'Plus',
                    'hours' => 72,
                    'price' => 5.99
                ],
                [
                    'tier' => 'Premium',
                    'hours' => 144,
                    'price' => 9.99
                ]
            ];

        for ($i = 0; $i < count($sponsors); $i++) {

            $new_sponsor = new Sponsor();

            $new_sponsor->tier = $sponsors[$i]['tier'];
            $new_sponsor->hours = $sponsors[$i]['hours'];
            $new_sponsor->price = $sponsors[$i]['price'];

            $new_sponsor->save();

        }
    }
}
