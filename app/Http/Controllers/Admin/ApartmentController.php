<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\Apartment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $apartments = Apartment::where('user_id', $request->user()->id)->get();

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
        \Log::info('Request data: ' . json_encode($request->all()));
        \Log::info('Has file image: ' . ($request->hasFile('image') ? 'yes' : 'no'));

        $form_data = $request->validated();
        $new_apartment = Apartment::create($form_data);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            \Log::info('Image file detected: ' . $file->getClientOriginalName());
            $path = $file->store('images', 'public');
            \Log::info('Image stored at: ' . $path);
            $new_apartment->image = $path;
        } else {
            \Log::info('No image file detected, using default image');
            $new_apartment->image = 'https://picsum.photos/300/200?random=' . $new_apartment->id;
        }

        $new_apartment->save();

        if ($request->has('services')) {
            foreach ($form_data['services'] as $service_id) {
                $new_apartment->services()->attach($service_id);
            }
        }

        return redirect()->route('admin.apartments.show', $new_apartment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        return view('admin.apartments.show', compact('apartment'));    }

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

        return to_route('admin.apartments.show', $apartment);
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
}
