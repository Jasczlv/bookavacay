@extends('layouts.app')

@section('content')
    {{-- TITOLO E CREATE --}}
    <div class="container">
        <h1 class="mt-4">Sponsors</h1>
    </div>
    <div class="container">
        <a type="button" class="btn btn-primary mt-2 mb-3" href="{{ route('admin.sponsors.create') }}">Add a new sponsor</a>
    </div>


    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tier</th>
                    <th>Hours</th>
                    <th>Price</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sponsors as $sponsor)
                    <tr>
                        <td>{{ $sponsor->id }}</td>
                        <td>
                            <a class="btn-link" href="{{ route('admin.sponsors.show', $sponsor) }}">{{ $sponsor->tier }}</a>
                        </td>
                        <td>{{ $sponsor->hours }}</td>
                        <td>{{ $sponsor->price }}</td>
                        {{-- EDIT --}}
                        <td>
                            <a type="button" class="btn btn-warning"
                                href="{{ route('admin.sponsors.edit', $sponsor) }}">Edit</a>
                        </td>
                        {{-- DELETE --}}
                        <td>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#sponsor{{ $sponsor->id }}">
                                Delete
                            </button>
                            {{-- MODAL --}}
                            <div class="modal fade" id="sponsor{{ $sponsor->id }}" tabindex="-1"
                                aria-labelledby="sponsorLabel{{ $sponsor->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="sponsorLabel{{ $sponsor->id }}">Delete
                                                sponsor</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure to delete this sponsor?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <form action="{{ route('admin.sponsors.destroy', $sponsor) }}" method="POST">
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
