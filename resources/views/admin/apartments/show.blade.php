@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <div class="card" style="width: 18rem;">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{ $apartment->time }}</h5>
                <p class="card-text">Rooms: {{ $apartment->rooms }}</p>
                <p class="card-text">Beds: {{ $apartment->beds }}</p>
                <p class="card-text">Bathrooms: {{ $apartment->bathrooms }}</p>
                <p class="card-text">Square meters: {{ $apartment->sqr_mt }}</p>
                <p class="card-text">Address: {{ $apartment->address }}</p>
            </div>
        </div>

    </div>
@endsection
