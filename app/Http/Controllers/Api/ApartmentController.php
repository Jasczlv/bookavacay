<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

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

        // Define the API key
        $apiKey = 'VtdGJcQDaomboK5S3kbxFvhtbupZjoK0';

        // Initialize Guzzle client
        $client = new Client([
            'base_uri' => 'https://api.tomtom.com',
            'verify' => 'C:\phpLauncher\ssl\cacert.pem', // Path to your cacert.pem
        ]);

        foreach ($apartments as $apartment) {
            $lat2 = $apartment->latitude;
            $lon2 = $apartment->longitude;

            try {
                // Make request using Guzzle
                $response = $client->request('GET', "/routing/1/calculateRoute/{$user_lat},{$user_lon}:{$lat2},{$lon2}/json", [
                    'query' => ['key' => $apiKey],
                ]);

                $output = $response->getBody()->getContents();

                // Decode the JSON response
                $data = json_decode($output, true);

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
            } catch (\Exception $e) {
                Log::error('Guzzle HTTP Error: ' . $e->getMessage());
                continue; // Skip this apartment if there's an error
            }
        }

        // Return raw API responses for debugging
        return response()->json([
            'success' => true,
            'filtered_apartments' => $filteredApartments,
        ]);
    }
}
