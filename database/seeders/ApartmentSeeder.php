<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Service;
use App\Models\Sponsor;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        /* Lista degli appartamenti creati a mano con dati reali */
        $apartments =
            [
                [
                    "title" => 'Stone Mountain Cabin',
                    "rooms" => '4',
                    'beds' => '2',
                    'bathrooms' => '1',
                    'sqr_mt' => '60',
                    'address' => 'Via Ca\' di Polo, 40036 Monzuno BO',
                    'latitude' => '44.270661682974485',
                    'longitude' => '11.291301837729694',
                    'image' => 'apartment_img_01.jpg',
                    'visible' => 1,
                    'user_id' => '1'
                ],
                [
                    "title" => 'Modern House with Indoor Pool',
                    "rooms" => '8',
                    'beds' => '4',
                    'bathrooms' => '2',
                    'sqr_mt' => '120',
                    'address' => 'Via Sabbioni, 2-32, 40050 Loiano BO',
                    'latitude' => '44.2838767133773',
                    'longitude' => '11.326890902470534',
                    'image' => 'apartment_img_02.jpg',
                    'visible' => 1,
                    'user_id' => '1'
                ],
                [
                    "title" => 'Beach wooden house',
                    "rooms" => '2',
                    'beds' => '1',
                    'bathrooms' => '1',
                    'sqr_mt' => '40',
                    'address' => 'Via delle Lastre, 40050 Anconella BO',
                    'latitude' => '44.296357365228936',
                    'longitude' => '11.323694209054464',
                    'image' => 'apartment_img_03.jpg',
                    'visible' => 1,
                    'user_id' => '2'
                ],
                [
                    "title" => 'Hunting Shack in the woods',
                    "rooms" => '2',
                    'beds' => '1',
                    'bathrooms' => '1',
                    'sqr_mt' => '25',
                    'address' => 'Via del Palazzo, 2-6, 40050 Loiano BO',
                    'latitude' => '44.306201185665856',
                    'longitude' => '11.325203734517002',
                    'image' => 'apartment_img_04.jpg',
                    'visible' => 1,
                    'user_id' => '2'
                ],
                [
                    "title" => 'Wooden villa on the beach',
                    "rooms" => '6',
                    'beds' => '3',
                    'bathrooms' => '2',
                    'sqr_mt' => '110',
                    'address' => 'Via Monte Adone, 7, 40036 Brento BO',
                    'latitude' => '44.34053108105043',
                    'longitude' => '11.302567350248411',
                    'image' => 'apartment_img_05.jpg',
                    'visible' => 1,
                    'user_id' => '3'
                ],
                [
                    "title" => 'Colonial Villa for weddings',
                    "rooms" => '12',
                    'beds' => '6',
                    'bathrooms' => '4',
                    'sqr_mt' => '220',
                    'address' => 'Via dei pini, 23-19, 40060 Pianoro BO',
                    'latitude' => '44.37071679102152',
                    'longitude' => '11.333809395834729',
                    'image' => 'apartment_img_06.jpg',
                    'visible' => 1,
                    'user_id' => '3'
                ],
                [
                    "title" => 'La Ponderosa',
                    "rooms" => '2',
                    'beds' => '1',
                    'bathrooms' => '1',
                    'sqr_mt' => '50',
                    'address' => 'Via del Sasso, 40065 Pianoro BO',
                    'latitude' => '44.39309831785993',
                    'longitude' => '11.31437569612145',
                    'image' => 'apartment_img_07.jpg',
                    'visible' => 1,
                    'user_id' => '4'
                ],
                [
                    "title" => 'Liberty Style Villa with ample garden',
                    "rooms" => '19',
                    'beds' => '10',
                    'bathrooms' => '3',
                    'sqr_mt' => '280',
                    'address' => 'Via Pietro Micca, 40033 Casalecchio di Reno BO',
                    'latitude' => '44.45729994248185',
                    'longitude' => '11.278469032851099',
                    'image' => 'apartment_img_08.jpg',
                    'visible' => 1,
                    'user_id' => '4'
                ],
                [
                    "title" => 'The Blue House',
                    "rooms" => '6',
                    'beds' => '3',
                    'bathrooms' => '1',
                    'sqr_mt' => '110',
                    'address' => 'Via Caravaggio, 1, 40133 Bologna BO',
                    'latitude' => '44.504777749535386',
                    'longitude' => '11.30997235082257',
                    'image' => 'apartment_img_09.jpg',
                    'visible' => 1,
                    'user_id' => '5'
                ],
                [
                    "title" => 'Parking Garage in Bologna',
                    "rooms" => '1',
                    'beds' => '1',
                    'bathrooms' => '1',
                    'sqr_mt' => '40',
                    'address' => 'Giardini Margherita Bologna, Viale Giovanni Gozzadini, 40136 Bologna BO',
                    'latitude' => '44.48271369247494',
                    'longitude' => '11.352399865885879',
                    'image' => 'apartment_img_10.jpg',
                    'visible' => 1,
                    'user_id' => '5'
                ],
            ];

        $user_ids = User::all()->pluck('id')->all();

        $sponsors = Sponsor::all();

        $service_ids = Service::all()->pluck('id')->all();

        foreach ($apartments as $index => $apartment) {


            $new_apartment = new Apartment();

            $new_apartment->title = $apartment['title'];
            $new_apartment->rooms = $apartment['rooms'];
            $new_apartment->beds = $apartment['beds'];
            $new_apartment->bathrooms = $apartment['bathrooms'];
            $new_apartment->sqr_mt = $apartment['sqr_mt'];
            $new_apartment->address = $apartment['address'];
            $new_apartment->latitude = $apartment['latitude'];
            $new_apartment->longitude = $apartment['longitude'];
            $new_apartment->image = $apartment['image'];
            $new_apartment->visible = $apartment['visible'];
            $new_apartment->user_id = $apartment['user_id'];
            $new_apartment->save();

            $number_of_services = rand(1, count($service_ids));
            $random_service_ids = $faker->randomElements($service_ids, $number_of_services);
            $new_apartment->services()->attach($random_service_ids);

            $sponsor = $sponsors->random();
            $exp_date = Carbon::now()->addHours($sponsor->hours);

            if ($index % 2) {
                $new_apartment->sponsors()->attach($sponsor->id, ['exp_date' => $exp_date]);
            }
        }

    }
}

