<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {

        for ($i = 0; $i < 5; $i++) {

            $new_user = new User();

            $new_user->email = $faker->unique()->email();
            $random_password = $faker->password();//variable
            $new_user->password = Hash::make($random_password);
            $new_user->name = $faker->optional()->firstName();
            $new_user->surname = $faker->optional()->lastName();
            $new_user->date_of_birth = $faker->optional()->dateTimeBetween('-80 years', '-18 years');

            $new_user->save();
        }

        $admin = new User();
        $admin->email = 'admin@gmail.com';
        $admin->password = 'admin';
        $admin->save();

    }
}
