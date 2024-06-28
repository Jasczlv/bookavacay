@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-9">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">{{ $apartment->title }}</h2>
                    </div>
                    <div class="card-body py-3">
                        <div class="text-center mb-3">
                            <img src="{{ $apartment->image }}" alt="">
                            <p>{{ $apartment->address }}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <span>Rooms: {{ $apartment->rooms }}</span>
                                <span>Square meters: {{ $apartment->sqr_mt }}</span>
                                <span>Beds: {{ $apartment->beds }}</span>
                                <span>Bathrooms: {{ $apartment->bathrooms }}</span>
                                <span>Visible?: {{ $apartment->visible ? 'yes' : 'no' }}</span>
                                <span>Sponsored? </span> {{-- TODO --}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
