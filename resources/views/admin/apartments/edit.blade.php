@extends('layouts.app')

@section('content')
    <div class="container">
        <a type="button" class="btn btn-secondary mt-4 mb-3" href="{{ route('admin.apartments.index') }}">&larr; Back to
            Apartments</a>

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
                <h2>Edit Apartment</h2>
            </div>
            <div class="card-body py-3">

                <section>
                    <div id="search-map">
                        <div id="searchbar">
                        </div>
                        <div id="map"></div>
                    </div>
                </section>

                <form action="{{ route('admin.apartments.update', $apartment) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div>
                        <input type="text" name="latitude" id="latitude"
                            value="{{ old('latitude', $apartment->latitude) }}" readonly>
                        <input type="text" name="longitude" id="longitude"
                            value="{{ old('longitude', $apartment->longitude) }}" readonly>
                        <input type="text" name="address" id="address"
                            value="{{ old('address', $apartment->address) }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Apartment Title</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Title"
                            value="{{ old('title', $apartment->title) }}">
                    </div>

                    <div class="mb-3">
                        <label for="rooms" class="form-label">Number of rooms</label>
                        <input type="number" name="rooms" class="form-control" id="rooms" placeholder="4"
                            value="{{ old('rooms', $apartment->rooms) }}">
                    </div>

                    <div class="mb-3">
                        <label for="beds" class="form-label">Number of beds</label>
                        <input type="number" name="beds" class="form-control" id="beds" placeholder="2"
                            value="{{ old('beds', $apartment->beds) }}">
                    </div>

                    <div class="mb-3">
                        <label for="bathrooms" class="form-label">Number of bathrooms</label>
                        <input type="number" name="bathrooms" class="form-control" id="bathrooms" placeholder="1"
                            value="{{ old('bathrooms', $apartment->bathrooms) }}">
                    </div>

                    <div class="mb-3">
                        <label for="sqr_mt" class="form-label">Square meters</label>
                        <input type="number" name="sqr_mt" class="form-control" id="sqr_mt" placeholder="60"
                            value="{{ old('sqr_mt', $apartment->sqr_mt) }}">
                    </div>

                    <div class="mb-3">
                        <label for="image_file" class="form-label">Apartment Image</label>
                        <input type="file" name="image_file" class="form-control" id="image_file">

                        @if ($apartment->image)
                            <p>Current Image:</p>
                            <img src="{{ Vite::asset('storage/app/public/images/' . $apartment->image) }}">
                        @else
                            <p>No image uploaded</p>
                        @endif
                    </div>

                    <div class="mb-3">
                        <div>

                            <div class="mb-3">
                                <div>
                                    <label for="visible" class="form-label">Publish as visible?</label>
                                    <select name="visible" id="visible">
                                        <option value="0" @selected(old('visible', $apartment->visible) == 0)>Not visible</option>
                                        <option value="1" @selected(old('visible', $apartment->visible) == 1)>Visible</option>
                                    </select>
                                </div>
                            </div>

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
                            <div id="collapseTwo" class="accordion-collapse collapse show"
                                data-bs-parent="#servicesAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        @foreach ($services as $service)
                                            <div class="col-2">
                                                <label for="{{ $service->name }}">{{ $service->name }}</label>
                                                <input @checked(in_array($service->id, old('services', $apartment->services->pluck('id')->all()))) type="checkbox" name="services[]"
                                                    id="{{ $service->name }}" value="{{ $service->id }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 d-flex justify-content-center">
                        <button class="btn btn-primary">Update</button>
                    </div>

                </form>
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

                var apartmentLat;
                var apartmentLng;

                // Initialize the map
                var map = tt.map({
                    key: 'VtdGJcQDaomboK5S3kbxFvhtbupZjoK0',
                    container: 'map',
                    center: [apartmentLng, apartmentLat],
                    zoom: 15
                });

                // Add marker
                var marker = new tt.Marker({
                        draggable: true
                    })
                    .setLngLat([apartmentLng, apartmentLat])
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
                    }).then(function(response) {
                        var address = response.addresses[0].address.freeformAddress;
                        document.getElementById('address').value = address;
                    }).catch(function(error) {
                        console.error('Reverse geocode error:', error);
                    });
                });

                // Reverse geocode to get address
                tt.services.reverseGeocode({
                    key: 'VtdGJcQDaomboK5S3kbxFvhtbupZjoK0',
                    position: apartmentLat,
                    apartmentLng
                }).then(function(response) {
                    var address = response.addresses[0].address.freeformAddress;
                    document.getElementById('address').value = address;
                }).catch(function(error) {
                    console.error('Reverse geocode error:', error);
                });

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
                    }).then(function(response) {
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
            console.log('tt:', tt);
            console.log('tt.services:', tt.services);
            console.log('tt.plugins:', tt.plugins);
        }
    </script>
@endsection
