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
        // Get user latitude and longitude from the request
        $user_lat = $request->query('latitude');
        $user_lon = $request->query('longitude');
        Log::info('Latitude: ' . $user_lat);
        Log::info('Longitude: ' . $user_lon);

        // Check if latitude and longitude are provided
        if (is_null($user_lat) || is_null($user_lon)) {
            return response()->json([
                'success' => false,
                'message' => 'Latitude and Longitude are required',
            ]);
        }

        // Get all apartments
        $apartments = Apartment::with('sponsors', 'services')->get();

        // Check if apartments are being retrieved
        if ($apartments->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No apartments found',
            ]);
        }

        $filteredApartments = [];

        $testResults = [];

        // Define the API key
        $apiKey = 'VtdGJcQDaomboK5S3kbxFvhtbupZjoK0';

        foreach ($apartments as $apartment) {
            $lat2 = $apartment->latitude;
            $lon2 = $apartment->longitude;
            $testResults[] = $lat2;
            $testResults[] = $lon2;

            // Build the API URL
            $url = "https://api.tomtom.com/routing/1/calculateRoute/{$user_lat},{$user_lon}:{$lat2},{$lon2}/json?key={$apiKey}";
            Log::info('API URL: ' . $url);

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
                Log::info("Distance for Apartment ID {$apartment->id}: {$distance} km");

                if ($distance <= 20) {
                    $apartment->distance = $distance;
                    $filteredApartments[] = $apartment;
                }
            } else {
                Log::error('Unexpected API response: ' . $output);
            }
        }

        /* return response()->json([
            'success' => true,
            'apartments' => $filteredApartments,
        ]); */

        return response()->json([
            'success' => true,
            'apartments' => $filteredApartments,
        ]);
    }
}
