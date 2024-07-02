@extends('layouts.app')

@section('content')
    <div class="container">
        <a type="button" class="btn btn-secondary mt-4 mb-3" href="{{ route('admin.apartments.index') }}">&larr; Back to
            Apartments</a>
        <div class="row justify-content-center">
            <div class="col-9">
                <div class="card mb-3">
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
                        <section>
                            <div id="search-map">
                                <div id="map"></div>
                            </div>
                        </section>
                    </div>
                </div>

                {{-- Edit and delete buttons --}}
                <div class="container d-flex justify-content-center align-items-center gap-2 mb-5">
                    <a type="button" class="btn btn-warning"
                        href="{{ route('admin.apartments.edit', $apartment) }}">Edit</a>
                    <form class="delete-form" action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Stile mappa -->
    <style>
        #map {
            width: 100%;
            height: 500px;
        }

        #searchbar {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1000;
            width: 80%;
            max-width: 500px;
        }

        #search-map {
            position: relative;
        }
    </style>


    <!-- Script Mappa -->
    <script>
        // Function to initialize the map and search functionality
        function initializeMap() {
            // Check if TomTom SDK scripts are loaded
            if (typeof tt !== 'undefined' && typeof tt.map !== 'undefined' && typeof tt.services !== 'undefined') {

                var apartmentLat = {{ $apartment->latitude }};
                var apartmentLng = {{ $apartment->longitude }};

                // Initialize the map
                var map = tt.map({
                    key: 'VtdGJcQDaomboK5S3kbxFvhtbupZjoK0',
                    container: 'map',
                    center: [apartmentLng, apartmentLat],
                    zoom: 15
                });

                // Add marker
                var marker = new tt.Marker({
                        draggable: false
                    })
                    .setLngLat([apartmentLng, apartmentLat])
                    .addTo(map);

            } else {
                console.error('TomTom SDK not loaded properly.');
            }
        }

        // Load the map after the page is fully loaded
        document.addEventListener('DOMContentLoaded', initializeMap);

        function test() {
            console.log('tt:', tt);
            console.log('tt.services:', tt.services);
            console.log('tt.plugins:', tt.plugins);
        }
    </script>
@endsection
