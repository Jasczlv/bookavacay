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
                <form action="{{ route('admin.apartments.update', $apartment) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Apartment Title</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Title"
                            value="{{ old('title', $apartment->title) }}">
                    </div>

                    <div class="mb-3">
                        @foreach ($users as $user)
                            <label for="user_id"
                                class="form-label">{{ $user->name . ' ' . $user->surname . ' ' . $user->id }}</label>
                            <input type="radio" name="user_id" id="user_{{ $user->id }}" placeholder="user_id"
                                @checked($user->id == old('user_id', $apartment->user_id)) value="{{ $user->id }}">
                        @endforeach
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

                    {{-- TODO aggiungere mappa per indirizzo, lat e lon --}}

                    <div class="mb-3">
                        <label for="address" class="form-label">Apartment address</label>
                        <input type="text" name="address" class="form-control" id="address"
                            placeholder="BookaVacay Avenue 1" value="{{ old('address', $apartment->address) }}">
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
                            <input type="hidden" name="visible" id="" value="0">
                            <input @checked(old('visible') === true) type="checkbox" name="visible" id="visible"
                                value="1">
                            {{-- <select name="visible" id="" @selected(old('visible') === true)>
                                <option value="1">Visible</option>
                                <option value="0">Not visible</option>
                            </select> --}}
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

                    <div class="mb-3 d-flex justify-content-center">
                        <button class="btn btn-primary">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
