@extends('layouts.app')

@section('content')
    <div class="container py-5">

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h2>New Apartment</h2>
            </div>
            <div class="card-body py-3">

                <section>
                    <div id="search-map">
                        <div id="searchbar">
                            <input type="text" id="search-input" placeholder="Search for a location">
                        </div>
                        <div id="map"></div>
                    </div>
                </section>

                <form action="{{ route('admin.apartments.store') }}" method="POST">
                    @csrf

                    <div>
                        <input type="text" name="latitude" id="latitude" readonly>
                        <input type="text" name="longitude" id="longitude" readonly>
                        <input type="text" name="address" id="address" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Apartment Title</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Title"
                            value="{{ old('title') }}">
                    </div>

                    <div class="mb-3">
                        @foreach ($users as $user)
                            <label for="user_id"
                                class="form-label">{{ $user->name . ' ' . $user->surname . ' ' . $user->id }}</label>
                            <input type="radio" name="user_id" id="user_{{ $user->id }}" placeholder="user_id"
                                value="{{ $user->id }}">
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <label for="rooms" class="form-label">Number of rooms</label>
                        <input type="number" name="rooms" class="form-control" id="rooms" placeholder="4"
                            value="{{ old('rooms') }}">
                    </div>

                    <div class="mb-3">
                        <label for="beds" class="form-label">Number of beds</label>
                        <input type="number" name="beds" class="form-control" id="beds" placeholder="2"
                            value="{{ old('beds') }}">
                    </div>

                    <div class="mb-3">
                        <label for="bathrooms" class="form-label">Number of bathrooms</label>
                        <input type="number" name="bathrooms" class="form-control" id="bathrooms" placeholder="1"
                            value="{{ old('bathrooms') }}">
                    </div>

                    <div class="mb-3">
                        <label for="sqr_mt" class="form-label">Square meters</label>
                        <input type="number" name="sqr_mt" class="form-control" id="sqr_mt" placeholder="60"
                            value="{{ old('sqr_mt') }}">
                    </div>

                    <div class="mb-3">
                        <label for="image_file" class="form-label">Apartment Image</label>
                        <input type="file" name="image_file" class="form-control" id="image_file"
                            value="{{ old('image_file') }}">
                    </div>

                    <div class="mb-3">
                        <label for="image_url" class="form-label">Apartment Image Url</label>
                        <input type="url" name="image_url" class="form-control" id="image_url"
                            placeholder="www.example.com/image.jpg" value="{{ old('image_url') }}">
                    </div>

                    <div class="mb-3">
                        <div>
                            <label for="visible" class="form-label">Publish as visible?</label>
                            <input @checked(old('visible') === true) type="checkbox" name="visible" id="visible"
                                value="true">
                        </div>
                    </div>

                    <div class="accordion mb-3" id="servicesAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Apartment Services
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse"
                                data-bs-parent="#servicesAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        @foreach ($services as $service)
                                            <div class="col-2">
                                                <label for="{{ $service->name }}">{{ $service->name }}</label>
                                                <input type="checkbox" name="services[]" id="{{ $service->name }}"
                                                    value="{{ $service->id }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 text-center">
                        <button class="btn btn-primary">Create</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <button class="btn btn-primary" onclick="test()">Test</button>
    </div>


    {{-- Stile mappa --}}

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

    {{-- Script Mappa --}}

    <script>
        // Function to initialize the map and search functionality
        function initializeMap() {
            // Check if TomTom SDK scripts are loaded
            if (typeof tt !== 'undefined' && typeof tt.map !== 'undefined' && typeof tt.services !== 'undefined') {
                // Initialize the map
                var map = tt.map({
                    key: 'VtdGJcQDaomboK5S3kbxFvhtbupZjoK0',
                    container: 'map',
                    center: [0, 0],
                    zoom: 15
                });

                // Add marker
                var marker = new tt.Marker({
                        draggable: true
                    })
                    .setLngLat([0, 0])
                    .addTo(map);

                // Add event listener for marker drag end
                marker.on('dragend', function() {
                    var lngLat = marker.getLngLat();
                    document.getElementById('latitude').value = lngLat.lat;
                    document.getElementById('longitude').value = lngLat.lng;

                    // Reverse geocode to get address
                    tt.services.reverseGeocode({
                        key: 'VtdGJcQDaomboK5S3kbxFvhtbupZjoK0',
                        position: lngLat
                    }).go().then(function(response) {
                        var address = response.addresses[0].address.freeformAddress;
                        document.getElementById('address').value = address;
                    });
                });

                // Center the map and marker based on user's location
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var userLocation = [position.coords.longitude, position.coords.latitude];
                        map.setCenter(userLocation);
                        marker.setLngLat(userLocation);
                        document.getElementById('latitude').value = userLocation[1];
                        document.getElementById('longitude').value = userLocation[0];

                        // Reverse geocode to get address
                        tt.services.reverseGeocode({
                            key: 'VtdGJcQDaomboK5S3kbxFvhtbupZjoK0',
                            position: userLocation
                        }).go().then(function(response) {
                            var address = response.addresses[0].address.freeformAddress;
                            document.getElementById('address').value = address;
                        });
                    });
                }

                // Search box functionality
                var searchBoxOptions = {
                    searchOptions: {
                        key: 'VtdGJcQDaomboK5S3kbxFvhtbupZjoK0',
                        language: 'en-GB',
                        limit: 5
                    },
                    autocompleteOptions: {
                        key: 'VtdGJcQDaomboK5S3kbxFvhtbupZjoK0',
                        language: 'en-GB'
                    },
                    noResultsMessage: 'No results found.',
                };

                var ttSearchBox = new tt.plugins.SearchBox(tt.services, searchBoxOptions);
                var searchBoxHTML = ttSearchBox.getSearchBoxHTML();
                document.getElementById('searchbar').appendChild(searchBoxHTML);

                ttSearchBox.on('tomtom.searchbox.resultselected', function(data) {
                    var result = data.data.result;
                    var lngLat = result.position;
                    map.setCenter(lngLat);
                    marker.setLngLat(lngLat);
                    document.getElementById('latitude').value = lngLat.lat;
                    document.getElementById('longitude').value = lngLat.lng;
                    document.getElementById('address').value = result.address.freeformAddress;
                });

                // Add the search box input handler
                document.getElementById('search-input').addEventListener('input', function(event) {
                    var query = event.target.value;
                    tt.services.fuzzySearch({
                        key: 'VtdGJcQDaomboK5S3kbxFvhtbupZjoK0',
                        query: query,
                        language: 'en-GB'
                    }).go().then(function(response) {
                        if (response.results && response.results.length > 0) {
                            var result = response.results[0];
                            var lngLat = result.position;
                            map.setCenter(lngLat);
                            marker.setLngLat(lngLat);
                            document.getElementById('latitude').value = lngLat.lat;
                            document.getElementById('longitude').value = lngLat.lng;
                            document.getElementById('address').value = result.address.freeformAddress;
                        }
                    });
                });

            } else {
                console.error('TomTom SDK not loaded properly.');
            }
        }

        // Load the map after the page is fully loaded
        document.addEventListener('DOMContentLoaded', initializeMap);

        function test() {
            console.log('testing')
            initializeMap()
        }
    </script>

@endsection
