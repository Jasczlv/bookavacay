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
        <div class="d-flex justify-content-between align-items-center sponsor-sec">
            @if (count($user->apartments))
                <a type="button" class="btn btn-primary mt-2 mb-3" href="{{ route('admin.apartments.create') }}">Add a new
                    apartment</a>


                <a type="button" class="btn btn-primary mt-2 mb-3" href="{{ route('admin.apartments.sponsors') }}">Sponsor an
                    apartment</a>
            @endif

            {{-- Users search input --}}
            @if (count($user->apartments))
                <form action="{{ route('admin.apartments.search') }}" method="GET">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="query" class="form-control mx-2 rounded"
                            placeholder="Search apartments">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </span>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <div class="container">
        @if (count($user->apartments))
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Address</th>
                        <th>Visibility</th>
                        <th>Sponsor Expire</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apartments as $apartment)
                        <tr>
                            <td class="label-td" data-label="Image"><img
                                    src="{{ Vite::asset('storage/app/public/images/' . $apartment->image) }}" alt=""
                                    style="max-width: 300px"></td>
                            <td class="label-td" data-label="Title">
                                <a class="btn-link"
                                    href="{{ route('admin.apartments.show', $apartment) }}">{{ $apartment->title }}</a>
                            </td>
                            <td class="label-td" data-label="Address">{{ $apartment->address }}</td>
                            <td class="label-td" data-label="Visibility">
                                @if ($apartment->visible == true)
                                    Visible
                                @else
                                    Hidden
                                @endif
                            </td>
                            <td class="label-td" data-label="Sponsor Expire">
                                @php
                                    $currentDate = now();
                                    $sponsorship = $apartment
                                        ->sponsors()
                                        ->where('exp_date', '>', $currentDate)
                                        ->orderBy('exp_date', 'desc')
                                        ->first();
                                @endphp
                                @if ($sponsorship)
                                    Until {{ $sponsorship->pivot->exp_date }}
                                @else
                                    Not Sponsored
                                @endif
                            </td>
                            <td class="label-td">

                                <div class="d-flex flex-column gap-3" data-label="Messages">
                                    <a type="button" class="btn btn-success position-relative"
                                        href="{{ route('admin.apartments.messages', $apartment) }}">
                                        Messages
                                        @if ($apartment->unread_messages_count > 0)
                                            <span
                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                {{ $apartment->unread_messages_count }}
                                                <span class="visually-hidden">unread messages</span>
                                            </span>
                                        @endif
                                    </a>
                                    <a type="button" class="btn btn-info"
                                        href="{{ route('admin.apartments.statistics', $apartment) }}">Statistics</a>
                                    <a type="button" class="btn btn-warning"
                                        href="{{ route('admin.apartments.edit', $apartment) }}">Edit</a>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#apartment{{ $apartment->id }}">Delete</button>
                                </div>
                            </td>

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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="row flex-column justify-content-center align-items-center py-5">

                <h2 class="text-center ">Create your first apartment!</h2>
                <a type="button" class="col-auto btn btn-primary mt-2 mb-3"
                    href="{{ route('admin.apartments.create') }}">Add a new
                    apartment</a>
            </div>
        @endif
    </div>

    @if (session('newApartment'))
        <!-- Modal -->
        <div class="modal fade" id="createdModal" tabindex="-1" aria-labelledby="createdModalLabel" aria-hidden="true"
            data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="createdModalLabel">Apartment created Successfully</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Thanks for adding your apartment!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
    @endif

    @if (session('newApartment'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $('#createdModal').modal('show');
            });
        </script>
    @endif

    {{-- Modale sponsor --}}

    @if (session('newSponsor'))
        <!-- Modal -->
        <div class="modal fade" id="sponsorModal" tabindex="-1" aria-labelledby="sponsorModalLabel" aria-hidden="true"
            data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="sponsorModalLabel">Apartment sponsored Successfully</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Thanks for sponsoring {{ $apartment->title }}!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
    @endif

    @if (session('newSponsor'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $('#sponsorModal').modal('show');
            });
        </script>
    @endif
@endsection

<style scoped>
    .list-group-item {
        border: none !important;
    }

    /* Ensure the container has horizontal scrolling */
    .table-responsive {
        /* overflow-x: auto; */
        -webkit-overflow-scrolling: touch;
        /* Smooth scrolling for iOS */
    }

    /* Style the table to be 100% width and collapse borders */
    .table {
        width: 100%;
        border-collapse: collapse;
    }

    /* Ensure images are responsive */
    .table img {
        max-width: 100%;
        height: auto;
    }

    /* Hide table headers and style table rows for small screens */
    @media screen and (max-width: 960px) {
        .table thead {
            display: none;
        }

        .table tbody,
        .table tr,
        .table td {
            display: block;
            width: 100%;
        }

        .table tr {
            margin-bottom: 15px;
        }

        .table td {
            text-align: right;
            padding-left: 50%;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: normal;
            /* Ensure text wraps */
        }

        .label-td:before {
            content: attr(data-label);
            /* position: absolute; */
            /* left: 0; */
            width: 50%;
            padding-left: 15px;
            padding-bottom: .5rem;
            font-weight: bold;
            text-align: left;
        }

        .btn {
            width: 100%;
            margin-bottom: 10px;
        }

        .sponsor-sec {
            flex-direction: column;
        }
    }
</style>



@section('additional-styles')
    <style scoped>
        .card-header.highlight {
            background-color: var(--orange, #F7851D);
        }

        .card-body.highlight {
            background-color: var(--light--orange, #FFB440);
            color: black;
        }
    </style>
@endsection
