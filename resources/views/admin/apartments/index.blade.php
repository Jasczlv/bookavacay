<?php
$id = 0;
?>
@extends('layouts.app')
@section('content')
    {{-- TITOLO E CREATE --}}
    <div class="container">
        <h1 class="mt-4">Apartments</h1>
    </div>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <a type="button" class="btn btn-primary mt-2 mb-3" href="{{ route('admin.apartments.create') }}">Add a new
                apartment</a>
            <a type="button" class="btn btn-primary mt-2 mb-3" href="{{ route('admin.apartments.sponsors') }}">Sponsor an
                apartment</a>


            {{-- Users search input --}}
            <form action="{{ route('admin.apartments.search') }}" method="GET">
                @csrf
                <div class="input-group">
                    <input type="text" name="query" class="form-control mx-2 rounded" placeholder="Search apartments">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </span>
                </div>
            </form>
        </div>
    </div>


    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Address</th>
                    <th>Visibility</th>
                    <th>Sponsor</th>
                    <th>{{-- fill --}}</th>
                    <th>{{-- fill --}}</th>
                    <th>{{-- fill --}}</th>
                    <th>{{-- fill --}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apartments as $apartment)
                    <tr>
                        <td><img src="{{ Vite::asset('storage/app/public/images/' . $apartment->image) }}" alt=""
                                style="max-width: 300px"></td>
                        <td><a class="btn-link"
                                href="{{ route('admin.apartments.show', $apartment) }}">{{ $apartment->title }}</a></td>
                        <td>{{ $apartment->address }}</td>
                        <td>
                            @if ($apartment->visible == true)
                                Visible
                            @else
                                Hidden
                            @endif
                        </td>
                        <td>
                            @php
                                $currentDate = now();
                                $sponsorship = $apartment->sponsors()->where('exp_date', '>', $currentDate)->first();
                            @endphp
                            @if ($sponsorship)
                                {{ $sponsorship->pivot->exp_date }}
                            @else
                                Not Sponsored
                            @endif
                        </td>
                        {{-- MESSAGES --}}
                        <td>
                            <a type="button" class="btn btn-success"
                                href="{{ route('admin.apartments.messages', $apartment) }}">Messages</a>
                        </td>
                        {{-- STATISTICS --}}
                        <td>
                            <a type="button" class="btn btn-info"
                                href="{{ route('admin.apartments.statistics', $apartment) }}">Statistics</a>
                        </td>
                        {{-- EDIT --}}
                        <td>
                            <a type="button" class="btn btn-warning"
                                href="{{ route('admin.apartments.edit', $apartment) }}">Edit</a>
                        </td>
                        {{-- DELETE --}}
                        <td>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#apartment{{ $apartment->id }}">
                                Delete
                            </button>
                            {{-- MODAL --}}
                            <div class="modal fade" id="apartment{{ $apartment->id }}"
                                aria-labelledby="apartmentLabel{{ $apartment->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="apartmentLabel{{ $apartment->id }}">Delete
                                                apartment</h1>
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
