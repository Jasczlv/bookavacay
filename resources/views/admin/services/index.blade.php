@extends('layouts.app')

@section('content')
    {{-- TITOLO E CREATE --}}
    <div class="container">
        <h1 class="mt-4">Services</h1>
    </div>
    <div class="container">
        <a type="button" class="btn btn-primary mt-2 mb-3" href="{{ route('admin.services.create') }}">Add a new service</a>
    </div>


    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    <tr>
                        <td>{{ $service->id }}</td>
                        <td>
                            <a class="btn-link" href="{{ route('admin.services.show', $service) }}">{{ $service->name }}</a>
                        </td>

                        {{-- EDIT --}}
                        <td>
                            <a type="button" class="btn btn-warning"
                                href="{{ route('admin.services.edit', $service) }}">Edit</a>
                        </td>
                        {{-- DELETE --}}
                        <td>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#service{{ $service->id }}">
                                Delete
                            </button>
                            {{-- MODAL --}}
                            <div class="modal fade" id="service{{ $service->id }}"
                                aria-labelledby="serviceLabel{{ $service->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="serviceLabel{{ $service->id }}">Delete service
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure to delete this service?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST">
                                                @method('DELETE')
                                                @csrf

                                                <button class="btn btn-link link-danger">Delete</button>

                                            </form>
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


{{-- <div class="general-div-services">
        <div class="container-services">
            <div class="row-services">

                @foreach ($services as $service)
                    <div class="card-services">
                        <a href="{{ route('admin.services.show', $service->id) }}">
                            <p>{{ $service->name }}</p>
                        </a>
                        <a href="{{ route('admin.services.edit', $service->id) }}">Edit</a>
                        <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection --}}
