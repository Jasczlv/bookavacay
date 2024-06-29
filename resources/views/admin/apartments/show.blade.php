@extends('layouts.app')

@section('content')
    <div class="container">
        <a type="button" class="btn btn-secondary mt-4 mb-3" href="{{ route('admin.apartments.index') }}">&larr; Back to
            Apartments</a>
        <div class="row justify-content-center">
            <div class="col-9">
                <div class="card mb-3">
                    <div class="card-header">
                        <h2 class="text-center">{{ $apartment->title }}</h2>
                    </div>
                    <div class="card-body py-3">
                        <div class="text-center mb-3">
                            <img src="{{ $apartment->image }}" alt="">
                            <p>{{ $apartment->address }}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <span>Rooms: {{ $apartment->rooms }}</span>
                                <span>Square meters: {{ $apartment->sqr_mt }}</span>
                                <span>Beds: {{ $apartment->beds }}</span>
                                <span>Bathrooms: {{ $apartment->bathrooms }}</span>
                                <span>Visible?: {{ $apartment->visible ? 'yes' : 'no' }}</span>
                                <span>Sponsored? </span> {{-- TODO --}}
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Edit and delete buttons --}}
                <div class="container d-flex justify-content-center align-items-center gap-2">
                    <a type="button" class="btn btn-warning"
                        href="{{ route('admin.apartments.edit', $apartment) }}">Edit</a>
                    <form class="delete-form" action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger">Delete</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
