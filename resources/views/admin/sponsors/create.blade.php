@extends('layouts.app')

@section('content')

<section>
    <div class="container">
        <h2 class="mt-4">Create a new sponsor</h2>
    </div>
    <div class="container">
        <form action="{{ route('admin.sponsors.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="tier" class="form-label">Tier name</label>
                <input type="text" name="tier" class="form-control" id="tier" placeholder="sponsor tier">
            </div>
            <div class="mb-3">
                <label for="hours" class="form-label">Duration in hours</label>
                <input type="number" min="1" name="hours" class="form-control" id="hours" placeholder="hours duration">
            </div>
            <div>
                <label for="price" class="form-label">Set the price</label>
                <input type="number" min="0.01" step="0.01" name="price" class="form-control" id="price" placeholder="sponsor price">
            </div>
            <div class="mt-3">
                <button class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
</section>

@endsection
