<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Requests\StoreServiceRequest;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $services = Service::all();

        return view('admin.services.index', compact('services'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        //
        $form_data = $request->all();
        $new_service = Service::create($form_data);
        return to_route('admin.services.show', $new_service);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        //
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreServiceRequest $request, Service $service)
    {
        //
        $form_data = $request->all();
        $service->update($form_data);

        return to_route('admin.services.show', $service);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        //
        $service->delete();
        return to_route('admin.services.index', $service);
    }
}
