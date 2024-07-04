<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sponsors = Sponsor::all();

        return view('admin.sponsors.index', compact('sponsors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sponsors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $new_sponsor = Sponsor::create($data);
        // $new_sponsor->tier = $data['tier'];
        // $new_sponsor->hours = $data['hours'];
        // $new_sponsor->price = $data['price'];
        // $new_sponsor->save();

        return to_route('admin.sponsors.show', $new_sponsor->id);
    }

    /**
     * Display the specified resource.
     */
    public function show($tier)
    {
        $sponsor = Sponsor::find($tier);
        if($sponsor === null) {
            abort('404');
        }
        return view('admin.sponsors.show', compact('sponsor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sponsor $sponsor)
    {
        return view('admin.sponsors.edit', compact('sponsor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sponsor $sponsor)
    {
        $data = $request->all();
        $sponsor->update($data);
        return to_route('admin.sponsors.show', $sponsor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sponsor $sponsor)
    {
        $sponsor->delete();
        return to_route('admin.sponsors.index');
    }
}
