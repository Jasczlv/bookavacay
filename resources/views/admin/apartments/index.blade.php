@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-end">
            <div class="col-auto">
                <div class="col-auto">
                    <a href="{{ route('admin.apartments.create') }}">
                        <button class="btn btn-danger">New Apartment</button>
                    </a>
                </div>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Rooms</th>
                    <th>Beds</th>
                    <th>Bathrooms</th>
                    <th>Sqr mt.</th>
                    <th>Address</th>
                    <th>Lat</th>
                    <th>Lon</th>
                    <th>Visible</th>
                    <th>{{-- fill --}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apartments as $apartment)
                    <tr>
                        <td>{{ $apartment->id }}</td>
                        <td><a href="{{ route('admin.apartments.show', $apartment) }}">{{ $apartment->title }}</a></td>
                        <td>{{ $apartment->rooms }}</td>
                        <td>{{ $apartment->beds }}</td>
                        <td>{{ $apartment->bathrooms }}</td>
                        <td>{{ $apartment->sqr_mt }}</td>
                        <td>{{ $apartment->address }}</td>
                        <td>{{ $apartment->lat }}</td>
                        <td>{{ $apartment->lon }}</td>
                        <td>{{ $apartment->visible }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.apartments.edit', $apartment) }}">Edit</a>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-link link-danger" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Trash
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete apartment</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure to delete this apartment?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <form action="{{ route('admin.apartments.destroy', $apartment) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf

                                                    <button class="btn btn-link link-danger">Trash</button>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
