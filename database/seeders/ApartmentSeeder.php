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
        $bolognaApartments =
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

        // New apartments for Milan
        $milanApartments =
            [
                [
                    "title" => 'Studio apartment with Duomo view',
                    "rooms" => '1',
                    'beds' => '2',
                    'bathrooms' => '1',
                    'sqr_mt' => '70',
                    'address' => 'Via Monte Napoleone, 20121 Milano MI',
                    'latitude' => '45.4689',
                    'longitude' => '9.1946',
                    'image' => 'milan_apartment_img_1.jpg',
                    'visible' => 1,
                    'user_id' => '6'
                ],
                [
                    "title" => 'Apartment with triple exposure and concierge',
                    "rooms" => '2',
                    'beds' => '1',
                    'bathrooms' => '1',
                    'sqr_mt' => '50',
                    'address' => 'Corso Buenos Aires, 20124 Milano MI',
                    'latitude' => '45.4788',
                    'longitude' => '9.2043',
                    'image' => 'milan_apartment_img_2.jpg',
                    'visible' => 1,
                    'user_id' => '6'
                ],
                [
                    "title" => 'Convenient structure with nearby subway',
                    "rooms" => '4',
                    'beds' => '3',
                    'bathrooms' => '2',
                    'sqr_mt' => '90',
                    'address' => 'Via della Moscova, 20121 Milano MI',
                    'latitude' => '45.4753',
                    'longitude' => '9.1925',
                    'image' => 'milan_apartment_img_3.jpg',
                    'visible' => 1,
                    'user_id' => '7'
                ],
                [
                    "title" => 'Room in the heart of Milan',
                    "rooms" => '3',
                    'beds' => '2',
                    'bathrooms' => '1',
                    'sqr_mt' => '65',
                    'address' => 'Viale Bligny, 20136 Milano MI',
                    'latitude' => '45.4538',
                    'longitude' => '9.1918',
                    'image' => 'milan_apartment_img_4.jpg',
                    'visible' => 1,
                    'user_id' => '7'
                ],
                [
                    "title" => 'Perfect house to live in Via Torino to the fullest',
                    "rooms" => '5',
                    'beds' => '4',
                    'bathrooms' => '3',
                    'sqr_mt' => '110',
                    'address' => 'Via Torino, 20123 Milano MI',
                    'latitude' => '45.4636',
                    'longitude' => '9.1853',
                    'image' => 'milan_apartment_img_5.jpg',
                    'visible' => 1,
                    'user_id' => '8'
                ],
                [
                    "title" => 'Bauscia apartment',
                    "rooms" => '2',
                    'beds' => '1',
                    'bathrooms' => '1',
                    'sqr_mt' => '75',
                    'address' => 'Via Dante, 20121 Milano MI',
                    'latitude' => '45.4656',
                    'longitude' => '9.1858',
                    'image' => 'milan_apartment_img_6.jpg',
                    'visible' => 1,
                    'user_id' => '8'
                ],
                [
                    "title" => '20 square meters of luxury',
                    "rooms" => '3',
                    'beds' => '2',
                    'bathrooms' => '1',
                    'sqr_mt' => '20',
                    'address' => 'Via Savona, 20144 Milano MI',
                    'latitude' => '45.4550',
                    'longitude' => '9.1652',
                    'image' => 'milan_apartment_img_7.jpg',
                    'visible' => 1,
                    'user_id' => '9'
                ],
                [
                    "title" => 'Accommodation with Madunina view',
                    "rooms" => '4',
                    'beds' => '3',
                    'bathrooms' => '2',
                    'sqr_mt' => '95',
                    'address' => 'Via Tortona, 20144 Milano MI',
                    'latitude' => '45.4555',
                    'longitude' => '9.1675',
                    'image' => 'milan_apartment_img_8.jpg',
                    'visible' => 1,
                    'user_id' => '9'
                ],
                [
                    "title" => 'Comfortable old house',
                    "rooms" => '3',
                    'beds' => '2',
                    'bathrooms' => '1',
                    'sqr_mt' => '80',
                    'address' => 'Via Broletto, 20121 Milano MI',
                    'latitude' => '45.4653',
                    'longitude' => '9.1871',
                    'image' => 'milan_apartment_img_9.jpg',
                    'visible' => 1,
                    'user_id' => '10'
                ],
                [
                    "title" => 'Single room to share with two roommates',
                    "rooms" => '1',
                    'beds' => '1',
                    'bathrooms' => '1',
                    'sqr_mt' => '40',
                    'address' => 'Via Meravigli, 20123 Milano MI',
                    'latitude' => '45.4650',
                    'longitude' => '9.1854',
                    'image' => 'milan_apartment_img_10.jpg',
                    'visible' => 1,
                    'user_id' => '10'
                ]
            ];

        // New apartments for Rome
        $romeApartments =
            [
                [
                    "title" => 'Home to experience ancient Rome',
                    "rooms" => '3',
                    'beds' => '2',
                    'bathrooms' => '1',
                    'sqr_mt' => '70',
                    'address' => 'Via del Corso, 00187 Roma RM',
                    'latitude' => '41.9031',
                    'longitude' => '12.4797',
                    'image' => 'rome_apartment_img_1.jpg',
                    'visible' => 1,
                    'user_id' => '11'
                ],
                [
                    "title" => 'Apartment near the Imperial Forums',
                    "rooms" => '2',
                    'beds' => '1',
                    'bathrooms' => '1',
                    'sqr_mt' => '50',
                    'address' => 'Via dei Fori Imperiali, 00184 Roma RM',
                    'latitude' => '41.8946',
                    'longitude' => '12.4853',
                    'image' => 'rome_apartment_img_2.jpg',
                    'visible' => 1,
                    'user_id' => '11'
                ],
                [
                    "title" => 'Anvedi che appartamentino',
                    "rooms" => '4',
                    'beds' => '3',
                    'bathrooms' => '2',
                    'sqr_mt' => '90',
                    'address' => 'Via Veneto, 00187 Roma RM',
                    'latitude' => '41.9055',
                    'longitude' => '12.4939',
                    'image' => 'rome_apartment_img_3.jpg',
                    'visible' => 1,
                    'user_id' => '12'
                ],
                [
                    "title" => 'Convenient accommodation for remote working',
                    "rooms" => '3',
                    'beds' => '2',
                    'bathrooms' => '1',
                    'sqr_mt' => '65',
                    'address' => 'Via della Conciliazione, 00193 Roma RM',
                    'latitude' => '41.9029',
                    'longitude' => '12.4583',
                    'image' => 'rome_apartment_img_4.jpg',
                    'visible' => 1,
                    'user_id' => '12'
                ],
                [
                    "title" => 'Small but characteristic house',
                    "rooms" => '5',
                    'beds' => '4',
                    'bathrooms' => '3',
                    'sqr_mt' => '30',
                    'address' => 'Piazza Navona, 00186 Roma RM',
                    'latitude' => '41.8989',
                    'longitude' => '12.4733',
                    'image' => 'rome_apartment_img_5.jpg',
                    'visible' => 1,
                    'user_id' => '13'
                ],
                [
                    "title" => 'Renovated villa',
                    "rooms" => '2',
                    'beds' => '1',
                    'bathrooms' => '1',
                    'sqr_mt' => '55',
                    'address' => 'Via del Tritone, 00187 Roma RM',
                    'latitude' => '41.9034',
                    'longitude' => '12.4901',
                    'image' => 'rome_apartment_img_6.jpg',
                    'visible' => 1,
                    'user_id' => '13'
                ],
                [
                    "title" => 'Perfect apartment for a romantic weekend',
                    "rooms" => '3',
                    'beds' => '2',
                    'bathrooms' => '1',
                    'sqr_mt' => '75',
                    'address' => 'Via Cassia, 00189 Roma RM',
                    'latitude' => '41.9404',
                    'longitude' => '12.4435',
                    'image' => 'rome_apartment_img_7.jpg',
                    'visible' => 1,
                    'user_id' => '14'
                ],
                [
                    "title" => 'Typical Roman house with suggestive view',
                    "rooms" => '4',
                    'beds' => '3',
                    'bathrooms' => '2',
                    'sqr_mt' => '95',
                    'address' => 'Via Aurelia, 00165 Roma RM',
                    'latitude' => '41.8984',
                    'longitude' => '12.4438',
                    'image' => 'rome_apartment_img_8.jpg',
                    'visible' => 1,
                    'user_id' => '14'
                ],
                [
                    "title" => 'Modern accommodation with garden',
                    "rooms" => '3',
                    'beds' => '2',
                    'bathrooms' => '1',
                    'sqr_mt' => '80',
                    'address' => 'Via Flaminia, 00197 Roma RM',
                    'latitude' => '41.9250',
                    'longitude' => '12.4794',
                    'image' => 'rome_apartment_img_9.jpg',
                    'visible' => 1,
                    'user_id' => '15'
                ],
                [
                    "title" => 'Apartment with strategic location',
                    "rooms" => '2',
                    'beds' => '1',
                    'bathrooms' => '1',
                    'sqr_mt' => '60',
                    'address' => 'Via Appia Antica, 00179 Roma RM',
                    'latitude' => '41.8563',
                    'longitude' => '12.5287',
                    'image' => 'rome_apartment_img_10.jpg',
                    'visible' => 1,
                    'user_id' => '15'
                ]
            ];

        // New apartments for Naples
        $naplesApartments =
            [
                [
                    "title" => 'Neo-baroque house',
                    "rooms" => '3',
                    'beds' => '2',
                    'bathrooms' => '1',
                    'sqr_mt' => '70',
                    'address' => 'Via Toledo, 80134 Napoli NA',
                    'latitude' => '40.8354',
                    'longitude' => '14.2504',
                    'image' => 'naples_apartment_img_1.jpg',
                    'visible' => 1,
                    'user_id' => '16'
                ],
                [
                    "title" => 'Vintage apartment with various options',
                    "rooms" => '2',
                    'beds' => '1',
                    'bathrooms' => '1',
                    'sqr_mt' => '50',
                    'address' => 'Viale Colli Aminei, 80131 Napoli NA',
                    'latitude' => '40.8637',
                    'longitude' => '14.2495',
                    'image' => 'naples_apartment_img_2.jpg',
                    'visible' => 1,
                    'user_id' => '16'
                ],
                [
                    "title" => 'Stay in full Neapolitan spirit',
                    "rooms" => '4',
                    'beds' => '3',
                    'bathrooms' => '2',
                    'sqr_mt' => '90',
                    'address' => 'Via dei Mille, 80121 Napoli NA',
                    'latitude' => '40.8409',
                    'longitude' => '14.2503',
                    'image' => 'naples_apartment_img_3.jpg',
                    'visible' => 1,
                    'user_id' => '17'
                ],
                [
                    "title" => 'The garden of lovers',
                    "rooms" => '3',
                    'beds' => '2',
                    'bathrooms' => '1',
                    'sqr_mt' => '65',
                    'address' => 'Via Caracciolo, 80122 Napoli NA',
                    'latitude' => '40.8311',
                    'longitude' => '14.2355',
                    'image' => 'naples_apartment_img_4.jpg',
                    'visible' => 1,
                    'user_id' => '17'
                ],
                [
                    "title" => 'Here you will cry twice',
                    "rooms" => '5',
                    'beds' => '4',
                    'bathrooms' => '3',
                    'sqr_mt' => '110',
                    'address' => 'Via Chiaia, 80121 Napoli NA',
                    'latitude' => '40.8316',
                    'longitude' => '14.2426',
                    'image' => 'naples_apartment_img_5.jpg',
                    'visible' => 1,
                    'user_id' => '18'
                ],
                [
                    "title" => 'Bijou villa',
                    "rooms" => '2',
                    'beds' => '1',
                    'bathrooms' => '1',
                    'sqr_mt' => '55',
                    'address' => 'Via San Gregorio Armeno, 80138 Napoli NA',
                    'latitude' => '40.8500',
                    'longitude' => '14.2533',
                    'image' => 'naples_apartment_img_6.jpg',
                    'visible' => 1,
                    'user_id' => '18'
                ],
                [
                    "title" => 'House sun and sea',
                    "rooms" => '3',
                    'beds' => '2',
                    'bathrooms' => '1',
                    'sqr_mt' => '75',
                    'address' => 'Via Roma, 80133 Napoli NA',
                    'latitude' => '40.8478',
                    'longitude' => '14.2550',
                    'image' => 'naples_apartment_img_7.jpg',
                    'visible' => 1,
                    'user_id' => '19'
                ],
                [
                    "title" => 'O\' sole mio',
                    "rooms" => '4',
                    'beds' => '3',
                    'bathrooms' => '2',
                    'sqr_mt' => '95',
                    'address' => 'Via Toledo, 80135 Napoli NA',
                    'latitude' => '40.8405',
                    'longitude' => '14.2507',
                    'image' => 'naples_apartment_img_8.jpg',
                    'visible' => 1,
                    'user_id' => '19'
                ],
                [
                    "title" => 'Modern and relaxing apartment',
                    "rooms" => '3',
                    'beds' => '2',
                    'bathrooms' => '1',
                    'sqr_mt' => '80',
                    'address' => 'Via Partenope, 80121 Napoli NA',
                    'latitude' => '40.8315',
                    'longitude' => '14.2502',
                    'image' => 'naples_apartment_img_9.jpg',
                    'visible' => 1,
                    'user_id' => '20'
                ],
                [
                    "title" => 'Dream house',
                    "rooms" => '2',
                    'beds' => '1',
                    'bathrooms' => '1',
                    'sqr_mt' => '60',
                    'address' => 'Via Benedetto Croce, 80134 Napoli NA',
                    'latitude' => '40.8371',
                    'longitude' => '14.2490',
                    'image' => 'naples_apartment_img_10.jpg',
                    'visible' => 1,
                    'user_id' => '20'
                ]
            ];

        // New apartments for Florence
        $florenceApartments =
            [
                [
                    "title" => 'The Florentine house par excellence',
                    "rooms" => '3',
                    'beds' => '2',
                    'bathrooms' => '1',
                    'sqr_mt' => '70',
                    'address' => 'Piazza della Signoria, 50122 Firenze FI',
                    'latitude' => '43.7696',
                    'longitude' => '11.2558',
                    'image' => 'florence_apartment_img_1.jpg',
                    'visible' => 1,
                    'user_id' => '21'
                ],
                [
                    "title" => 'The house of the truffle',
                    "rooms" => '2',
                    'beds' => '1',
                    'bathrooms' => '1',
                    'sqr_mt' => '50',
                    'address' => 'Via dei Calzaiuoli, 50122 Firenze FI',
                    'latitude' => '43.7703',
                    'longitude' => '11.2543',
                    'image' => 'florence_apartment_img_2.jpg',
                    'visible' => 1,
                    'user_id' => '21'
                ],
                [
                    "title" => 'Dante\'s hiding place',
                    "rooms" => '4',
                    'beds' => '3',
                    'bathrooms' => '2',
                    'sqr_mt' => '90',
                    'address' => 'Piazza del Duomo, 50122 Firenze FI',
                    'latitude' => '43.7730',
                    'longitude' => '11.2555',
                    'image' => 'florence_apartment_img_3.jpg',
                    'visible' => 1,
                    'user_id' => '22'
                ],
                [
                    "title" => 'House on the bridge',
                    "rooms" => '3',
                    'beds' => '2',
                    'bathrooms' => '1',
                    'sqr_mt' => '65',
                    'address' => 'Via de\' Tornabuoni, 50123 Firenze FI',
                    'latitude' => '43.7683',
                    'longitude' => '11.2534',
                    'image' => 'florence_apartment_img_4.jpg',
                    'visible' => 1,
                    'user_id' => '22'
                ],
                [
                    "title" => 'Brightly lit house full of positive energy',
                    "rooms" => '5',
                    'beds' => '4',
                    'bathrooms' => '3',
                    'sqr_mt' => '110',
                    'address' => 'Piazza Santa Croce, 50122 Firenze FI',
                    'latitude' => '43.7682',
                    'longitude' => '11.2607',
                    'image' => 'florence_apartment_img_5.jpg',
                    'visible' => 1,
                    'user_id' => '23'
                ],
                [
                    "title" => 'Modern accommodation',
                    "rooms" => '2',
                    'beds' => '1',
                    'bathrooms' => '1',
                    'sqr_mt' => '55',
                    'address' => 'Piazza della Repubblica, 50123 Firenze FI',
                    'latitude' => '43.7764',
                    'longitude' => '11.2494',
                    'image' => 'florence_apartment_img_6.jpg',
                    'visible' => 1,
                    'user_id' => '23'
                ],
                [
                    "title" => 'Study for smart work',
                    "rooms" => '3',
                    'beds' => '2',
                    'bathrooms' => '1',
                    'sqr_mt' => '75',
                    'address' => 'Piazza Santo Spirito, 50125 Firenze FI',
                    'latitude' => '43.7666',
                    'longitude' => '11.2488',
                    'image' => 'florence_apartment_img_7.jpg',
                    'visible' => 1,
                    'user_id' => '24'
                ],
                [
                    "title" => 'House of serenity',
                    "rooms" => '4',
                    'beds' => '3',
                    'bathrooms' => '2',
                    'sqr_mt' => '95',
                    'address' => 'Piazza Pitti, 50125 Firenze FI',
                    'latitude' => '43.7670',
                    'longitude' => '11.2489',
                    'image' => 'florence_apartment_img_8.jpg',
                    'visible' => 1,
                    'user_id' => '24'
                ],
                [
                    "title" => 'We eat well here',
                    "rooms" => '3',
                    'beds' => '2',
                    'bathrooms' => '1',
                    'sqr_mt' => '80',
                    'address' => 'Via de\' Cerretani, 50123 Firenze FI',
                    'latitude' => '43.7737',
                    'longitude' => '11.2490',
                    'image' => 'florence_apartment_img_9.jpg',
                    'visible' => 1,
                    'user_id' => '25'
                ],
                [
                    "title" => 'The small hill of Florence',
                    "rooms" => '2',
                    'beds' => '1',
                    'bathrooms' => '1',
                    'sqr_mt' => '60',
                    'address' => 'Via Maggio, 50125 Firenze FI',
                    'latitude' => '43.7653',
                    'longitude' => '11.2469',
                    'image' => 'florence_apartment_img_10.jpg',
                    'visible' => 1,
                    'user_id' => '25'
                ]
            ];

        // New apartments for Turin
        $turinApartments =
            [
                [
                    "title" => 'Apartment Belin',
                    "rooms" => '3',
                    'beds' => '2',
                    'bathrooms' => '1',
                    'sqr_mt' => '70',
                    'address' => 'Via Po, 10123 Torino TO',
                    'latitude' => '45.0705',
                    'longitude' => '7.6823',
                    'image' => 'turin_apartment_img_1.jpg',
                    'visible' => 1,
                    'user_id' => '26'
                ],
                [
                    "title" => 'House overlooking the Mole',
                    "rooms" => '2',
                    'beds' => '1',
                    'bathrooms' => '1',
                    'sqr_mt' => '50',
                    'address' => 'Via Garibaldi, 10122 Torino TO',
                    'latitude' => '45.0672',
                    'longitude' => '7.6826',
                    'image' => 'turin_apartment_img_2.jpg',
                    'visible' => 1,
                    'user_id' => '26'
                ],
                [
                    "title" => 'Vintage room with a welcoming mood',
                    "rooms" => '4',
                    'beds' => '3',
                    'bathrooms' => '2',
                    'sqr_mt' => '90',
                    'address' => 'Via Roma, 10121 Torino TO',
                    'latitude' => '45.0706',
                    'longitude' => '7.6872',
                    'image' => 'turin_apartment_img_3.jpg',
                    'visible' => 1,
                    'user_id' => '27'
                ],
                [
                    "title" => 'Gran Torino apartment',
                    "rooms" => '3',
                    'beds' => '2',
                    'bathrooms' => '1',
                    'sqr_mt' => '65',
                    'address' => 'Via Po, 10124 Torino TO',
                    'latitude' => '45.0664',
                    'longitude' => '7.6877',
                    'image' => 'turin_apartment_img_4.jpg',
                    'visible' => 1,
                    'user_id' => '27'
                ],
                [
                    "title" => 'The house of Vermouth',
                    "rooms" => '5',
                    'beds' => '4',
                    'bathrooms' => '3',
                    'sqr_mt' => '110',
                    'address' => 'Piazza Vittorio Veneto, 10123 Torino TO',
                    'latitude' => '45.0707',
                    'longitude' => '7.6843',
                    'image' => 'turin_apartment_img_5.jpg',
                    'visible' => 1,
                    'user_id' => '28'
                ],
                [
                    "title" => 'Alessandro\'s house with dirty sink',
                    "rooms" => '2',
                    'beds' => '1',
                    'bathrooms' => '1',
                    'sqr_mt' => '55',
                    'address' => 'Corso Vittorio Emanuele II, 10123 Torino TO',
                    'latitude' => '45.0736',
                    'longitude' => '7.6841',
                    'image' => 'turin_apartment_img_6.jpg',
                    'visible' => 1,
                    'user_id' => '28'
                ],
                [
                    "title" => 'Home automation apartment with latest technologies',
                    "rooms" => '3',
                    'beds' => '2',
                    'bathrooms' => '1',
                    'sqr_mt' => '75',
                    'address' => 'Via Milano, 10122 Torino TO',
                    'latitude' => '45.0699',
                    'longitude' => '7.6902',
                    'image' => 'turin_apartment_img_7.jpg',
                    'visible' => 1,
                    'user_id' => '29'
                ],
                [
                    "title" => 'Room with study area',
                    "rooms" => '4',
                    'beds' => '3',
                    'bathrooms' => '2',
                    'sqr_mt' => '95',
                    'address' => 'Via Pietro Micca, 10121 Torino TO',
                    'latitude' => '45.0694',
                    'longitude' => '7.6825',
                    'image' => 'turin_apartment_img_8.jpg',
                    'visible' => 1,
                    'user_id' => '29'
                ],
                [
                    "title" => 'Apartment with park view',
                    "rooms" => '3',
                    'beds' => '2',
                    'bathrooms' => '1',
                    'sqr_mt' => '80',
                    'address' => 'Via Po, 10125 Torino TO',
                    'latitude' => '45.0643',
                    'longitude' => '7.6835',
                    'image' => 'turin_apartment_img_9.jpg',
                    'visible' => 1,
                    'user_id' => '30'
                ],
                [
                    "title" => 'Shabby chic house',
                    "rooms" => '2',
                    'beds' => '1',
                    'bathrooms' => '1',
                    'sqr_mt' => '60',
                    'address' => 'Corso Regina Margherita, 10123 Torino TO',
                    'latitude' => '45.0605',
                    'longitude' => '7.6843',
                    'image' => 'turin_apartment_img_10.jpg',
                    'visible' => 1,
                    'user_id' => '30'
                ]
            ];

        //Uniamo gli array
        $allApartments = array_merge(
            $bolognaApartments,
            $milanApartments,
            $romeApartments,
            $naplesApartments,
            $florenceApartments,
            $turinApartments
        );

        /* shuffle($allApartments); */
        //Volendo si possono mescolare per non averli sempre nello stesso ordine

        $user_ids = User::all()->pluck('id')->all();

        $sponsors = Sponsor::all();

        $service_ids = Service::all()->pluck('id')->all();

        foreach ($allApartments as $index => $apartment) {


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

