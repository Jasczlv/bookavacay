@extends('layouts.app')

@section('content')
    <section id="full-page-section">

        @if ($apartment->user_id === Auth::id())
            <div class="container py-5">

                <a type="button" class="btn btn-secondary mt-4 mb-3" href="{{ route('admin.apartments.index') }}">&larr; Back
                    to
                    Apartments</a>


                <div class="row card">
                    <div class="card-header">
                        <h2 class="text-center">{{ $apartment->title }}</h2>
                    </div>
                    <div class="card-body py-3 mb-3">
                        <div class="text-center mb-3">
                            {{-- <img src="{{ Vite::asset('resources/img/' . $apartment->image) }}" alt=""> --}}
                            <img src="{{ Vite::asset('storage/app/public/images/' . $apartment->image) }}"
                                alt="{{ $apartment->title }}">

                            <p>{{ $apartment->address }}</p>
                        </div>
                        <div>
                            <div id="search-map">
                                <div id="map"></div>
                            </div>
                        </div>
                        <div class="row flex-column mb-3">

                            <div class="col-auto">
                                <label for="title" class="fw-bold">Title:</label>
                                @if ($apartment->title !== null)
                                    <p id="title">
                                        {{ $apartment->title }}
                                    </p>
                                @else
                                    <p id="title">Not Set</p>
                                @endif
                            </div>
                            <div class="col-auto">
                                <label for="sqr_mt" class="fw-bold">Square meters:</label>
                                @if ($apartment->sqr_mt !== null)
                                    <p id="sqr_mt">
                                        {{ $apartment->sqr_mt }}
                                    </p>
                                @else
                                    <p id="sqr_mt">Not Set</p>
                                @endif
                            </div>
                            <div class="col-auto">
                                <label for="rooms" class="fw-bold">Rooms:</label>
                                <p id="rooms">{{ $apartment->rooms }}, {{ $apartment->bathrooms }}
                                    @if ($apartment->bathrooms === 1)
                                        bathroom.
                                    @else
                                        bathrooms.
                                    @endif
                                </p>
                            </div>
                            <div class="col-auto">
                                <label for="beds" class="fw-bold">Beds:</label>
                                @if ($apartment->beds !== null)
                                    <p id="beds">
                                        {{ $apartment->beds }}
                                    </p>
                                @else
                                    <p id="beds">Not Set</p>
                                @endif
                            </div>
                            <div class="col-auto">
                                <label for="visible" class="fw-bold">Visibility:</label>
                                @if ($apartment->visible == true)
                                    <p id="visible">
                                        Visible
                                    </p>
                                @else
                                    <p id="visible">Hidden</p>
                                @endif
                            </div>

                            {{-- TODO aggiungere sponsor e user proprietario --}}

                        </div>
                    </div>


                    {{-- Edit and delete buttons --}}
                    <div class="container d-flex justify-content-center align-items-center gap-2 mb-5">
                        <a type="button" class="btn btn-warning"
                            href="{{ route('admin.apartments.edit', $apartment) }}">Edit</a>
                        <form class="delete-form" action="{{ route('admin.apartments.destroy', $apartment) }}"
                            method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>


                </div>
            @else
                <div class="container py-5">
                    <h3 class="text-center">
                        You don't have access to this page
                    </h3>
                </div>
        @endif

    </section>
    </div>

    </section>

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
