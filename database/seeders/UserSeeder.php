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
            // Users from Milan
            [
                'email' => 'milan_user1@gmail.com',
                'password' => Hash::make('milanuser1'),
                'name' => 'Mario',
                'surname' => 'Bianchi',
                'date_of_birth' => '1970-01-01'
            ],
            [
                'email' => 'milan_user2@gmail.com',
                'password' => Hash::make('milanuser2'),
                'name' => 'Luca',
                'surname' => 'Neri',
                'date_of_birth' => '1971-02-02'
            ],
            [
                'email' => 'milan_user3@gmail.com',
                'password' => Hash::make('milanuser3'),
                'name' => 'Giovanni',
                'surname' => 'Gialli',
                'date_of_birth' => '1972-03-03'
            ],
            [
                'email' => 'milan_user4@gmail.com',
                'password' => Hash::make('milanuser4'),
                'name' => 'Francesco',
                'surname' => 'Verdi',
                'date_of_birth' => '1973-04-04'
            ],
            [
                'email' => 'milan_user5@gmail.com',
                'password' => Hash::make('milanuser5'),
                'name' => 'Giuseppe',
                'surname' => 'Blu',
                'date_of_birth' => '1974-05-05'
            ],
            // Users from Rome
            [
                'email' => 'rome_user1@gmail.com',
                'password' => Hash::make('romeuser1'),
                'name' => 'Andrea',
                'surname' => 'Rossi',
                'date_of_birth' => '1980-06-06'
            ],
            [
                'email' => 'rome_user2@gmail.com',
                'password' => Hash::make('romeuser2'),
                'name' => 'Fabio',
                'surname' => 'Bianchi',
                'date_of_birth' => '1981-07-07'
            ],
            [
                'email' => 'rome_user3@gmail.com',
                'password' => Hash::make('romeuser3'),
                'name' => 'Alessandro',
                'surname' => 'Neri',
                'date_of_birth' => '1982-08-08'
            ],
            [
                'email' => 'rome_user4@gmail.com',
                'password' => Hash::make('romeuser4'),
                'name' => 'Simone',
                'surname' => 'Gialli',
                'date_of_birth' => '1983-09-09'
            ],
            [
                'email' => 'rome_user5@gmail.com',
                'password' => Hash::make('romeuser5'),
                'name' => 'Paolo',
                'surname' => 'Verdi',
                'date_of_birth' => '1984-10-10'
            ],
            // Users from Naples
            [
                'email' => 'naples_user1@gmail.com',
                'password' => Hash::make('naplesuser1'),
                'name' => 'Enzo',
                'surname' => 'Neri',
                'date_of_birth' => '1990-11-11'
            ],
            [
                'email' => 'naples_user2@gmail.com',
                'password' => Hash::make('naplesuser2'),
                'name' => 'Luigi',
                'surname' => 'Rossi',
                'date_of_birth' => '1991-12-12'
            ],
            [
                'email' => 'naples_user3@gmail.com',
                'password' => Hash::make('naplesuser3'),
                'name' => 'Carmine',
                'surname' => 'Bianchi',
                'date_of_birth' => '1992-01-01'
            ],
            [
                'email' => 'naples_user4@gmail.com',
                'password' => Hash::make('naplesuser4'),
                'name' => 'Salvatore',
                'surname' => 'Gialli',
                'date_of_birth' => '1993-02-02'
            ],
            [
                'email' => 'naples_user5@gmail.com',
                'password' => Hash::make('naplesuser5'),
                'name' => 'Vincenzo',
                'surname' => 'Blu',
                'date_of_birth' => '1994-03-03'
            ],
            // Users from Florence
            [
                'email' => 'florence_user1@gmail.com',
                'password' => Hash::make('florenceuser1'),
                'name' => 'Marco',
                'surname' => 'Rossi',
                'date_of_birth' => '2000-04-04'
            ],
            [
                'email' => 'florence_user2@gmail.com',
                'password' => Hash::make('florenceuser2'),
                'name' => 'Stefano',
                'surname' => 'Bianchi',
                'date_of_birth' => '2001-05-05'
            ],
            [
                'email' => 'florence_user3@gmail.com',
                'password' => Hash::make('florenceuser3'),
                'name' => 'Davide',
                'surname' => 'Neri',
                'date_of_birth' => '2002-06-06'
            ],
            [
                'email' => 'florence_user4@gmail.com',
                'password' => Hash::make('florenceuser4'),
                'name' => 'Nicola',
                'surname' => 'Gialli',
                'date_of_birth' => '2003-07-07'
            ],
            [
                'email' => 'florence_user5@gmail.com',
                'password' => Hash::make('florenceuser5'),
                'name' => 'Matteo',
                'surname' => 'Verdi',
                'date_of_birth' => '2004-08-08'
            ],
            // Users from Turin
            [
                'email' => 'turin_user1@gmail.com',
                'password' => Hash::make('turinuser1'),
                'name' => 'Giovanni',
                'surname' => 'Verdi',
                'date_of_birth' => '1995-09-09'
            ],
            [
                'email' => 'turin_user2@gmail.com',
                'password' => Hash::make('turinuser2'),
                'name' => 'Alessandro',
                'surname' => 'Bianchi',
                'date_of_birth' => '1996-10-10'
            ],
            [
                'email' => 'turin_user3@gmail.com',
                'password' => Hash::make('turinuser3'),
                'name' => 'Fabio',
                'surname' => 'Rossi',
                'date_of_birth' => '1997-11-11'
            ],
            [
                'email' => 'turin_user4@gmail.com',
                'password' => Hash::make('turinuser4'),
                'name' => 'Luca',
                'surname' => 'Neri',
                'date_of_birth' => '1998-12-12'
            ],
            [
                'email' => 'turin_user5@gmail.com',
                'password' => Hash::make('turinuser5'),
                'name' => 'Davide',
                'surname' => 'Gialli',
                'date_of_birth' => '1999-01-01'
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
