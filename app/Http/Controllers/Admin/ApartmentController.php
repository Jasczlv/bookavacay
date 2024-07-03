<?php

namespace App\Http\Controllers\Admin;

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

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $apartments = Apartment::where('user_id', $request->user()->id)->get();

        //api json response
        if ($request->wantsJson()) {
            $apartments = Apartment::all();
            return response()->json($apartments);
        }
        return view('admin.apartments.index', compact('apartments'));
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
        return redirect()->route('admin.apartments.index', $new_apartment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        return view('404');
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
            // foreach ($form_data['services'] as $service_id) {

            //     $apartment->services()->attach($service_id);
            // }
            $apartment->services()->sync($form_data['services']);
        }

        $apartment->update($form_data);

        return to_route('admin.apartments.index', $apartment);
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
        $messages = Message::where('apartment_id', $apartment->id)->get();

        return view('admin.apartments.messages', compact('messages', 'apartment'));
    }

    public function statistics(Apartment $apartment, View $view, Request $request)
    {
        $statistics = View::where('apartment_id', $apartment->id)->get();

        return view('admin.apartments.statistics', compact('statistics', 'apartment'));
    }

    public function sponsors(Apartment $apartment, Sponsor $sponsor, Request $request)
    {
        $apartments = Apartment::where('user_id', $request->user()->id)->get();
        $sponsors = Sponsor::all();

        return view('admin.apartments.sponsors', compact('sponsors', 'apartments'));
    }
}
