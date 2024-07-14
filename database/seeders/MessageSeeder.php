<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(Faker $faker): void
    {

        $apartment_ids = Apartment::all()->pluck('id')->all();

        for ($i = 0; $i < 20; $i++) {

            $new_message = new Message();

            $new_message->sender_email = $faker->email();
            $new_message->content = $faker->text();
            $new_message->apartment_id = $apartment_ids[floor($i / 2)];
            $new_message->notification = false;

            $new_message->save();

        }
    }
}
