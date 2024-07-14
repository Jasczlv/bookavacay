<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\Apartment;
use App\Models\Message;
use App\Models\Service;
use App\Models\Sponsor;
use App\Models\User;
use App\Models\View;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Braintree\Gateway;
use Illuminate\Support\Facades\Session;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $apartments = Apartment::where('user_id', $user->id)->get()->map(function ($apartment) {
            $apartment->unread_messages_count = Message::where('apartment_id', $apartment->id)
                ->where('notification', true)
                ->count();
            return $apartment;
        });

        //api json response
        if ($request->wantsJson()) {
            return response()->json($apartments);
        }

        return view('admin.apartments.index', compact('apartments', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::orderBy('name', 'asc')->get();
        $users = User::orderBy('id', 'asc')->get();

        return view('admin.apartments.create', compact('users', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApartmentRequest $request)
    {

        $form_data = $request->validated();
        $new_apartment = Apartment::create($form_data);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('images', 'public');
            // Remove 'images/' from the beginning of the path
            $path = str_replace('images/', '', $path);
            $new_apartment->image = $path;
        } else {
            $new_apartment->image = 'https://picsum.photos/300/200?random=' . $new_apartment->id;
        }

        $new_apartment->save();

        if ($request->has('services')) {
            foreach ($form_data['services'] as $service_id) {
                $new_apartment->services()->attach($service_id);
            }
        }
        return redirect()->route('admin.apartments.index', $new_apartment)->with('newApartment', $new_apartment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        return view('admin.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        $services = Service::orderBy('name', 'asc')->get();
        $users = User::orderBy('id', 'asc')->get();

        return view('admin.apartments.edit', compact('apartment', 'services', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        $form_data = $request->validated();
        // dd($form_data);

        if ($request->has('services')) {
            $apartment->services()->sync($form_data['services']);
        }

        if ($request->hasFile('image_file')) {
            // Optionally delete the old image if it exists
            if ($apartment->image) {
                Storage::disk('public')->delete('images/' . $apartment->image);
            }

            $file = $request->file('image_file');
            $path = $file->store('images', 'public');
            // Remove 'images/' from the beginning of the path
            $path = str_replace('images/', '', $path);
            $form_data['image'] = $path;
        }

        $apartment->update($form_data);

        return redirect()->route('admin.apartments.index')->with('success', 'Apartment updated successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();

        return redirect()->route('admin.apartments.index');
    }
    // Apartments filter method
    public function search(Request $request)
    {
        $user_id = $request->user()->id;

        $query = $request->input('query');

        $apartments = Apartment::where('title', 'LIKE', "%{$query}%")->where('user_id', '=', $user_id)
            ->get();

        return view('admin.apartments.index', compact('apartments'));
    }
    public function messages(Apartment $apartment, Message $message, Request $request)
    {
        $messages = Message::where('apartment_id', $apartment->id)
            ->where('notification', false)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($message) {
                $message->formatted_date = Carbon::parse($message->created_at)->format('Y-m-d');
                $message->formatted_time = Carbon::parse($message->created_at)->format('H:i:s');
                return $message;
            });

        $notifications = Message::where('apartment_id', $apartment->id)
            ->where('notification', true)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($notifications as $notification) {
            $notification->notification = false;
            $notification->save();
        }

        // Format the notifications after saving
        $notifications = $notifications->map(function ($message) {
            $message->formatted_date = Carbon::parse($message->created_at)->format('Y-m-d');
            $message->formatted_time = Carbon::parse($message->created_at)->format('H:i:s');
            return $message;
        });

        return view('admin.apartments.messages', compact('messages', 'apartment', 'notifications'));
    }



    public function statistics(Apartment $apartment, View $view, Request $request)
    {
        $statistics = View::where('apartment_id', $apartment->id)->get();

        // Dichiariamo gli array vuoti per i mesi
        $months = [];
        $monthlyViews = [];
        $otherApartmentsViews = [];
        $monthlyAverageViews = [];

        // Recuperiamo mese ed anno corrente
        $currentMonth = (int) date('m');
        $currentYear = (int) date('Y');

        // Recuperiamo tutti gli appartamenti dello stesso proprietario
        $userApartments = $apartment->user->apartments;

        // Inizializziamo l'array per memorizzare le visite per ogni appartamento
        foreach ($userApartments as $userApartment) {
            if ($userApartment->id !== $apartment->id) {
                $otherApartmentsViews[$userApartment->title] = [];
            }
        }

        // Funzione per calcolare la distanza
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

        // Recuperiamo tutti gli appartamenti entro 30 km
        $nearbyApartments = Apartment::all()->filter(function ($otherApartment) use ($apartment) {
            return getDistanceBetweenPointsNew(
                $apartment->latitude,
                $apartment->longitude,
                $otherApartment->latitude,
                $otherApartment->longitude
            ) <= 30;
        });

        // Ora iteriamo 12 volte a ritroso
        for ($i = 0; $i < 12; $i++) {
            $month = $currentMonth - $i;
            $year = $currentYear;

            // Se il mese viene negativo, diminuiamo l'anno di 1 e aumentiamo il mese di 12
            if ($month < 1) {
                $month += 12;
                $year--;
            }

            // Recuperiamo il nome del mese.'F' serve per il formato, in questo caso ti da il Full name. mktime e' il formato, che ti chiede ore(0), minuti(0), secondi(0), mese($month), e giorno. Ho messo un numero a caso per il giorno
            $monthName = date('F', mktime(0, 0, 0, $month, 10));
            array_unshift($months, $monthName); // Aggiunge all'inizio dell'array invece che in fondo

            // Recuperiamo le visite per quel mese e le mettiamo nell'array
            $views = View::where('apartment_id', $apartment->id)
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->count();
            array_unshift($monthlyViews, $views);

            // Recuperiamo le visite per gli altri appartamenti dello stesso proprietario
            foreach ($userApartments as $userApartment) {
                if ($userApartment->id !== $apartment->id) {
                    $viewsOtherApartment = View::where('apartment_id', $userApartment->id)
                        ->whereYear('created_at', $year)
                        ->whereMonth('created_at', $month)
                        ->count();
                    array_unshift($otherApartmentsViews[$userApartment->title], $viewsOtherApartment);
                }
            }

            // Recuperiamo le visite totali per gli appartamenti entro 30 km
            $totalViews = View::whereIn('apartment_id', $nearbyApartments->pluck('id'))
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->count();

            // Calcoliamo la media delle visite per gli appartamenti entro 30 km
            $averageViews = $nearbyApartments->count() > 0 ? $totalViews / $nearbyApartments->count() : 0;
            array_unshift($monthlyAverageViews, $averageViews);
        }

        // Calcoliamo il mese con il massimo di visualizzazioni
        $highestViews = max($monthlyViews);
        $highestMonth = $months[array_search($highestViews, $monthlyViews)];

        // Escludiamo il mese corrente per trovare il mese con il minimo di visualizzazioni
        $filteredMonthlyViews = array_slice($monthlyViews, 0, -1); // Escludiamo l'ultimo elemento (mese corrente)
        $filteredMonths = array_slice($months, 0, -1); // Escludiamo l'ultimo elemento (mese corrente)

        $lowestViews = min($filteredMonthlyViews);
        $lowestMonth = $filteredMonths[array_search($lowestViews, $filteredMonthlyViews)];

        // Calcoliamo il ranking dell'appartamento nell'area di 30km
        $totalViewsForCurrentApartment = View::where('apartment_id', $apartment->id)->count();
        $nearbyApartmentsSorted = $nearbyApartments->sortByDesc(function ($apartment) {
            return View::where('apartment_id', $apartment->id)->count();
        });
        $ranking = $nearbyApartmentsSorted->pluck('id')->search($apartment->id) + 1;

        // Creiamo gli array dei dataset per il grafico
        $datasets = [
            [
                "label" => "Monthly Apartment Views",
                'backgroundColor' => "#FFB44066",
                'borderColor' => "#F7851D",
                "pointBorderColor" => "#2889B6",
                "pointBackgroundColor" => "#95CFE9",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                "data" => $monthlyViews,
                "fill" => true,
            ],
            [
                "label" => "Average Views (Within 30km)",
                'backgroundColor' => "#6666FF66",
                'borderColor' => "#1D1DF7",
                "pointBorderColor" => "#8928B6",
                "pointBackgroundColor" => "#CF95E9",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                "data" => $monthlyAverageViews,
                "fill" => true,
            ]
        ];

        // Aggiungiamo i dataset per ogni altro appartamento
        foreach ($userApartments as $userApartment) {
            if ($userApartment->id !== $apartment->id) {
                $datasets[] = [
                    "label" => "Views for " . $userApartment->title,
                    'backgroundColor' => "#" . substr(md5($userApartment->title), 0, 6) . "66", // Unique color based on title
                    'borderColor' => "#" . substr(md5($userApartment->title), 0, 6),
                    "pointBorderColor" => "#B68928",
                    "pointBackgroundColor" => "#E9CF95",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    "data" => $otherApartmentsViews[$userApartment->title],
                    "fill" => true,
                ];
            }
        }

        // Creiamo il grafico con i dati precedenti
        $chartjs = app()->chartjs
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($months)
            ->datasets($datasets)
            ->options([
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
            ]);

        return view('admin.apartments.statistics', compact('statistics', 'apartment', 'chartjs', 'highestMonth', 'lowestMonth', 'ranking'));
    }




    public function sponsors(Apartment $apartment, Sponsor $sponsor, Request $request)
    {
        $apartments = Apartment::where('user_id', $request->user()->id)->get();
        $sponsors = Sponsor::all();

        //Cicliamo ogni appartamento posseduto dall'utente
        foreach ($apartments as $apartment) {
            //Ci salviamo in una variabile l'appartamento sponsorizzato se
            $apartmentWithActiveSponsors = Apartment::with([
                'sponsors' => function ($query) {
                    $query->where('exp_date', '>', now())   //lo sponsor scade nel futuro
                        ->orderBy('exp_date', 'desc')   //in ordine decrescente
                        ->take(1);  //prendiamo il primo
                }
            ])
                ->findOrFail($apartment->id); //Questo serve a dirgli di cercare solo relazioni corrispondenti all'appartamento che stiamo ciclando adesso con il suo ID

            //Se ne ha trovato uno gli mettiamo la proprieta' sponsor_expiration uguale all'exp_date dello sponsor che ha trovato
            if ($apartmentWithActiveSponsors->sponsors->isNotEmpty()) {
                $latestSponsor = $apartmentWithActiveSponsors->sponsors->first();
                $apartment->sponsor_expiration = $latestSponsor->pivot->exp_date;
                //Se no nada
            } else {
                $apartment->sponsor_expiration = null;
            }
        }

        $clientToken = $this->generateClientToken();

        Session::put('clientToken', $clientToken);

        return view('admin.apartments.sponsors', [
            'apartments' => $apartments,
            'sponsors' => $sponsors,
        ]);
    }
    public function new_sponsor(Request $request)
    {
        //Validazione
        $request->validate([
            'selected_apartment' => 'required|exists:apartments,id',
            'selected_sponsor' => 'required|exists:sponsors,id',
            'sponsor_hours' => 'required|integer',
            'payment_method_nonce' => 'required|string',
        ]);


        //recupero tutti i parametri passati dal form
        $apartmentId = $request->input('selected_apartment');
        $apartmentSponsorExpiration = $request->input('apartment_sponsor_expiration');
        $selectedSponsorId = $request->input('selected_sponsor');
        $selectedSponsorHours = (int) $request->input('sponsor_hours');

        //trovo l'appartamento con l'id
        $apartment = Apartment::where('id', $apartmentId)->with('sponsors')->first(); //Se usi get ti da' un array

        //calcoliamo la nuova data di scadenza
        if ($apartmentSponsorExpiration) {
            //Se ne ha una aggiungiamo le ore all'ultima scadenza
            $newExpirationDate = Carbon::parse($apartmentSponsorExpiration)->addHours($selectedSponsorHours);
        } else {
            //Oppure le aggiungiamo ad adesso
            $newExpirationDate = now()->addHours($selectedSponsorHours);
        }

        // Attacchiamo lo sponsor con la scadenza
        $apartment->sponsors()->attach($selectedSponsorId, [
            'exp_date' => $newExpirationDate,
        ]);

        return redirect()->route('admin.apartments.index')->with('newSponsor', $apartment);
    }

    public function generateClientToken()
    {
        $gateway = new Gateway([
            'environment' => env('BRAINTREE_ENVIRONMENT'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY')
        ]);

        $clientToken = $gateway->clientToken()->generate();

        return $clientToken;
    }
}
