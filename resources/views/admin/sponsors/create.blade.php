@extends('layouts.app')

@section('content')
    <section>
        <div class="container">
            <a type="button" class="btn btn-primary mt-4 mb-3" href="{{ route('admin.sponsors.index') }}">&larr; Back to all
                sponsors</a>

            <div class="card">
                <div class="card-header">
                    <h2>New sponsor</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.sponsors.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="tier" class="form-label">Tier name</label>
                            <input class="form-control" type="text" name="tier" class="form-control" id="tier"
                                placeholder="sponsor tier">
                        </div>
                        <div class="mb-3">
                            <label for="hours" class="form-label">Duration in hours</label>
                            <input class="form-control" type="number" min="1" name="hours" class="form-control"
                                id="hours" placeholder="hours duration">
                        </div>
                        <div>
                            <label for="price" class="form-label">Set the price</label>
                            <input class="form-control" type="number" min="0.01" step="0.01" name="price"
                                class="form-control" id="price" placeholder="sponsor price">
                        </div>
                        <div class="mt-3 d-flex justify-content-center">
                            <button class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
    </section>
@endsection
