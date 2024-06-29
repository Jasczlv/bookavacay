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
                <form action="{{ route('admin.apartments.store') }}" method="POST">
                    @csrf

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

                    {{-- TODO aggiungere mappa per indirizzo, lat e lon --}}

                    <div class="mb-3">
                        <label for="address" class="form-label">Apartment address</label>
                        <input type="text" name="address" class="form-control" id="address"
                            placeholder="BookaVacay Avenue 1" value="{{ old('address') }}">
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
@endsection
