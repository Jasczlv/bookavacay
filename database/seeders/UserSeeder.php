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

        $users = [
            [
                'email' => 'robertorossi@gmail.com',
                'password' => Hash::make('robertorossi'),
                'name' => 'Roberto',
                'surname' => 'Rossi',
                'date_of_birth' => '1960-10-15'
            ],
            [
                'email' => 'vincenzoverdi@gmail.com',
                'password' => Hash::make('vincenzoverdi'),
                'name' => 'Vincenzo',
                'surname' => 'Verdi',
                'date_of_birth' => '1961-10-15'
            ],
            [
                'email' => 'null@gmail.com',
                'password' => Hash::make('null'),
                'name' => null,
                'surname' => null,
                'date_of_birth' => null
            ],
            [
                'email' => 'empty@gmail.com',
                'password' => Hash::make('empty'),
                'name' => '',
                'surname' => '',
                'date_of_birth' => null
            ],
            [
                'email' => '1234@gmail.com',
                'password' => Hash::make('1234'),
                'name' => 1234,
                'surname' => 1234,
                'date_of_birth' => '1-2-3'
            ],
        ];

        foreach ($users as $user) {
            # code...

            $new_user = new User();

            $new_user->email = $user['email'];
            $new_user->password = $user['password'];
            $new_user->name = $user['name'];
            $new_user->surname = $user['surname'];
            $new_user->date_of_birth = $user['date_of_birth'];
            $new_user->save();
        }


        $admin = new User();
        $admin->email = 'admin@gmail.com';
        $admin->password = Hash::make('admin');
        $admin->name = 'Admin';
        $admin->save();

    }
}
