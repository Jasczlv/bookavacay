@extends('layouts.app')

@section('content')

<section>
    <div class="container">
        <a type="button" class="btn btn-primary mt-4 mb-3" href="{{ route('admin.sponsors.index') }}">&larr; Back to all sponsors</a>
    </div>
    <div class="container">
        <h2 class="mt-4">Edit sponsor</h2>
    </div>
    <div class="container">
        <h4>Old data:</h4>
        <ul>
            <li>
                <p>{{ $sponsor->tier }}</p>
            </li>
            <li>
                <p>Hours: {{ $sponsor->hours }}</p>
            </li>
            <li>
                <p>Price: {{ $sponsor->price }}</p>
            </li>
        </ul>
    </div>
    <div class="container">
        <form action="{{ route('admin.sponsors.update',$sponsor) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="tier" class="form-label">Tier name</label>
                <input class="form-control" type="text" name="tier" class="form-control" id="tier" value="{{ $sponsor->tier }}">
            </div>
            <div class="mb-3">
                <label for="hours" class="form-label">Duration in hours</label>
                <input class="form-control" type="number" min="1" name="hours" class="form-control" id="hours" value="{{ $sponsor->hours }}">
            </div>
            <div>
                <label for="price" class="form-label">Set the price</label>
                <input class="form-control" type="number" min="0.01" step="0.01" name="price" class="form-control" id="price" value="{{ $sponsor->price }}">
            </div>
            <div class="mt-3">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</section>

@endsection
