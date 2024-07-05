<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = $request->perPage ?? 6;
        $now = Carbon::now();

        $apartments = Apartment::with('sponsors', 'services')
            ->whereHas('sponsors', function ($query) use ($now) {
                $query->where('exp_date', '>', $now);
            })
            ->paginate($per_page);


        return response()->json([
            'success' => true,
            'apartments' => $apartments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApartmentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $apartment = Apartment::with('services', 'sponsors')->find($id);

        if (!$apartment) {
            return response()->json([
                'success' => false,
                'message' => 'Apartment not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'apartment' => $apartment,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        //
    }

    /**
     * Ricerca di appartamenti entro 20km
     */
    public function search(Request $request)
    {


        function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'kilometers')
        {
            $theta = $longitude1 - $longitude2;
            $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
            $distance = acos($distance);
            $distance = rad2deg($distance);
            $distance = $distance * 60 * 1.1515;
            switch ($unit) {
                case 'miles':
                    break;
                case 'kilometers':
                    $distance = $distance * 1.609344;
            }
            return (round($distance, 2));
        }
        ;



        //Validazione latitude e longitudine
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Recuperare dati dalla richiesta
        $user_lat = $request->input('latitude');
        $user_lon = $request->input('longitude');

        // Controllo per vedere se latitudine e longitudine esistono
        if (is_null($user_lat) || is_null($user_lon)) {
            return response()->json([
                'success' => false,
                'message' => 'Latitude and Longitude are required',
            ]);
        }

        // Recuperare tutti gli appartamenti con le loro relazioni
        $apartments = Apartment::with('services', 'sponsors')->get();

        // Se non trova nessun appartamento da questa risposta
        if ($apartments->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No apartments found',
            ]);
        }

        // Dichiarazione array di appartamenti filtrati
        $filteredApartments = [];




        //Ciclo gli appartamenti per controllare se aggiungerli all'array di filtrati
        foreach ($apartments as $apartment) {
            $lat2 = $apartment->latitude;
            $lon2 = $apartment->longitude;

            $distance = getDistanceBetweenPointsNew($user_lat, $user_lon, $lat2, $lon2, $unit = 'kilometers');

            //Controllare se nella richiesta e' stato inviato il campo distance
            if ($request->distance) {
                $request_distance = $request->distance;
                if ($distance <= $request_distance) {
                    $apartment->distance = $distance;
                    $filteredApartments[] = $apartment;
                }
            } else {
                if ($distance <= 20) {
                    $apartment->distance = $distance;
                    $filteredApartments[] = $apartment;
                }
            }
        }


        //Se nella richiesta ci sono letti, allora filteredApartments lo cicliamo, e ogni appartamento che NON supera il controllo viene tolto dall'array

        if ($request->beds) {
            $filteredApartments = array_filter($filteredApartments, function ($apartment) use ($request) {
                return $apartment->beds >= $request->beds;
            });
        }

        if ($request->rooms) {
            $filteredApartments = array_filter($filteredApartments, function ($apartment) use ($request) {
                return $apartment->rooms >= $request->rooms;
            });
        }

        if ($request->services) {

            if (is_array($request->services)) {
                $service_ids = $request->services;

                // Filter apartments
                foreach ($service_ids as $service_id) {
                    $filteredApartments = array_filter($filteredApartments, function ($apartment) use ($service_id) {
                        // Extract service IDs from apartment services collection
                        $apartment_services_ids = $apartment->services->pluck('id')->toArray();

                        return in_array($service_id, $apartment_services_ids);
                    });
                }
            } else {

                $service_ids = $request->services;

                // Filter apartments
                $filteredApartments = array_filter($filteredApartments, function ($apartment) use ($service_ids) {
                    // Extract service IDs from apartment services collection
                    $apartment_services_ids = $apartment->services->pluck('id')->toArray();

                    return in_array($service_ids, $apartment_services_ids);
                });
            }
        }
        usort($filteredApartments, function ($a, $b) {
            return $a->distance - $b->distance;
        });

        return response()->json([
            'success' => true,
            'apartments' => $filteredApartments,
        ]);
    }

    //Recupero dei servizi nella pagina di ricerca avanzata
    public function services(Request $request)
    {
        $services = Service::all();


        return response()->json([
            'success' => true,
            'services' => $services,
        ]);

    }
}
