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

        <section id="full-page-section">

            @if ($apartment->user_id === Auth::id())
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Edit Apartment</h2>
                    </div>
                    <div class="card-body py-3">

                        <div class="row justify-content-center mb-3">
                            <div class="col-auto text-center">
                                <div>
                                    @if ($apartment->image)
                                        <div>
                                            <p>Current Image:</p>
                                        </div>
                                        <img class="w-50"
                                            src="{{ Vite::asset('storage/app/public/images/' . $apartment->image) }}">
                                    @else
                                        <p>No image uploaded</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <section class="mb-3">
                            <div id="search-map">
                                <div id="searchbar"></div>
                                <div id="map"></div>
                            </div>
                        </section>



                        <form action="{{ route('admin.apartments.update', $apartment) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="user_id" id="user_id" value="{{ Auth::id() }}" required>

                            <div class="py-4 w-100">
                                <div class="row w-100 justify-content-center">
                                    <div class="col-auto">
                                        {{-- <label for="latitude">Latitude: </label> --}}
                                        <input type="hidden" name="latitude" id="latitude" readonly required
                                            value="{{ old('latitude', $apartment->latitude) }}">
                                    </div>
                                    <div class="col-auto">
                                        {{-- <label for="longitude">Longitude: </label> --}}
                                        <input type="hidden" name="longitude" id="longitude" readonly required
                                            value="{{ old('longitude', $apartment->longitude) }}">
                                    </div>
                                    <div class="col-auto">
                                        <label for="address">Address: </label>
                                        <input style="max-width: 400px" type="text" name="address" id="address"
                                            readonly required value="{{ old('address', $apartment->address) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row w-100">

                                <div class="mb-3 col-4 p-2">
                                    <label for="title" class="form-label">Apartment Title*</label>
                                    <input type="text" name="title" class="form-control" id="title"
                                        placeholder="Title" value="{{ old('title', $apartment->title) }}" required>
                                </div>


                                <div class="mb-3 col-4 p-2">
                                    <label for="rooms" class="form-label">Number of rooms*</label>
                                    <input type="number" name="rooms" class="form-control" id="rooms" placeholder="4"
                                        value="{{ old('rooms', $apartment->rooms) }}" required>
                                </div>

                                <div class="mb-3 form-edit col-4 p-2">
                                    <label for="beds" class="form-label">Number of beds</label>
                                    <input type="number" name="beds" class="form-control" id="beds" placeholder="2"
                                        value="{{ old('beds', $apartment->beds) }}" required>
                                </div>

                                <div class="mb-3 form-edit col-4 p-2">
                                    <label for="bathrooms" class="form-label">Number of bathrooms</label>
                                    <input type="number" name="bathrooms" class="form-control" id="bathrooms"
                                        placeholder="1" value="{{ old('bathrooms', $apartment->bathrooms) }}" required>
                                </div>

                                <div class="mb-3 form-edit col-4 p-2">
                                    <label for="sqr_mt" class="form-label">Square meters</label>
                                    <input type="number" name="sqr_mt" class="form-control" id="sqr_mt"
                                        placeholder="40" value="{{ old('sqr_mt', $apartment->sqr_mt) }}" required>
                                </div>

                                <div class="mb-3 form-edit col-4 p-2">
                                    <label for="image_file" class="form-label">Apartment Image</label>
                                    <input type="file" name="image_file" class="form-control" id="image_file">
                                </div>


                            </div>

                            <div class="mb-3">
                                <label for="visible" class="form-label">Publish as visible?</label>
                                <select required name="visible" id="visible">
                                    <option value="0" @selected(old('visible', $apartment->visible) == 0)>Not visible</option>
                                    <option value="1" @selected(old('visible', $apartment->visible) == 1)>Visible</option>
                                </select>
                            </div>

                            <p id="error-msg" style="color:red; display:none;">Please select at least one service.</p>
                            <div class="accordion mb-3" id="servicesAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                            Apartment Services**
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse show"
                                        data-bs-parent="#servicesAccordion">
                                        <div class="accordion-body">
                                            <div class="row">
                                                @foreach ($services as $service)
                                                    <div class="col-auto">
                                                        <label for="{{ $service->name }}">{{ $service->name }}</label>
                                                        <input type="checkbox" name="services[]"
                                                            id="{{ $service->name }}" value="{{ $service->id }}"
                                                            @if (in_array($service->id, old('services', $apartment->services->pluck('id')->toArray()))) checked @endif>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 d-flex justify-content-center">
                                <button id="submit-btn" class="btn btn-primary">Update</button>
                            </div>


                        </form>


                        <span>(*) required field; (**) at least one required</span>
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
            let longitude = document.getElementById('longitude').value
            let latitude = document.getElementById('latitude').value
            if (typeof tt !== 'undefined' && typeof tt.map !== 'undefined' && typeof tt.services !== 'undefined') {
                var map = tt.map({
                    key: 'VtdGJcQDaomboK5S3kbxFvhtbupZjoK0',
                    container: 'map',
                    center: [longitude, latitude],
                    zoom: 15
                });

                var marker = new tt.Marker({
                    draggable: true
                }).setLngLat([longitude, latitude]).addTo(map);

                marker.on('dragend', function() {
                    var lngLat = marker.getLngLat();
                    document.getElementById('latitude').value = lngLat.lat;
                    document.getElementById('longitude').value = lngLat.lng;

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

                /* if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var userLocation = [position.coords.longitude, position.coords.latitude];
                        map.setCenter(userLocation);
                        marker.setLngLat(userLocation);
                        document.getElementById('latitude').value = userLocation[1];
                        document.getElementById('longitude').value = userLocation[0];

                        tt.services.reverseGeocode({
                            key: 'VtdGJcQDaomboK5S3kbxFvhtbupZjoK0',
                            position: userLocation
                        }).then(function(response) {
                            var address = response.addresses[0].address.freeformAddress;
                            document.getElementById('address').value = address;
                        }).catch(function(error) {
                            console.error('Reverse geocode error:', error);
                        });
                    });
                } */

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

        document.addEventListener('DOMContentLoaded', initializeMap);

        function test() {
            console.log('tt:', tt);
            console.log('tt.services:', tt.services);
            console.log('tt.plugins:', tt.plugins);
        }

        document.getElementById('submit-btn').addEventListener('click', function(event) {
            let checkboxes = document.querySelectorAll('input[name="services[]"]');
            let isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

            if (!isChecked) {
                event.preventDefault();
                document.getElementById('error-msg').style.display = 'block';
            } else {
                document.getElementById('error-msg').style.display = 'none';
            }
        });
    </script>
@endsection
