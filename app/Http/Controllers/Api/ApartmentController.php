<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\Message;
use App\Models\Service;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $now = Carbon::now();

        $apartments = Apartment::with('sponsors', 'services')
            ->where('visible', true)
            ->whereHas('sponsors', function ($query) use ($now) {
                $query->where('exp_date', '>', $now);
            })
            ->paginate(6);


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
    public function show($id, Request $request)
    {

        $apartment = Apartment::with('services', 'sponsors')
            ->where('visible', true)->find($id);

        if (!$apartment) {
            return response()->json([
                'success' => false,
                'message' => 'Apartment not found',
            ], 404);
        }

        //Calcola che giorno e' oggi
        $today = Carbon::today();
        //Recupera l'IP dalla richiesta
        $ipAddress = $request->ip();

        //Controlla se c'e` una visualizzazione con questo ip e questo appartamento oggi
        $existingView = View::where('apartment_id', $apartment->id)
            ->where('ip', $ipAddress)
            ->whereDate('created_at', $today)
            ->first();

        //Se non c'e` crea la visualizzazione
        if (!$existingView) {
            View::create([
                'apartment_id' => $apartment->id,
                'ip' => $ipAddress,
            ]);
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

        // Validazione latitude e longitudine
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
        $apartments = Apartment::with('services', 'sponsors')
            ->where('visible', true)->get();

        // Se non trova nessun appartamento da questa risposta
        if ($apartments->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No apartments found',
            ]);
        }

        // Dichiarazione array di appartamenti filtrati
        $filteredApartments = [];

        // Ciclo gli appartamenti per controllare se aggiungerli all'array di filtrati
        foreach ($apartments as $apartment) {
            $lat2 = $apartment->latitude;
            $lon2 = $apartment->longitude;

            $distance = getDistanceBetweenPointsNew($user_lat, $user_lon, $lat2, $lon2, 'kilometers');

            // Controllare se nella richiesta e' stato inviato il campo distance
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

        // Filtrare per numero di letti
        if ($request->beds) {
            $filteredApartments = array_filter($filteredApartments, function ($apartment) use ($request) {
                return $apartment->beds >= $request->beds;
            });
        }

        // Filtrare per numero di stanze
        if ($request->rooms) {
            $filteredApartments = array_filter($filteredApartments, function ($apartment) use ($request) {
                return $apartment->rooms >= $request->rooms;
            });
        }

        // Filtro servizi
        $selectedServices = $request->input('selectedServices', []);
        if (!empty($selectedServices)) {
            $filteredApartments = array_filter($filteredApartments, function ($apartment) use ($selectedServices) {
                $apartment_service_ids = $apartment->services->pluck('id')->toArray();
                foreach ($selectedServices as $service_id) {
                    if (!in_array($service_id, $apartment_service_ids)) {
                        return false;
                    }
                }
                return true;
            });
        }

        usort($filteredApartments, function ($a, $b) {
            // Controllo se A ha uno sponsors
            $aHasActiveSponsor = $a->sponsors()->wherePivot('exp_date', '>', now())->exists();
            // Controllo se B ha uno sponsor attivo
            $bHasActiveSponsor = $b->sponsors()->wherePivot('exp_date', '>', now())->exists();

            // Se a ha lo sponsor attivo va messo prima di b e viceversa
            if ($aHasActiveSponsor && !$bHasActiveSponsor) {
                return -1;
            } elseif (!$aHasActiveSponsor && $bHasActiveSponsor) {
                return 1;
            } else {
                // Altrimenti mettili in ordine di distanza
                return $a->distance - $b->distance;
            }
        });

        $page = $request->page; // Get the current page from the query string, default to page 1 if not provided
        $perPage = 6; // Number of items per page

        // Calculate the items for the current page
        $offset = ($page - 1) * $perPage;
        $paginatedItems = array_slice($filteredApartments, $offset, $perPage);

        // Create the paginator
        $paginatedApartments = new LengthAwarePaginator($paginatedItems, count($filteredApartments), $perPage, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return response()->json([
            'success' => true,
            'apartments' => $paginatedApartments,
            'totalresults' => $filteredApartments
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

    public function message(Request $request)
    {
        // Log the incoming request data for debugging
        Log::info('Incoming request data:', $request->all());

        // Validate the request data
        $validatedData = $request->validate([
            'apartment_id' => 'required|exists:apartments,id',
            'sender_email' => 'required|email',
            'content' => 'required|string',
        ]);

        try {
            // Log the validated data
            Log::info('Validated data:', $validatedData);

            // Create a new message
            $new_message = Message::create($validatedData);

            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error creating message:', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Error creating message'
            ], 500);
        }
    }
}
