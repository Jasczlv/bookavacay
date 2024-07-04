<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
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
    public function show(Apartment $apartment)
    {
        //
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


        // Chiave API da usare per le richieste
        $apiKey = 'VtdGJcQDaomboK5S3kbxFvhtbupZjoK0';

        //Ciclo gli appartamenti per controllare se aggiungerli all'array di filtrati
        foreach ($apartments as $apartment) {
            $lat2 = $apartment->latitude;
            $lon2 = $apartment->longitude;

            // Build the API URL
            $url = "https://api.tomtom.com/routing/1/calculateRoute/{$user_lat},{$user_lon}:{$lat2},{$lon2}/json?key={$apiKey}";

            // Initialize cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Verify SSL certificate
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);   // Verify SSL hostname

            // Execute the request
            $output = curl_exec($ch);

            // Check for cURL errors
            if (curl_errno($ch)) {
                Log::error('cURL Error: ' . curl_error($ch));
                curl_close($ch);
                continue; // Skip this apartment if there's an error
            }

            curl_close($ch);

            // Decode the JSON response
            $data = json_decode($output, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON Decode Error: ' . json_last_error_msg());
                continue; // Skip this apartment if JSON decoding fails
            }

            if (isset($data['routes'][0]['summary']['lengthInMeters'])) {
                $distance = floor($data['routes'][0]['summary']['lengthInMeters'] / 1000); // Convert meters to kilometers

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

            } else {
                Log::error('Unexpected API response: ' . $output);
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
            $service_id = $request->services;

            // Filter apartments
            $filteredApartments = array_filter($filteredApartments, function ($apartment) use ($service_id) {
                // Extract service IDs from apartment services collection
                $apartment_services_ids = $apartment->services->pluck('id')->toArray();

                return in_array($service_id, $apartment_services_ids);
            });
        }

        return response()->json([
            'success' => true,
            'apartments' => $filteredApartments,
        ]);
    }
}
